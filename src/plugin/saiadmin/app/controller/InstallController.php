<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\controller;

use Throwable;
use support\Request;
use support\Response;
use plugin\saiadmin\exception\ApiException;
use plugin\saiadmin\basic\OpenController;

/**
 * 安装控制器
 */
class InstallController extends OpenController
{
    /**
     * 不需要登录的方法
     */
    protected array $noNeedLogin = ['index', 'install'];

    /**
     * 应用名称
     * @var string
     */
    protected string $app = 'saiadmin';

    protected string $version = '5.0.0';

    /**
     * 安装首页
     */
    public function index()
    {
        $data['app'] = $this->app;
        $data['version'] = config('plugin.saiadmin.app.version', $this->version);        

        $env = base_path() . DIRECTORY_SEPARATOR .'.env';

        clearstatcache();
        if (is_file($env)) {
            $data['error'] = '程序已经安装';
            return view('install/error', $data);
        }

        if (!is_writable(base_path() . DIRECTORY_SEPARATOR . 'config')) {
            $data['error'] = '权限认证失败';
            return view('install/error', $data);
        }

        return view('install/index', $data);
    }

    /**
     * 执行安装
     */
    public function install(Request $request)
    {
        $env = base_path() . DIRECTORY_SEPARATOR .'.env';

        clearstatcache();
        if (is_file($env)) {
            return $this->fail('管理后台已经安装！如需重新安装，请删除根目录env配置文件并重启');
        }

        $user = $request->post('username');
        $password = $request->post('password');
        $database = $request->post('database');
        $host = $request->post('host');
        $port = (int)$request->post('port') ?: 3306;

        try {
            $db = $this->getPdo($host, $user, $password, $port);
            $smt = $db->query("show databases like '$database'");
            if (empty($smt->fetchAll())) {
                $db->exec("create database $database CHARSET utf8mb4 COLLATE utf8mb4_general_ci");
            }
        } catch (\Throwable $e) {
            $message = $e->getMessage();
            if (stripos($message, 'Access denied for user')) {
                return $this->fail('数据库用户名或密码错误');
            }
            if (stripos($message, 'Connection refused')) {
                return $this->fail('Connection refused. 请确认数据库IP端口是否正确，数据库已经启动');
            }
            if (stripos($message, 'timed out')) {
                return $this->fail('数据库连接超时，请确认数据库IP端口是否正确，安全组及防火墙已经放行端口');
            }
            throw $e;
        }

        $db->exec("use $database");

        $smt = $db->query("show tables like 'sa_system_menu';");
        $tables = $smt->fetchAll();
        if (count($tables) > 0) {
            return $this->fail('数据库已经安装，请勿重复安装');
        }

        $sql_file = base_path() . '/plugin/saiadmin/db/saiadmin-5.0.sql';
        if (!is_file($sql_file)) {
            return $this->fail('数据库SQL文件不存在');
        }

        $sql_query = file_get_contents($sql_file);

        $db->exec($sql_query);

        $this->generateConfig();

        $env_config = <<<EOF
# 数据库配置
DB_TYPE = mysql
DB_HOST = $host
DB_PORT = $port
DB_NAME = $database
DB_USER = $user
DB_PASSWORD = $password
DB_PREFIX = 

# 缓存方式
CACHE_MODE = file

# Redis配置
REDIS_HOST = 127.0.0.1
REDIS_PORT = 6379
REDIS_PASSWORD = ''
REDIS_DB = 0

# 验证码配置
CAPTCHA_MODE = cache
EOF;
        file_put_contents(base_path() . DIRECTORY_SEPARATOR . '.env', $env_config);

        // 尝试reload
        if (function_exists('posix_kill')) {
            set_error_handler(function () {});
            posix_kill(posix_getppid(), SIGUSR1);
            restore_error_handler();
        }

        return $this->success('安装成功');
    }

    /**
     * 生成配置文件 
     */
    protected function generateConfig()
    {
        // 1、think-orm配置文件
        $think_orm_config = <<<EOF
<?php

return [
    'default' => 'mysql',
    'connections' => [
        'mysql' => [
            // 数据库类型
            'type' => getenv('DB_TYPE'),
            // 服务器地址
            'hostname' => getenv('DB_HOST'),
            // 数据库名
            'database' => getenv('DB_NAME'),
            // 数据库用户名
            'username' => getenv('DB_USER'),
            // 数据库密码
            'password' => getenv('DB_PASSWORD'),
            // 数据库连接端口
            'hostport' => getenv('DB_PORT'),
            // 数据库连接参数
            'params' => [
                // 连接超时3秒
                \PDO::ATTR_TIMEOUT => 3,
            ],
            // 数据库编码默认采用utf8
            'charset' => 'utf8',
            // 数据库表前缀
            'prefix' => getenv('DB_PREFIX'),
            // 断线重连
            'break_reconnect' => true,
            // 自定义分页类
            'bootstrap' =>  '',
            // 连接池配置
            'pool' => [
                'max_connections' => 5, // 最大连接数
                'min_connections' => 1, // 最小连接数
                'wait_timeout' => 3,    // 从连接池获取连接等待超时时间
                'idle_timeout' => 60,   // 连接最大空闲时间，超过该时间会被回收
                'heartbeat_interval' => 50, // 心跳检测间隔，需要小于60秒
            ],
        ],
    ],
];
EOF;
        file_put_contents(base_path() . '/config/think-orm.php', $think_orm_config);

        // 2、chache配置文件
        $cache_config = <<<EOF
<?php

return [
    'default' => getenv('CACHE_MODE'),
    'stores' => [
        'file' => [
            'driver' => 'file',
            'path' => runtime_path('cache')
        ],
        'redis' => [
            'driver' => 'redis',
            'connection' => 'default'
        ],
        'array' => [
            'driver' => 'array'
        ]
    ]
];
EOF;
        file_put_contents(base_path() . '/config/cache.php', $cache_config);        

        // 3、redis配置文件
        $redis_config = <<<EOF
<?php

return [
    'default' => [
        'password' => getenv('REDIS_PASSWORD'),
        'host' => getenv('REDIS_HOST'),
        'port' => getenv('REDIS_PORT'),
        'database' => getenv('REDIS_DB'),
        'pool' => [
            'max_connections' => 5,
            'min_connections' => 1,
            'wait_timeout' => 3,
            'idle_timeout' => 60,
            'heartbeat_interval' => 50,
        ],
    ]
];
EOF;
        file_put_contents(base_path() . '/config/redis.php', $redis_config);

    }

    /**
     * 获取pdo连接
     * @param $host
     * @param $username
     * @param $password
     * @param $port
     * @param $database
     * @return \PDO
     */
    protected function getPdo($host, $username, $password, $port, $database = null): \PDO
    {
        $dsn = "mysql:host=$host;port=$port;";
        if ($database) {
            $dsn .= "dbname=$database";
        }
        $params = [
            \PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8mb4",
            \PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
            \PDO::ATTR_EMULATE_PREPARES => false,
            \PDO::ATTR_TIMEOUT => 5,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        ];
        return new \PDO($dsn, $username, $password, $params);
    }
}
