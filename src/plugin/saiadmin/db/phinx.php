<?php
// +----------------------------------------------------------------------
// | Phinx 迁移配置（独立于 webman 运行，vendor/bin/phinx 与 sai:migrate 共用）
// +----------------------------------------------------------------------
// | 随 saiadmin 插件走：与 migrations/ seeds/ 同目录，路径一律按 __DIR__ 解析，
// | 插件装在哪个项目里都不用改这个文件。
// | 直接用 Phinx CLI 时要显式指定它：
// |   vendor/bin/phinx status -c plugin/saiadmin/db/phinx.php
// +----------------------------------------------------------------------
// | 读取顺序：$_ENV → getenv() → server/.env → 默认值（与 .env.example 一致）。
// | webman 入口（php webman sai:migrate、网页安装向导）启动时已把 .env 载入 $_ENV；
// | 直接执行 vendor/bin/phinx 不经过 webman，所以这里自己兜底加载一次 .env。
// | 安装向导会在生成 .env 之前直接写入 $_ENV 来传入连接参数。
// | DB_TYPE 支持 mysql / pgsql，两者共用同一份迁移与种子数据。
// +----------------------------------------------------------------------

// plugin/saiadmin/db → server（webman 项目根目录）
$root = dirname(__DIR__, 3);

if (is_file($root . DIRECTORY_SEPARATOR . '.env')
    && class_exists(\Dotenv\Dotenv::class)
    && method_exists(\Dotenv\Dotenv::class, 'createUnsafeImmutable')
) {
    // Immutable：$_ENV / getenv 里已有的值优先，不会覆盖安装向导传入的参数
    \Dotenv\Dotenv::createUnsafeImmutable($root)->safeLoad();
}

$env = static function (string $key, string $default = ''): string {
    $value = $_ENV[$key] ?? getenv($key);

    return $value === false || $value === '' ? $default : (string) $value;
};

$type = strtolower($env('DB_TYPE', 'mysql'));
$type = in_array($type, ['pgsql', 'postgres', 'postgresql'], true) ? 'pgsql' : 'mysql';

$db = [
    'adapter' => $type,
    'host' => $env('DB_HOST', '127.0.0.1'),
    'port' => (int) $env('DB_PORT', $type === 'pgsql' ? '5432' : '3306'),
    'name' => $env('DB_NAME', 'saiadmin'),
    'user' => $env('DB_USER', $type === 'pgsql' ? 'postgres' : 'root'),
    'pass' => $env('DB_PASSWORD', ''),
];

if ($type === 'pgsql') {
    // PG 的表都建在 search_path 指定的 schema 下，默认 public；charset 由数据库编码决定
    $db['schema'] = $env('DB_SCHEMA', 'public');
} else {
    // 字符集与排序规则统一在这里指定，建表时不再逐表声明
    $db['charset'] = $env('DB_CHARSET', 'utf8mb4');
    $db['collation'] = $env('DB_COLLATION', 'utf8mb4_general_ci');
}

return [
    'paths' => [
        // 迁移与种子就在本目录下
        'migrations' => __DIR__ . DIRECTORY_SEPARATOR . 'migrations',
        'seeds' => __DIR__ . DIRECTORY_SEPARATOR . 'seeds',
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'db',
        'db' => $db,
    ],
];
