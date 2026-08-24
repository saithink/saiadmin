<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\utils;

/**
 * 数据库类型判断
 *
 * 元数据查询（表状态、字段信息）与表维护语句在 MySQL / PostgreSQL 下没有通用写法，
 * 需要分方言处理的地方用这里判断当前连接的类型。
 *
 * 当前框架实际使用的数据库类型由 server/.env 的 DB_TYPE 决定 —— `config/database.php`
 * （Eloquent）和 `config/think-orm.php`（think-orm）都是按它生成的，所以这里直接读它，
 * 不依赖某一套 ORM 的配置结构，框架换 ORM 不用改这个类。
 */
class DbType
{
    /**
     * 各 ORM 的配置根 => 驱动字段名
     *
     * 只在 .env 没配 DB_TYPE、或调用方显式指定了别的连接名时才用到。
     */
    protected const CONFIG_ROOTS = [
        'database' => 'driver',   // Eloquent（webman/database，support\Db）
        'think-orm' => 'type',    // think-orm（webman/think-orm，support\think\Db）
    ];

    /**
     * 取数据库类型
     *
     * @param string $source 连接名，空表示当前框架正在使用的连接（即 .env 的 DB_TYPE）
     * @return string mysql / pgsql，其他驱动原样返回
     */
    public static function get(string $source = ''): string
    {
        // 指定了连接名，说明要问的不一定是当前默认库，按连接名去配置里查
        if ($source !== '') {
            return self::normalize(self::fromConfig($source) ?: strtolower($source));
        }

        $type = strtolower(trim((string) env('DB_TYPE', '')));
        if ($type === '') {
            // .env 没配 DB_TYPE 时退回读配置里的默认连接
            $type = self::fromConfig('');
        }
        return self::normalize($type);
    }

    /**
     * 连接是否 PostgreSQL
     *
     * @param string $source 连接名，空表示当前框架正在使用的连接
     */
    public static function isPgsql(string $source = ''): bool
    {
        return self::get($source) === 'pgsql';
    }

    /**
     * 从 ORM 配置里取驱动名，两套结构都认，取不到返回空串
     *
     * @param string $source 连接名，空表示各套配置里的默认连接
     * @return string
     */
    protected static function fromConfig(string $source): string
    {
        foreach (self::CONFIG_ROOTS as $root => $driverKey) {
            $connections = config($root . '.connections');
            if (!is_array($connections) || empty($connections)) {
                continue;
            }
            $name = $source !== '' ? $source : (string) config($root . '.default', '');
            if ($name === '' || !isset($connections[$name]) || !is_array($connections[$name])) {
                continue;
            }
            $type = strtolower((string) ($connections[$name][$driverKey] ?? ''));
            if ($type !== '') {
                return $type;
            }
        }
        return '';
    }

    /**
     * 驱动名归一：PG 的几种叫法统一成 pgsql，取不到时按 mysql 处理
     *
     * @param string $type
     * @return string
     */
    protected static function normalize(string $type): string
    {
        if (in_array($type, ['pgsql', 'postgres', 'postgresql'], true)) {
            return 'pgsql';
        }
        return $type === '' ? 'mysql' : $type;
    }
}
