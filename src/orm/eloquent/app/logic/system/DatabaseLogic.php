<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\system;

use plugin\saiadmin\basic\eloquent\BaseLogic;
use plugin\saiadmin\exception\ApiException;
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
        if (!empty($query['source'])) {
            if (!empty($query['name'])) {
                $sql = 'show table status where name=:name ';
                $list = Db::connection($query['source'])->select($sql, ['name' => $query['name']]);
            } else {
                $list = Db::connection($query['source'])->select('show table status');
            }
        } else {
            if (!empty($query['name'])) {
                $sql = 'show table status where name=:name ';
                $list = Db::select($sql, ['name' => $query['name']]);
            } else {
                $list = Db::select('show table status');
            }
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
     * 获取列信息
     */
    public function getColumnList($table, $source): array
    {
        $columnList = [];
        if (preg_match("/^[a-zA-Z0-9_]+$/", $table)) {
            if (!empty($source)) {
                $list = Db::connection($source)->select('SHOW FULL COLUMNS FROM `' . $table . '`');
            } else {
                $list = Db::select('SHOW FULL COLUMNS FROM `' . $table . '`');
            }
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
        }
        return $columnList;
    }

    /**
     * 优化表
     */
    public function optimizeTable($tables)
    {
        foreach ($tables as $table) {
            if (preg_match("/^[a-zA-Z0-9_]+$/", $table)) {
                Db::statement('OPTIMIZE TABLE `' . $table . '`');
            }
        }
    }

    /**
     * 清理表碎片
     */
    public function fragmentTable($tables)
    {
        foreach ($tables as $table) {
            if (preg_match("/^[a-zA-Z0-9_]+$/", $table)) {
                Db::statement('ANALYZE TABLE `' . $table . '`');
            }
        }
    }

    /**
     * 获取回收站数据
     */
    public function recycleData($table)
    {
        if (preg_match("/^[a-zA-Z0-9_]+$/", $table)) {
            // 查询表字段
            $sql = 'SHOW COLUMNS FROM `' . $table . '` where Field = "delete_time"';
            $columns = Db::select($sql);
            $isDeleteTime = false;
            if (count($columns) > 0) {
                $isDeleteTime = true;
            }
            if (!$isDeleteTime) {
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
