<?php

namespace plugin\saiadmin\command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * SaiAdmin 插件创建命令
 * 用于创建 saiadmin 插件
 */
class SaiPlugin extends Command
{
    protected static $defaultName = 'sai:plugin';
    protected static $defaultDescription = '创建 SaiAdmin 插件';

    /**
     * @return void
     */
    protected function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED, 'App plugin name');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('SaiAdmin 插件创建工具');
        $io->text('此命令用于创建基于webman的 saiadmin 插件, 用于扩展 saiadmin 框架功能!');
        $io->newLine();

        $name = $input->getArgument('name');
        $io->text("创建 SaiAdmin 插件 $name");

        if (strpos($name, '/') !== false) {
            $io->error('名称错误,名称必须不包含字符 \'/\'');
            return self::FAILURE;
        }

        // Create dir config/plugin/$name
        if (is_dir($plugin_config_path = base_path() . "/plugin/$name")) {
            $io->error("目录 $plugin_config_path 已存在");
            return self::FAILURE;
        }

        $this->createAll($name);

        $io->newLine();
        $io->success("SaiAdmin 插件创建成功！");

        return self::SUCCESS;
    }

    /**
     * @param $name
     * @return void
     */
    protected function createAll($name)
    {
        $base_path = base_path();
        $this->mkdir("$base_path/plugin/$name/app", 0777, true);
        $this->mkdir("$base_path/plugin/$name/app/admin/controller", 0777, true);
        $this->mkdir("$base_path/plugin/$name/app/admin/logic", 0777, true);
        $this->mkdir("$base_path/plugin/$name/app/api/controller", 0777, true);
        $this->mkdir("$base_path/plugin/$name/app/api/logic", 0777, true);
        $this->mkdir("$base_path/plugin/$name/app/cache", 0777, true);
        $this->mkdir("$base_path/plugin/$name/app/event", 0777, true);
        $this->mkdir("$base_path/plugin/$name/app/model", 0777, true);
        $this->mkdir("$base_path/plugin/$name/app/middleware", 0777, true);
        $this->mkdir("$base_path/plugin/$name/config", 0777, true);
        $this->mkdir("$base_path/plugin/$name/db/migrations", 0777, true);
        $this->mkdir("$base_path/plugin/$name/db/seeds", 0777, true);
        $this->createControllerFile("$base_path/plugin/$name/app/api/controller/IndexController.php", $name);
        $this->createFunctionsFile("$base_path/plugin/$name/app/functions.php");
        $this->createConfigFiles("$base_path/plugin/$name/config", $name);
        $this->createMigrationFile("$base_path/plugin/$name/db/migrations", $name);
    }

    /**
     * 生成一份示例迁移
     *
     * 插件安装器按 db/migrations 里有没有文件来决定装法：有就跑 Phinx 迁移（MySQL / PG 通用），
     * 没有就退回老版 MySQL 专用的 install.sql。所以脚手架默认就把新插件做成迁移版。
     * 命名空间必须是 plugin\{name}\db\migrations —— 迁移类不带命名空间时，
     * 与核心或别的插件重名会在 require 阶段 fatal，直接打死进程。
     *
     * @param $path
     * @param $name
     * @return void
     */
    protected function createMigrationFile($path, $name)
    {
        $class = 'Create' . str_replace(' ', '', ucwords(str_replace('_', ' ', $name))) . 'Tables';
        $file = $path . '/' . date('YmdHis') . '_create_' . $name . '_tables.php';
        $content = <<<EOF
<?php

namespace plugin\\$name\\db\\migrations;

use Phinx\\Migration\\AbstractMigration;

// 复用核心的可移植建表助手（pkType / tableOptions / dropTables）。
// 只能 require 核心这一份，插件自带副本会重复声明 trait 而 fatal
require_once base_path() . '/plugin/saiadmin/db/support/SaiSchema.php';

final class $class extends AbstractMigration
{
    use \\SaiSchema;

    public function up(): void
    {
        // 写法约定见 plugin/saiadmin/db/README.md：
        // 只用可移植的 Phinx API、索引不命名、自增列用 identity + generated => null、
        // 时间列带 precision => 0，表名自带 sa_ 前缀（Phinx 不处理 DB_PREFIX）
        //
        // \$table = \$this->table('{$name}_demo', \$this->tableOptions('示例表'));
        // \$table->addColumn('id', \$this->pkType(), ['identity' => true, 'generated' => null, 'comment' => '主键'])
        //     ->addColumn('title', 'string', ['limit' => 100, 'default' => '', 'comment' => '标题'])
        //     ->addColumn('create_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '创建时间'])
        //     ->addIndex(['title'])
        //     ->create();
    }

    public function down(): void
    {
        // 卸载插件时会 rollback 到 0，这里必须把 up() 建的表和写入的菜单都清干净
        // \$this->dropTables(['{$name}_demo']);
    }
}

EOF;
        file_put_contents($file, $content);
    }

    /**
     * @param $path
     * @return void
     */
    protected function mkdir($path, $mode = 0777, $recursive = false)
    {
        if (is_dir($path)) {
            return;
        }
        echo "Create $path\r\n";
        mkdir($path, $mode, $recursive);
    }

    /**
     * @param $path
     * @param $name
     * @return void
     */
    protected function createControllerFile($path, $name)
    {
        $content = <<<EOF
<?php

namespace plugin\\$name\\app\\api\\controller;

use plugin\\saiadmin\\basic\\OpenController;

class IndexController extends OpenController
{

    public function index()
    {
        return \$this->success([
            'app' => '$name',
            'version' => '1.0.0',
        ]);
    }

}


EOF;
        file_put_contents($path, $content);

    }

    /**
     * @param $file
     * @return void
     */
    protected function createFunctionsFile($file)
    {
        $content = <<<EOF
<?php
/**
 * Here is your custom functions.
 */



EOF;
        file_put_contents($file, $content);
    }

    /**
     * @param $base
     * @param $name
     * @return void
     */
    protected function createConfigFiles($base, $name)
    {
        // app.php
        $content = <<<EOF
<?php

use support\\Request;

return [
    'debug' => true,
    'controller_suffix' => 'Controller',
    'controller_reuse' => false,
    'version' => '1.0.0'
];

EOF;
        file_put_contents("$base/app.php", $content);

        // autoload.php
        $content = <<<EOF
<?php
return [
    'files' => [
        base_path() . '/plugin/$name/app/functions.php',
    ]
];
EOF;
        file_put_contents("$base/autoload.php", $content);

        // container.php
        $content = <<<EOF
<?php
return new Webman\\Container;

EOF;
        file_put_contents("$base/container.php", $content);


        // exception.php
        $content = <<<EOF
<?php

return [
    '' => \\plugin\\saiadmin\\app\\exception\\Handler::class,
];

EOF;
        file_put_contents("$base/exception.php", $content);

        // log.php
        $content = <<<EOF
<?php

return [
    'default' => [
        'handlers' => [
            [
                'class' => Monolog\\Handler\\RotatingFileHandler::class,
                'constructor' => [
                    runtime_path() . '/logs/$name.log',
                    7,
                    Monolog\\Logger::DEBUG,
                ],
                'formatter' => [
                    'class' => Monolog\\Formatter\\LineFormatter::class,
                    'constructor' => [null, 'Y-m-d H:i:s', true],
                ],
            ]
        ],
    ],
];

EOF;
        file_put_contents("$base/log.php", $content);

        // middleware.php
        $content = <<<EOF
<?php

use plugin\saiadmin\app\middleware\SystemLog;
use plugin\saiadmin\app\middleware\CheckLogin;
use plugin\saiadmin\app\middleware\CheckAuth;

return [
    'admin' => [
        CheckLogin::class,
        CheckAuth::class,
        SystemLog::class,
    ],
    'api' => [
    ]
];

EOF;
        file_put_contents("$base/middleware.php", $content);

        // process.php
        $content = <<<EOF
<?php
return [];

EOF;
        file_put_contents("$base/process.php", $content);

        // route.php
        $content = <<<EOF
<?php

use Webman\\Route;


EOF;
        file_put_contents("$base/route.php", $content);

        // static.php
        $content = <<<EOF
<?php

return [
    'enable' => true,
    'middleware' => [],    // Static file Middleware
];

EOF;
        file_put_contents("$base/static.php", $content);

        // translation.php
        $content = <<<EOF
<?php

return [
    // Default language
    'locale' => 'zh_CN',
    // Fallback language
    'fallback_locale' => ['zh_CN', 'en'],
    // Folder where language files are stored
    'path' => base_path() . "/plugin/$name/resource/translations",
];

EOF;
        file_put_contents("$base/translation.php", $content);

    }

}
