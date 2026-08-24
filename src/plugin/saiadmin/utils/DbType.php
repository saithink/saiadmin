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
 */
class DbType
{
    /**
     * 取连接的数据库类型
     *
     * @param string $source 连接名，空表示当前默认连接
     * @return string mysql / pgsql，其他驱动原样返回
     */
    public static function get(string $source = ''): string
    {
        $connections = config('think-orm.connections', []);
        $name = $source !== '' ? $source : (string) config('think-orm.default', 'mysql');
        // 连接配置缺失时退回用连接名判断（本项目里连接名与驱动同名）
        $type = strtolower((string) ($connections[$name]['type'] ?? $name));

        if (in_array($type, ['pgsql', 'postgres', 'postgresql'], true)) {
            return 'pgsql';
        }
        return $type === '' ? 'mysql' : $type;
    }

    /**
     * 连接是否 PostgreSQL
     *
     * @param string $source 连接名，空表示当前默认连接
     */
    public static function isPgsql(string $source = ''): bool
    {
        return self::get($source) === 'pgsql';
    }
}
