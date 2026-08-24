<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\system;

use plugin\saiadmin\basic\eloquent\BaseLogic;
use plugin\saiadmin\exception\ApiException;
use plugin\saiadmin\utils\DbType;
use support\Db;

/**
 * 数据表维护逻辑层
 */
class DatabaseLogic extends BaseLogic
{
    /**
     * 获取数据源
     * @return array
     */
    public function getDbSource(): array
    {
        $data = config('database.connections');
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
        $connection = !empty($source) ? Db::connection($source) : Db::connection();

        // 表状态没有通用写法，按方言分开取，两边都归一成同一组键名
        $data = DbType::isPgsql($source)
            ? $this->pgsqlTableList($connection, $name)
            : $this->mysqlTableList($connection, $name);

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
     * @param $connection
     * @param string $name
     * @return array
     */
    protected function mysqlTableList($connection, string $name): array
    {
        if ($name !== '') {
            $list = $connection->select('show table status where name=:name ', ['name' => $name]);
        } else {
            $list = $connection->select('show table status');
        }

        $data = [];
        foreach ($list as $item) {
            $data[] = [
                'name' => $item->Name,
                'engine' => $item->Engine,
                'rows' => $item->Rows,
                'data_free' => $item->Data_free,
                'data_length' => $item->Data_length,
                'index_length' => $item->Index_length,
                'collation' => $item->Collation,
                'create_time' => $item->Create_time,
                'update_time' => $item->Update_time,
                'comment' => $item->Comment,
            ];
        }
        return $data;
    }

    /**
     * PostgreSQL 表状态
     *
     * 没有 show table status，从系统表里凑齐同样的字段：行数用 reltuples 估算值
     * （MySQL 的 Rows 对 InnoDB 同样是估算值），碎片大小没有对应概念固定给 0，
     * 建表时间 PG 不记录只能给 null，更新时间用最近一次 vacuum / analyze 的时间。
     *
     * @param $connection
     * @param string $name
     * @return array
     */
    protected function pgsqlTableList($connection, string $name): array
    {
        $sql = <<<'SQL'
            SELECT
                c.relname AS name,
                'PostgreSQL' AS engine,
                CASE WHEN c.reltuples < 0 THEN 0 ELSE c.reltuples::bigint END AS rows,
                0 AS data_free,
                pg_table_size(c.oid) AS data_length,
                pg_indexes_size(c.oid) AS index_length,
                (SELECT pg_encoding_to_char(encoding) FROM pg_database WHERE datname = current_database()) AS collation,
                NULL AS create_time,
                GREATEST(s.last_vacuum, s.last_autovacuum, s.last_analyze, s.last_autoanalyze) AS update_time,
                COALESCE(obj_description(c.oid, 'pg_class'), '') AS comment
            FROM pg_class c
            INNER JOIN pg_namespace n ON n.oid = c.relnamespace
            LEFT JOIN pg_stat_all_tables s ON s.relid = c.oid
            WHERE c.relkind = 'r'
              AND n.nspname = current_schema()
            SQL;

        if ($name !== '') {
            $list = $connection->select($sql . ' AND c.relname = ? ORDER BY c.relname', [$name]);
        } else {
            $list = $connection->select($sql . ' ORDER BY c.relname');
        }

        $data = [];
        foreach ($list as $item) {
            $data[] = [
                'name' => $item->name,
                'engine' => $item->engine,
                'rows' => (int) $item->rows,
                'data_free' => (int) $item->data_free,
                'data_length' => (int) $item->data_length,
                'index_length' => (int) $item->index_length,
                'collation' => $item->collation,
                'create_time' => $item->create_time,
                'update_time' => $item->update_time ? substr((string) $item->update_time, 0, 19) : null,
                'comment' => $item->comment,
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
        $connection = !empty($source) ? Db::connection($source) : Db::connection();

        return DbType::isPgsql($source)
            ? $this->pgsqlColumnList($connection, $table)
            : $this->mysqlColumnList($connection, $table);
    }

    /**
     * MySQL 字段信息
     * @param $connection
     * @param string $table
     * @return array
     */
    protected function mysqlColumnList($connection, string $table): array
    {
        $columnList = [];
        $list = $connection->select('SHOW FULL COLUMNS FROM `' . $table . '`');
        foreach ($list as $column) {
            preg_match('/^\w+/', $column->Type, $matches);
            $columnList[] = [
                'column_key' => $column->Key,
                'column_name' => $column->Field,
                'column_type' => $matches[0],
                'column_comment' => trim(preg_replace("/\([^()]*\)/", "", $column->Comment)),
                'extra' => $column->Extra,
                'default_value' => $column->Default,
                'is_nullable' => $column->Null,
            ];
        }
        return $columnList;
    }

    /**
     * PostgreSQL 字段信息
     *
     * 代码生成器与前端模板都是按 MySQL 那套词汇判断的（varchar / int / datetime、
     * PRI / UNI / MUL、extra = auto_increment），所以这里把 PG 的类型名归一过去，
     * 调用方不需要再判断数据库类型。
     *
     * @param $connection
     * @param string $table
     * @return array
     */
    protected function pgsqlColumnList($connection, string $table): array
    {
        $sql = <<<'SQL'
            SELECT
                a.attname AS column_name,
                format_type(a.atttypid, NULL) AS column_type,
                COALESCE(col_description(c.oid, a.attnum), '') AS column_comment,
                CASE WHEN a.attnotnull THEN 'NO' ELSE 'YES' END AS is_nullable,
                pg_get_expr(ad.adbin, ad.adrelid) AS default_value,
                CASE
                    WHEN EXISTS (SELECT 1 FROM pg_index i WHERE i.indrelid = c.oid AND i.indisprimary AND a.attnum = ANY(i.indkey)) THEN 'PRI'
                    WHEN EXISTS (SELECT 1 FROM pg_index i WHERE i.indrelid = c.oid AND i.indisunique AND a.attnum = ANY(i.indkey)) THEN 'UNI'
                    WHEN EXISTS (SELECT 1 FROM pg_index i WHERE i.indrelid = c.oid AND a.attnum = ANY(i.indkey)) THEN 'MUL'
                    ELSE ''
                END AS column_key,
                CASE
                    WHEN a.attidentity <> '' THEN 'auto_increment'
                    WHEN COALESCE(pg_get_expr(ad.adbin, ad.adrelid), '') LIKE 'nextval(%' THEN 'auto_increment'
                    ELSE ''
                END AS extra
            FROM pg_attribute a
            INNER JOIN pg_class c ON c.oid = a.attrelid
            INNER JOIN pg_namespace n ON n.oid = c.relnamespace
            LEFT JOIN pg_attrdef ad ON ad.adrelid = c.oid AND ad.adnum = a.attnum
            WHERE c.relname = ?
              AND n.nspname = current_schema()
              AND a.attnum > 0
              AND NOT a.attisdropped
            ORDER BY a.attnum
            SQL;

        $columnList = [];
        foreach ($connection->select($sql, [$table]) as $column) {
            $columnList[] = [
                'column_key' => $column->column_key,
                'column_name' => $column->column_name,
                'column_type' => $this->pgsqlTypeToMysql($column->column_type),
                'column_comment' => trim(preg_replace("/\([^()]*\)/", "", (string) $column->column_comment)),
                'extra' => $column->extra,
                'default_value' => $this->pgsqlDefaultValue($column->default_value),
                'is_nullable' => $column->is_nullable,
            ];
        }
        return $columnList;
    }

    /**
     * PG 类型名归一成 MySQL 的类型词汇
     * @param string|null $type
     * @return string
     */
    protected function pgsqlTypeToMysql(?string $type): string
    {
        // format_type 不带长度修饰，但数组类型会带 []，统一按基础类型处理
        $type = strtolower(trim(str_replace('[]', '', (string) $type)));
        $map = [
            'character varying' => 'varchar',
            'character' => 'char',
            'bpchar' => 'char',
            'text' => 'text',
            'integer' => 'int',
            'int4' => 'int',
            'bigint' => 'bigint',
            'int8' => 'bigint',
            'smallint' => 'smallint',
            'int2' => 'smallint',
            'numeric' => 'decimal',
            'double precision' => 'double',
            'real' => 'float',
            'boolean' => 'tinyint',
            'timestamp without time zone' => 'datetime',
            'timestamp with time zone' => 'timestamp',
            'time without time zone' => 'time',
            'time with time zone' => 'time',
            'date' => 'date',
            'bytea' => 'blob',
            'json' => 'json',
            'jsonb' => 'json',
            'uuid' => 'char',
        ];
        if (isset($map[$type])) {
            return $map[$type];
        }
        // 兜底取首个单词，例如 numeric(10,2) → numeric
        preg_match('/^\w+/', $type, $matches);
        return $matches[0] ?? $type;
    }

    /**
     * 剥掉 PG 默认值上的类型标注，例如 'abc'::character varying → abc
     * @param string|null $default
     * @return string|null
     */
    protected function pgsqlDefaultValue(?string $default): ?string
    {
        if ($default === null || $default === '') {
            return null;
        }
        // 自增列的 nextval(...) 不是业务默认值
        if (str_starts_with($default, 'nextval(')) {
            return null;
        }
        $value = preg_replace('/::[a-zA-Z0-9_ \[\]"]+$/', '', trim($default));
        if (preg_match("/^'(.*)'$/s", $value, $matches)) {
            return str_replace("''", "'", $matches[1]);
        }
        return $value;
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
                Db::statement($isPgsql ? 'ANALYZE "' . $table . '"' : 'ANALYZE TABLE `' . $table . '`');
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
                // PG 用 VACUUM FULL 重写表回收空间，对应 MySQL 的 OPTIMIZE TABLE
                Db::statement($isPgsql ? 'VACUUM FULL "' . $table . '"' : 'OPTIMIZE TABLE `' . $table . '`');
            }
        }
    }

    /**
     * 获取回收站数据
     */
    public function recycleData($table)
    {
        if (preg_match("/^[a-zA-Z0-9_]+$/", $table)) {
            // 字段存在性用 schema 构造器判断，方言由连接器自己处理，不要写 SHOW COLUMNS
            if (!Db::getSchemaBuilder()->hasColumn($table, 'delete_time')) {
                throw new ApiException('当前表不支持回收站功能');
            }
            // 查询软删除数据
            $request = request();
            $page = $request ? ($request->input('page') ?: 1) : 1;
            $limit = $request ? ($request->input('limit') ?: 10) : 10;
            $list = Db::table($table)->whereNotNull('delete_time')
                ->orderBy('delete_time', 'desc')
                ->paginate($limit, ['*'], 'page', $page);
            return [
                'current_page' => $list->currentPage(),
                'per_page' => $list->perPage(),
                'last_page' => $list->lastPage(),
                'has_more' => $list->hasMorePages(),
                'total' => $list->total(),
                'data' => $list->items(),
            ];
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
            $count = Db::table($table)->whereIn('id', $ids)->delete();
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
                ->whereIn('id', $ids)
                ->update(['delete_time' => null]);
            return $count > 0;
        } else {
            return false;
        }
    }

}
