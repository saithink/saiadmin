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
use plugin\saiadmin\utils\PhinxRunner;

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

    protected string $version = '6.0.0';

    /**
     * 支持的数据库类型 => 默认端口
     */
    protected const DB_TYPES = ['mysql' => 3306, 'pgsql' => 5432];

    /**
     * 安装首页
     */
    public function index()
    {
        $data['app'] = $this->app;
        $data['version'] = config('plugin.saiadmin.app.version', $this->version);

        $env = base_path() . DIRECTORY_SEPARATOR . '.env';

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
        $env = base_path() . DIRECTORY_SEPARATOR . '.env';

        clearstatcache();
        if (is_file($env)) {
            return $this->fail('管理后台已经安装！如需重新安装，请删除根目录env配置文件并重启');
        }

        $user = $request->post('username');
        $password = $request->post('password');
        $database = $request->post('database');
        $host = $request->post('host');
        $dbType = $this->normalizeDbType($request->post('dbType', 'mysql'));
        $port = (int) $request->post('port') ?: self::DB_TYPES[$dbType];
        $charset = $dbType === 'pgsql' ? 'utf8' : 'utf8mb4';
        $dataType = $request->post('dataType', 'demo');

        // 库名要拼进建库语句（标识符无法参数绑定），只放行字母数字下划线
        if (!is_string($database) || !preg_match('/^[A-Za-z0-9_]+$/', $database)) {
            return $this->fail('数据库名只能包含字母、数字和下划线');
        }

        // PostgreSQL 不带用户名时会退回操作系统账号，报错含义很难看懂，先挡在前面
        if (!is_string($host) || trim($host) === '' || !is_string($user) || trim($user) === '') {
            return $this->fail('数据库地址和用户名不能为空');
        }

        try {
            // PostgreSQL 没有"不指定库"的连接方式，建库阶段先连默认的 postgres 维护库
            $db = $this->getPdo($host, $user, $password, $port, null, $dbType);
            if (!$this->databaseExists($db, $dbType, $database)) {
                $this->createDatabase($db, $dbType, $database);
            }
            // PostgreSQL 不能用 use 切库，两种数据库统一重连到目标库
            $db = $this->getPdo($host, $user, $password, $port, $database, $dbType);
        } catch (\Throwable $e) {
            $message = $e->getMessage();
            // PostgreSQL 的报错文案跟随服务端语言环境，认证类错误统一按 SQLSTATE 判断
            if (in_array((string) $e->getCode(), ['28000', '28P01'], true)) {
                return $this->fail('数据库用户名或密码错误');
            }
            if (stripos($message, 'Access denied for user') || stripos($message, 'password authentication failed')) {
                return $this->fail('数据库用户名或密码错误');
            }
            if (stripos($message, 'Connection refused')) {
                return $this->fail('Connection refused. 请确认数据库IP端口是否正确，数据库已经启动');
            }
            if (stripos($message, 'timed out') || stripos($message, 'timeout expired')) {
                return $this->fail('数据库连接超时，请确认数据库IP端口是否正确，安全组及防火墙已经放行端口');
            }
            if (stripos($message, 'permission denied to create database')) {
                return $this->fail('当前数据库用户没有建库权限，请手动创建数据库后重试');
            }
            throw $e;
        }

        if ($this->tableExists($db, $dbType, 'sa_system_menu')) {
            return $this->fail('数据库已经安装，请勿重复安装');
        }

        // 将连接参数写入环境变量，供 plugin/saiadmin/db/phinx.php 读取（此时 .env 尚未生成）
        $_ENV['DB_TYPE'] = $dbType;
        $_ENV['DB_HOST'] = $host;
        $_ENV['DB_PORT'] = (string)$port;
        $_ENV['DB_NAME'] = $database;
        $_ENV['DB_USER'] = $user;
        $_ENV['DB_PASSWORD'] = $password;
        $_ENV['DB_CHARSET'] = $charset;

        // 数据库结构由 plugin/saiadmin/db/migrations 下的 Phinx 迁移管理
        $result = PhinxRunner::run('migrate');
        if (!$result['ok']) {
            return $this->fail('数据表初始化失败：' . PhinxRunner::errorTail($result['output']));
        }

        // 写入初始数据：demo 附带演示数据，pure 仅基础数据（seeder 不可重复执行）
        $seeder = $dataType == 'demo' ? 'DemoSeeder' : 'PureSeeder';
        $result = PhinxRunner::run('seed', ['--seed' => [$seeder]]);
        if (!$result['ok']) {
            return $this->fail('初始数据写入失败：' . PhinxRunner::errorTail($result['output']) . '。若数据库已被写入部分数据，请清空后重新安装');
        }

        $this->generateConfig();

        $env_config = <<<EOF
# 数据库配置
DB_TYPE = $dbType
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
DB_CHARSET = $charset

# 验证码配置
CAPTCHA_MODE = cache

#前端目录
FRONTEND_DIR = saiadmin-artd
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
     *
     * 生成的配置随 .env 的 DB_TYPE 自动切换 mysql / pgsql，
     * 连接名与驱动同名，保证 DatabaseLogic::getDbSource() 只列出可用的那一个
     */
    protected function generateConfig()
    {
        // 1、think-orm配置文件
        $think_orm_config = <<<'EOF'
<?php

// 连接名与驱动同名，由 .env 的 DB_TYPE 决定当前使用哪一个（mysql|pgsql）
$type = env('DB_TYPE', 'mysql');
$type = in_array($type, ['pgsql', 'postgres', 'postgresql'], true) ? 'pgsql' : 'mysql';
$isPgsql = $type === 'pgsql';

return [
    'default' => $type,
    'connections' => [
        $type => [
            // 数据库类型
            'type' => $type,
            // 服务器地址
            'hostname' => env('DB_HOST', '127.0.0.1'),
            // 数据库名
            'database' => env('DB_NAME', 'saiadmin'),
            // 数据库用户名
            'username' => env('DB_USER', $isPgsql ? 'postgres' : 'root'),
            // 数据库密码
            'password' => env('DB_PASSWORD', $isPgsql ? 'postgres' : '123456'),
            // 数据库连接端口
            'hostport' => env('DB_PORT', $isPgsql ? 5432 : 3306),
            // 数据库连接参数
            'params' => [
                // 连接超时3秒
                \PDO::ATTR_TIMEOUT => 3,
            ],
            // 数据库编码默认采用utf8
            'charset' => env('DB_CHARSET', $isPgsql ? 'utf8' : 'utf8mb4'),
            // 数据库表前缀
            'prefix' => env('DB_PREFIX', ''),
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
    'default' => env('CACHE_MODE', 'file'),
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
        'password' => env('REDIS_PASSWORD', ''),
        'host' => env('REDIS_HOST', '127.0.0.1'),
        'port' => env('REDIS_PORT', 6379),
        'database' => env('REDIS_DB', 0),
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

        // 4、think-cache配置文件
        $think_cache_config = <<<EOF
<?php
return [
    // 默认缓存驱动
    'default' => env('CACHE_MODE', 'file'),
    // 缓存连接方式配置
    'stores'  => [
        // redis缓存
        'redis' => [
            // 驱动方式
            'type' => 'redis',
            // 服务器地址
            'host' => env('REDIS_HOST', '127.0.0.1'),
            // 服务器端口
            'port' => env('REDIS_PORT', 6379),
            // 服务器密码
            'password' => env('REDIS_PASSWORD', ''),
            // 数据库
            'select' => env('REDIS_DB', 0),
            // 缓存前缀
            'prefix' => 'cache:',
            // 默认缓存有效期 0表示永久缓存
            'expire'     => 0,
            // Thinkphp官方没有这个参数，由于生成的tag键默认不过期，如果tag键数量很大，避免长时间占用内存，可以设置一个超过其他缓存的过期时间，0为不设置
            'tag_expire' => 86400 * 30,
            // 缓存标签前缀
            'tag_prefix' => 'tag:',
            // 连接池配置
            'pool' => [
                'max_connections' => 5, // 最大连接数
                'min_connections' => 1, // 最小连接数
                'wait_timeout' => 3,    // 从连接池获取连接等待超时时间
                'idle_timeout' => 60,   // 连接最大空闲时间，超过该时间会被回收
                'heartbeat_interval' => 50, // 心跳检测间隔，需要小于60秒
            ],
        ],
        // 文件缓存
        'file' => [
            // 驱动方式
            'type' => 'file',
            // 设置不同的缓存保存目录
            'path' => runtime_path() . '/file/',
        ],
    ],
];
EOF;
        file_put_contents(base_path() . '/config/think-cache.php', $think_cache_config);

        // 5、database配置文件
        $database = <<<'EOF'
<?php

// 连接名与驱动同名，由 .env 的 DB_TYPE 决定当前使用哪一个（mysql|pgsql）
$type = env('DB_TYPE', 'mysql');
$type = in_array($type, ['pgsql', 'postgres', 'postgresql'], true) ? 'pgsql' : 'mysql';
$isPgsql = $type === 'pgsql';

return [
    'default' => $type,
    'connections' => [
        $type => array_merge([
            'driver' => $type,
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', $isPgsql ? 5432 : 3306),
            'database' => env('DB_NAME', 'saiadmin'),
            'username' => env('DB_USER', $isPgsql ? 'postgres' : 'root'),
            'password' => env('DB_PASSWORD', $isPgsql ? 'postgres' : '123456'),
            'charset' => env('DB_CHARSET', $isPgsql ? 'utf8' : 'utf8mb4'),
            'prefix' => env('DB_PREFIX', ''),
            'options' => [
                PDO::ATTR_EMULATE_PREPARES => false, // Must be false for Swoole and Swow drivers.
            ],
            'pool' => [
                'max_connections' => 5,
                'min_connections' => 1,
                'wait_timeout' => 3,
                'idle_timeout' => 60,
                'heartbeat_interval' => 50,
            ],
        ], $isPgsql ? [
            'schema' => env('DB_SCHEMA', 'public'),
            'sslmode' => env('DB_SSLMODE', 'prefer'),
        ] : [
            'collation' => env('DB_COLLATION', 'utf8mb4_general_ci'),
            'strict' => true,
            'engine' => null,
        ]),
    ],
];
EOF;
        file_put_contents(base_path() . '/config/database.php', $database);

    }

    /**
     * 归一化数据库类型，只支持 mysql / pgsql
     * @param mixed $type
     */
    protected function normalizeDbType($type): string
    {
        $type = strtolower(trim((string) $type));
        return in_array($type, ['pgsql', 'postgres', 'postgresql'], true) ? 'pgsql' : 'mysql';
    }

    /**
     * 数据库是否已存在
     */
    protected function databaseExists(\PDO $db, string $dbType, string $database): bool
    {
        $sql = $dbType === 'pgsql'
            ? 'SELECT 1 FROM pg_database WHERE datname = ?'
            : 'SELECT 1 FROM information_schema.SCHEMATA WHERE SCHEMA_NAME = ?';
        $smt = $db->prepare($sql);
        $smt->execute([$database]);
        return (bool) $smt->fetchColumn();
    }

    /**
     * 创建数据库
     */
    protected function createDatabase(\PDO $db, string $dbType, string $database): void
    {
        if ($dbType !== 'pgsql') {
            $db->exec("create database `$database` CHARSET utf8mb4 COLLATE utf8mb4_general_ci");
            return;
        }
        try {
            $db->exec("CREATE DATABASE \"$database\" ENCODING 'UTF8'");
        } catch (\Throwable $e) {
            // 集群模板库不是 UTF8 时无法从 template1 复制，退回 template0 + C 排序
            $db->exec("CREATE DATABASE \"$database\" TEMPLATE template0 ENCODING 'UTF8' LC_COLLATE 'C' LC_CTYPE 'C'");
        }
    }

    /**
     * 目标库中是否已存在指定表
     */
    protected function tableExists(\PDO $db, string $dbType, string $table): bool
    {
        $sql = $dbType === 'pgsql'
            ? 'SELECT 1 FROM information_schema.tables WHERE table_schema = current_schema() AND table_name = ?'
            : 'SELECT 1 FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ?';
        $smt = $db->prepare($sql);
        $smt->execute([$table]);
        return (bool) $smt->fetchColumn();
    }

    /**
     * 获取pdo连接
     * @param $host
     * @param $username
     * @param $password
     * @param $port
     * @param $database 为空时连接服务器默认库（PostgreSQL 为 postgres）
     * @param $dbType mysql|pgsql
     * @return \PDO
     */
    protected function getPdo($host, $username, $password, $port, $database = null, string $dbType = 'mysql'): \PDO
    {
        $params = [
            \PDO::ATTR_EMULATE_PREPARES => false,
            \PDO::ATTR_TIMEOUT => 5,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        ];
        if ($dbType === 'pgsql') {
            $dsn = "pgsql:host=$host;port=$port;dbname=" . ($database ?: 'postgres');
        } else {
            $dsn = "mysql:host=$host;port=$port;";
            if ($database) {
                $dsn .= "dbname=$database";
            }
            $initCommand = class_exists(\Pdo\Mysql::class)
                ? \Pdo\Mysql::ATTR_INIT_COMMAND
                : \PDO::MYSQL_ATTR_INIT_COMMAND;
            $bufferedQuery = class_exists(\Pdo\Mysql::class)
                ? \Pdo\Mysql::ATTR_USE_BUFFERED_QUERY
                : \PDO::MYSQL_ATTR_USE_BUFFERED_QUERY;
            $params[$initCommand] = 'set names utf8mb4';
            $params[$bufferedQuery] = true;
        }
        return new \PDO($dsn, $username, $password, $params);
    }
}
