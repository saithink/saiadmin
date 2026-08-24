<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\system;

use plugin\saiadmin\basic\think\BaseLogic;
use plugin\saiadmin\exception\ApiException;
use plugin\saiadmin\utils\DbType;
use support\think\Db;

/**
 * 数据表维护逻辑层
 */
class DatabaseLogic extends BaseLogic
{
    /**
     * 取连接对象
     * @param string $source 连接名，空表示默认连接
     */
    protected function connection(string $source = '')
    {
        return Db::connect($source !== '' ? $source : null);
    }

    /**
     * 获取数据源
     * @return array
     */
    public function getDbSource(): array
    {
        $data = config('think-orm.connections');
        $list = [];
        foreach ($data as $k => $v) {
            $list[] = $k;
        }
        return $list;
    }

    /**
     * 数据列表
     * @param $query
     * @return mixed
     */
    public function getList($query): mixed
    {
        $request = request();
        $page = $request ? ($request->input('page') ?: 1) : 1;
        $limit = $request ? ($request->input('limit') ?: 10) : 10;

        return self::getTableList($query, $page, $limit);
    }

    /**
     * 获取数据库表数据
     */
    public function getTableList($query, $current_page = 1, $per_page = 10): array
    {
        $source = $query['source'] ?? '';
        $name = $query['name'] ?? '';
        $data = DbType::isPgsql($source) ? $this->pgsqlTableList($source, $name) : $this->mysqlTableList($source, $name);

        $total = count($data);
        $last_page = ceil($total / $per_page);
        $startIndex = ($current_page - 1) * $per_page;
        $pageData = array_slice($data, $startIndex, $per_page);
        return [
            'data' => $pageData,
            'total' => $total,
            'current_page' => $current_page,
            'per_page' => $per_page,
            'last_page' => $last_page,
        ];
    }

    /**
     * MySQL 表状态
     */
    protected function mysqlTableList(string $source, string $name): array
    {
        $sql = 'show table status';
        $bind = [];
        if ($name !== '') {
            $sql .= ' where name=:name';
            $bind = ['name' => $name];
        }
        $list = $this->connection($source)->query($sql, $bind);

        $data = [];
        foreach ($list as $item) {
            $data[] = [
                'name' => $item['Name'],
                'engine' => $item['Engine'],
                'rows' => $item['Rows'],
                'data_free' => $item['Data_free'],
                'data_length' => $item['Data_length'],
                'index_length' => $item['Index_length'],
                'collation' => $item['Collation'],
                'create_time' => $item['Create_time'],
                'update_time' => $item['Update_time'],
                'comment' => $item['Comment'],
            ];
        }
        return $data;
    }

    /**
     * PostgreSQL 表状态
     *
     * PG 没有 show table status，字段从 pg_catalog 拼出来：
     * - engine 用表的访问方法（一般是 heap），对应 MySQL 的存储引擎
     * - rows 是 reltuples 统计估算值（MySQL 的 InnoDB 行数同样是估算）
     * - data_free 用死元组数乘以平均行长估算膨胀字节数，作为"碎片大小"的近似
     * - collation 取数据库级排序规则，PG 没有表级排序规则
     * - create_time / update_time PG 不记录，只能留空
     */
    protected function pgsqlTableList(string $source, string $name): array
    {
        $sql = <<<'SQL'
SELECT c.relname AS name,
       COALESCE(am.amname, '') AS engine,
       GREATEST(c.reltuples, 0)::bigint AS rows,
       CASE WHEN c.reltuples > 0
            THEN (COALESCE(s.n_dead_tup, 0) * (pg_relation_size(c.oid) / c.reltuples))::bigint
            ELSE 0 END AS data_free,
       pg_table_size(c.oid) AS data_length,
       pg_indexes_size(c.oid) AS index_length,
       (SELECT datcollate FROM pg_database WHERE datname = current_database()) AS collation,
       COALESCE(obj_description(c.oid, 'pg_class'), '') AS comment
FROM pg_class c
JOIN pg_namespace n ON n.oid = c.relnamespace AND n.nspname = current_schema()
LEFT JOIN pg_am am ON am.oid = c.relam
LEFT JOIN pg_stat_user_tables s ON s.relid = c.oid
WHERE c.relkind IN ('r', 'p')
SQL;
        $bind = [];
        if ($name !== '') {
            $sql .= ' AND c.relname = :name';
            $bind = ['name' => $name];
        }
        $sql .= ' ORDER BY c.relname';
        $list = $this->connection($source)->query($sql, $bind);

        $data = [];
        foreach ($list as $item) {
            $data[] = [
                'name' => $item['name'],
                'engine' => $item['engine'],
                'rows' => $item['rows'],
                'data_free' => $item['data_free'],
                'data_length' => $item['data_length'],
                'index_length' => $item['index_length'],
                'collation' => $item['collation'],
                'create_time' => null,
                'update_time' => null,
                'comment' => $item['comment'],
            ];
        }
        return $data;
    }

    /**
     * 获取列信息
     */
    public function getColumnList($table, $source): array
    {
        if (!preg_match("/^[a-zA-Z0-9_]+$/", $table)) {
            return [];
        }
        $source = (string) $source;
        return DbType::isPgsql($source) ? $this->pgsqlColumnList($table, $source) : $this->mysqlColumnList($table, $source);
    }

    /**
     * MySQL 字段信息
     */
    protected function mysqlColumnList(string $table, string $source): array
    {
        $list = $this->connection($source)->query('SHOW FULL COLUMNS FROM `' . $table . '`');

        $columnList = [];
        foreach ($list as $column) {
            preg_match('/^\w+/', $column['Type'], $matches);
            $columnList[] = [
                'column_key' => $column['Key'],
                'column_name' => $column['Field'],
                'column_type' => $matches[0],
                'column_comment' => $this->cleanComment($column['Comment']),
                'extra' => $column['Extra'],
                'default_value' => $column['Default'],
                'is_nullable' => $column['Null'],
            ];
        }
        return $columnList;
    }

    /**
     * PostgreSQL 字段信息
     *
     * 输出结构与 MySQL 的 SHOW FULL COLUMNS 保持一致（代码生成器按这套键名取值）：
     * - column_type 统一成 MySQL 的类型名，生成器与前端模板都是按 varchar / int / datetime 这套词汇判断的
     * - column_key 用 PRI / UNI / MUL 表示主键、唯一索引、普通索引
     * - extra 对 serial 与 identity 列输出 auto_increment，与 MySQL 对齐
     */
    protected function pgsqlColumnList(string $table, string $source): array
    {
        $sql = <<<'SQL'
SELECT a.attname AS column_name,
       format_type(a.atttypid, a.atttypmod) AS column_type,
       CASE WHEN a.attnotnull THEN 'NO' ELSE 'YES' END AS is_nullable,
       COALESCE(pg_get_expr(d.adbin, d.adrelid), '') AS default_value,
       COALESCE(col_description(c.oid, a.attnum), '') AS column_comment,
       a.attidentity AS identity,
       CASE
           WHEN EXISTS (SELECT 1 FROM pg_index i
                        WHERE i.indrelid = c.oid AND i.indisprimary AND a.attnum = ANY (i.indkey)) THEN 'PRI'
           WHEN EXISTS (SELECT 1 FROM pg_index i
                        WHERE i.indrelid = c.oid AND i.indisunique AND NOT i.indisprimary
                          AND a.attnum = ANY (i.indkey)) THEN 'UNI'
           WHEN EXISTS (SELECT 1 FROM pg_index i
                        WHERE i.indrelid = c.oid AND a.attnum = ANY (i.indkey)) THEN 'MUL'
           ELSE ''
       END AS column_key
FROM pg_class c
JOIN pg_namespace n ON n.oid = c.relnamespace AND n.nspname = current_schema()
JOIN pg_attribute a ON a.attrelid = c.oid AND a.attnum > 0 AND NOT a.attisdropped
LEFT JOIN pg_attrdef d ON d.adrelid = c.oid AND d.adnum = a.attnum
WHERE c.relkind IN ('r', 'p') AND c.relname = :table
ORDER BY a.attnum
SQL;
        $list = $this->connection($source)->query($sql, ['table' => $table]);

        $columnList = [];
        foreach ($list as $column) {
            $default = (string) $column['default_value'];
            $isAutoInc = $column['identity'] !== '' || str_starts_with($default, 'nextval(');
            $columnList[] = [
                'column_key' => $column['column_key'],
                'column_name' => $column['column_name'],
                'column_type' => $this->pgsqlColumnType($column['column_type']),
                'column_comment' => $this->cleanComment($column['column_comment']),
                // 自增列在 MySQL 下 Default 为空、Extra 为 auto_increment，这里对齐
                'extra' => $isAutoInc ? 'auto_increment' : '',
                'default_value' => $isAutoInc ? null : $this->pgsqlDefaultValue($default),
                'is_nullable' => $column['is_nullable'],
            ];
        }
        return $columnList;
    }

    /**
     * PostgreSQL 类型名转成 MySQL 的类型名
     *
     * @param string $type format_type() 的结果，如 character varying(50)、numeric(10,2)
     */
    protected function pgsqlColumnType(string $type): string
    {
        // 去掉长度、精度与数组后缀，只保留类型名
        $name = strtolower(trim(preg_replace(['/\([^()]*\)/', '/\[\]$/'], '', $type)));
        $map = [
            'integer' => 'int',
            'bigint' => 'bigint',
            'smallint' => 'smallint',
            'boolean' => 'tinyint',
            'character varying' => 'varchar',
            'character' => 'char',
            'text' => 'text',
            'numeric' => 'decimal',
            'double precision' => 'double',
            'real' => 'float',
            'money' => 'decimal',
            'date' => 'date',
            'timestamp without time zone' => 'datetime',
            'timestamp with time zone' => 'datetime',
            'time without time zone' => 'time',
            'time with time zone' => 'time',
            'jsonb' => 'json',
            'json' => 'json',
            'bytea' => 'blob',
        ];
        if (isset($map[$name])) {
            return $map[$name];
        }
        // 未收录的类型（uuid、inet、interval 等）取第一个单词，与 MySQL 分支的处理方式一致
        preg_match('/^\w+/', $name, $matches);
        return $matches[0] ?? $name;
    }

    /**
     * PostgreSQL 默认值转成 MySQL 风格
     *
     * pg_get_expr() 返回的是表达式，如 '1'::smallint、'待处理'::character varying、CURRENT_TIMESTAMP，
     * 这里剥掉类型标注与引号，让代码生成器拿到的默认值与 MySQL 一致。
     */
    protected function pgsqlDefaultValue(string $default): ?string
    {
        if ($default === '' || strtoupper($default) === 'NULL') {
            return null;
        }
        $value = preg_replace('/::[a-zA-Z0-9_ ]+(\[\])?$/', '', trim($default));
        if (preg_match("/^'(.*)'$/s", $value, $matches)) {
            // PG 里的单引号是成对转义的
            return str_replace("''", "'", $matches[1]);
        }
        return $value;
    }

    /**
     * 清理字段注释
     *
     * 注释里常带 (1正常 2停用) 这类取值说明，生成器只需要前面的名称
     */
    protected function cleanComment(?string $comment): string
    {
        return trim(preg_replace("/\([^()]*\)/", "", (string) $comment));
    }

    /**
     * 优化表
     */
    public function optimizeTable($tables)
    {
        $isPgsql = DbType::isPgsql();
        foreach ($tables as $table) {
            if (preg_match("/^[a-zA-Z0-9_]+$/", $table)) {
                // PG 的 ANALYZE 不带 TABLE 关键字
                $sql = $isPgsql ? 'ANALYZE "' . $table . '"' : 'ANALYZE TABLE `' . $table . '`';
                Db::execute($sql);
            }
        }
    }

    /**
     * 清理表碎片
     */
    public function fragmentTable($tables)
    {
        $isPgsql = DbType::isPgsql();
        foreach ($tables as $table) {
            if (preg_match("/^[a-zA-Z0-9_]+$/", $table)) {
                // VACUUM FULL 是 PG 里与 OPTIMIZE TABLE 对应的操作：重写整表回收空间，
                // 期间持有排他锁（MySQL 的 OPTIMIZE TABLE 同样会重建表），大表请在低峰执行
                $sql = $isPgsql ? 'VACUUM FULL "' . $table . '"' : 'OPTIMIZE TABLE `' . $table . '`';
                Db::execute($sql);
            }
        }
    }

    /**
     * 获取回收站数据
     */
    public function recycleData($table)
    {
        if (preg_match("/^[a-zA-Z0-9_]+$/", $table)) {
            // 字段列表由连接器按方言查询，两种数据库通用
            if (!in_array('delete_time', Db::getTableFields($table), true)) {
                throw new ApiException('当前表不支持回收站功能');
            }
            // 查询软删除数据
            $request = request();
            $limit = $request ? ($request->input('limit') ?: 10) : 10;
            return Db::table($table)->whereNotNull('delete_time')
                ->order('delete_time', 'desc')
                ->paginate($limit)
                ->toArray();
        } else {
            return [];
        }
    }

    /**
     * 删除数据
     * @param $table
     * @param $ids
     * @return bool
     */
    public function delete($table, $ids)
    {
        if (preg_match("/^[a-zA-Z0-9_]+$/", $table)) {
            $count = Db::table($table)->whereIn('id', $ids)->delete($ids);
            return $count > 0;
        } else {
            return false;
        }
    }

    /**
     * 恢复数据
     * @param $table
     * @param $ids
     * @return bool
     */
    public function recovery($table, $ids)
    {
        if (preg_match("/^[a-zA-Z0-9_]+$/", $table)) {
            $count = Db::table($table)
                ->where('id', 'in', $ids)
                ->update(['delete_time' => null]);
            return $count > 0;
        } else {
            return false;
        }
    }

}
