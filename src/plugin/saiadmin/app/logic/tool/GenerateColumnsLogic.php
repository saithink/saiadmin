<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\tool;

use plugin\saiadmin\app\model\tool\GenerateColumns;
use plugin\saiadmin\basic\BaseLogic;
use plugin\saiadmin\utils\Helper;

/**
 * 代码生成业务字段逻辑层
 */
class GenerateColumnsLogic extends BaseLogic
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->model = new GenerateColumns();
    }

    public function saveExtra($data)
    {
        $default_column = ['create_time', 'update_time', 'created_by', 'updated_by', 'delete_time', 'remark'];
        // 组装数据
        foreach ($data as $k => $item) {

            if ($item['column_name'] == 'delete_time') {
                continue;
            }

            $column = [
                'table_id' => $item['table_id'],
                'column_name' => $item['column_name'],
                'column_comment' => $item['column_comment'],
                'column_type' => $item['column_type'],
                'default_value' => $item['default_value'],
                'is_pk' => ($item['column_key'] == 'PRI') ? 2 : 1 ,
                'is_required' => $item['is_nullable'] == 'NO' ? 2 : 1,
                'query_type' => 'eq',
                'view_type' => 'input',
                'sort' => count($data) - $k,
                'allow_roles' => $item['allow_roles'] ?? null,
                'options' => $item['options'] ?? null
            ];

            // 设置默认选项
            if (!in_array($item['column_name'], $default_column) && empty($item['column_key'])) {
                $column = array_merge(
                    $column,
                    [
                        'is_insert' => 2,
                        'is_edit' => 2,
                        'is_list' => 2,
                        'is_query' => 1,
                        'is_sort' => 1,
                    ]
                );
            }
             $keyList = array(
                'is_insert', 'is_edit', 'is_list', 'is_query', 'query_type',
                'view_type', 'dict_type', 'allow_roles', 'remark', 'options','is_cover','is_required','is_pk'
            );
            foreach ($keyList as $key) {
                if (isset($item[$key])) $column[$key] = $item[$key];
            }
            GenerateColumns::create($this->fieldDispose($column));
        }
    }

    public function update($data, $where)
    {
        $data['is_insert'] = $data['is_insert'] ? 2 : 1;
        $data['is_edit'] = $data['is_edit'] ? 2 : 1;
        $data['is_list'] = $data['is_list'] ? 2 : 1;
        $data['is_query'] = $data['is_query'] ? 2 : 1;
        $data['is_sort'] = $data['is_sort'] ? 2 : 1;
        $data['is_required'] = $data['is_required'] ? 2 : 1;
        $this->model->update($data, $where);
    }

    private function fieldDispose(array $column): array
    {
        $object = new class {
            public function viewTypeDispose(&$column): void
            {
                switch ($column['column_type']) {
                    case 'varchar':
                        $column['view_type'] = 'input';
                        break;
                    // 富文本
                    case 'text':
                    case 'longtext':
                        $column['is_list'] = 1;
                        $column['is_query'] = 1;
                        $column['view_type'] = 'editor';
                        break;
                    // 日期字段
                    case 'timestamp':
                    case 'datetime':
                        $column['view_type'] = 'date';
                        $column['options'] = [];
                        $column['options']['mode'] = 'date';
                        $column['options']['showTime'] = true;
                        $column['options']['range'] = true;
                        $column['query_type'] = 'between';
                        break;
                    case 'date':
                        $column['view_type'] = 'date';
                        $column['options'] = [];
                        $column['options']['mode'] = 'date';
                        $column['options']['showTime'] = false;
                        $column['options']['range'] = true;
                        $column['query_type'] = 'between';
                        break;
                    case 'json':
                        $column['is_list'] = 1;
                        $column['is_query'] = 1;
                        break;
                }
            }

            public function columnName(&$column): void
            {
                if (stristr($column['column_name'], 'name')) {
                    $column['is_query'] = 2;
                    $column['is_required'] = 2;
                    $column['query_type'] = 'like';
                }

                if (stristr($column['column_name'], 'type')) {
                    $column['is_query'] = 2;
                    $column['is_required'] = 2;
                    $column['query_type'] = 'eq';
                }

                if (stristr($column['column_name'], 'image')) {
                    $column['is_query'] = 1;
                    $column['view_type'] = 'upload';
                    $column['options'] = [];
                    $column['options']['type'] = 'image';
                    $column['options']['returnType'] = 'url';
                    $column['options']['multiple'] = false;
                    $column['query_type'] = 'eq';
                }

                if (stristr($column['column_name'], 'images')) {
                    $column['is_query'] = 1;
                    $column['view_type'] = 'upload';
                    $column['options'] = [];
                    $column['options']['type'] = 'image';
                    $column['options']['returnType'] = 'url';
                    $column['options']['multiple'] = true;
                    $column['query_type'] = 'eq';
                }

                if (stristr($column['column_name'], 'file')) {
                    $column['is_query'] = 1;
                    $column['view_type'] = 'upload';
                    $column['options'] = [];
                    $column['options']['type'] = 'file';
                    $column['options']['returnType'] = 'url';
                    $column['options']['multiple'] = false;
                    $column['query_type'] = 'eq';
                }

                if (stristr($column['column_name'], 'files')) {
                    $column['is_query'] = 1;
                    $column['view_type'] = 'upload';
                    $column['options'] = [];
                    $column['options']['type'] = 'file';
                    $column['options']['returnType'] = 'url';
                    $column['options']['multiple'] = true;
                    $column['query_type'] = 'eq';
                }
            }
        };
        if(!$column['is_cover']) {
            $object->viewTypeDispose($column);
            $object->columnName($column);
        }
        $column['options'] = json_encode($column['options'], JSON_UNESCAPED_UNICODE);
        return $column;
    }

}
