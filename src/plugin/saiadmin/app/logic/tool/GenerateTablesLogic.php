<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\tool;

use plugin\saiadmin\app\model\tool\GenerateTables;
use plugin\saiadmin\app\model\tool\GenerateColumns;
use plugin\saiadmin\basic\BaseLogic;
use plugin\saiadmin\exception\ApiException;
use plugin\saiadmin\utils\Helper;
use plugin\saiadmin\utils\Template;
use plugin\saiadmin\utils\Zip;

/**
 * 代码生成业务逻辑层
 */
class GenerateTablesLogic extends BaseLogic
{

    protected $columnLogic = null;
    protected $dataLogic = null;

    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->model = new GenerateTables();
        $this->columnLogic = new GenerateColumnsLogic();
        $this->dataLogic = new DataMaintainLogic();
    }

    /**
     * 删除表和字段信息
     * @param $ids
     * @return void
     */
    public function destroy($ids)
    {
        $this->transaction(function () use ($ids) {
            $this->model->destroy($ids);
            GenerateColumns::destroy(function ($query) use ($ids) {
                $query->where('table_id', 'in', $ids);
            });
        });
    }

    /**
     * 装载表信息
     * @param $names
     * @return void
     */
    public function loadTable($names)
    {
        $config = config('thinkorm.connections')['mysql'];
        $prefix = $config['prefix'];
        foreach ($names as $item) {
            $class_name = Helper::camel(Helper::str_replace_once($prefix, '', $item['name']));
            $tableInfo = [
                'table_name' => $item['name'],
                'table_comment' => $item['comment'],
                'menu_name' => $item['comment'],
                'tpl_category' => 'single',
                'template' => 'saiadmin',
                'namespace' => 'app\cms',
                'package_name' => '',
                'business_name' => Helper::get_business($item['name']),
                'class_name' => $class_name,
                'generate_menus' => 'save,update,read,delete,recycle,recovery',
            ];
            $model = GenerateTables::create($tableInfo);
            $columns = $this->dataLogic->getColumnList($item['name']);
            foreach ($columns as &$column) {
                $column['table_id'] = $model->id;
            }
            $this->columnLogic->saveExtra($columns);
        }
    }

    /**
     * 同步表字段信息
     * @param $id
     * @return void
     */
    public function sync($id)
    {
        $model = $this->find($id);
        $this->columnLogic->destroy(function ($query) use ($id) {
            $query->where('table_id', $id);
        }, true);
        $columns = $this->dataLogic->getColumnList($model->table_name);
        foreach ($columns as &$column) {
            $column['table_id'] = $model->id;
        }
        $this->columnLogic->saveExtra($columns);
    }

    /**
     * 代码预览
     * @param $id
     * @return array
     */
    public function preview($id): array
    {
        $table = $this->find($id)->toArray();
        $columns = $this->columnLogic->where('table_id', $id)->select()->toArray();
        $pk = 'id';
        foreach ($columns as &$column) {
            if ($column['is_pk'] == 2) {
                $pk = $column['column_name'];
            }
            if ($column['column_name'] == 'delete_time') {
                unset($column['column_name']);
            }
        }

        $template_name = '/plugin/saiadmin/stub/'.$table['template'];
        $tpl = new Template($template_name);
        $tpl->assign('pk', $pk);
        $tpl->assignArray($table);
        $tpl->assign('tables', [$table]);
        $tpl->assign('columns',$columns);
        if ($table['tpl_category'] == 'tree') {
            $tree_id = $table['options']['tree_id'] ?? '';
            $tree_parent_id = $table['options']['tree_parent_id'] ?? '';
            $tree_name = $table['options']['tree_name'] ?? '';
            $tpl->assign('tree_id', $tree_id);
            $tpl->assign('tree_parent_id', $tree_parent_id);
            $tpl->assign('tree_name', $tree_name);
        }
        if ($table['package_name'] != "") {
            $url_path = $table['package_name'] . '/' . $table['business_name'];
        } else {
            $url_path = $table['business_name'];
        }
        if ($table['component_type'] == 3) {
            $tpl->assign('tag_id', $table['options']['tag_id'] ?? mt_rand(10000, 99999));
            $tpl->assign('tag_name', $table['options']['tag_name'] ?? $table['menu_name']);
        }
        $tpl->assign('url_path', $url_path);

        $relations = [];
        if(isset($table['options']['relations'])) {
            if (count($table['options']['relations']) > 0) {
                $relations = $table['options']['relations'];
            }
        }
        $tpl->assign('relations', $relations);

        $fileArr = Helper::get_dir($template_name);
        $data = [];
        foreach ($fileArr as $dir) {
            $files = Helper::get_dir($template_name.DIRECTORY_SEPARATOR.$dir);
            foreach ($files as $file) {
                if ($dir === 'vue') {
                    if (pathinfo($file, PATHINFO_FILENAME) !== $table['tpl_category']) {
                        continue;
                    }
                }
                $template = $tpl->show(DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.$file);
                $tab_name = pathinfo($file, PATHINFO_FILENAME).".".$dir;
                $lang = $dir;
                if($dir == 'js' || $dir == 'ts') {
                    $lang = 'javascript';
                }
                if($dir == 'vue') {
                    $lang = 'html';
                    $tab_name = 'index.vue';
                }
                if($dir == 'sql') {
                    $lang = 'mysql';
                }
                $data[] = [
                    'tab_name' => $tab_name,
                    'name' => pathinfo($file, PATHINFO_FILENAME),
                    'lang' => $lang,
                    'code' => $template
                ];
            }
        }
        return $data;
    }

    /**
     * 代码生成
     */
    public function generate($idsArr)
    {
        $zip = new Zip();
        $tables = $this->model->where('id', 'in', $idsArr)->select()->toArray();
        foreach ($idsArr as $table_id) {
            $this->genUnit($table_id, $tables);
        }
        $filename = 'saiadmin.zip';
        $download = $zip->compress($filename);
        return compact('filename', 'download');
    }

    /**
     * 代码生成子任务
     * @param $table_id
     * @param $tables
     * @return void
     */
    public function genUnit($table_id, $tables)
    {
        $table = $this->find($table_id)->toArray();
        $columns = $this->columnLogic->where('table_id', $table_id)->select()->toArray();
        $pk = 'id';
        foreach ($columns as &$column) {
            if ($column['is_pk'] == 2) {
                $pk = $column['column_name'];
            }
            if ($column['column_name'] == 'delete_time') {
                unset($column['column_name']);
            }
        }

        $template_name = '/plugin/saiadmin/stub/'.$table['template'];
        $tpl = new Template($template_name);
        $tpl->assign('pk', $pk);
        $tpl->assignArray($table);
        $tpl->assign('tables', $tables);
        $tpl->assign('columns',$columns);
        if ($table['tpl_category'] == 'tree') {
            $tree_id = $table['options']['tree_id'] ?? '';
            $tree_parent_id = $table['options']['tree_parent_id'] ?? '';
            $tree_name = $table['options']['tree_name'] ?? '';
            $tpl->assign('tree_id', $tree_id);
            $tpl->assign('tree_parent_id', $tree_parent_id);
            $tpl->assign('tree_name', $tree_name);
        }
        if ($table['package_name'] != "") {
            $url_path = $table['package_name'] . '/' . $table['business_name'];
        } else {
            $url_path = $table['business_name'];
        }
        if ($table['component_type'] == 3) {
            $tpl->assign('tag_id', $table['options']['tag_id'] ?? mt_rand(10000, 99999));
            $tpl->assign('tag_name', $table['options']['tag_name'] ?? $table['menu_name']);
        }
        $tpl->assign('url_path', $url_path);

        $relations = [];
        if(isset($table['options']['relations'])) {
            if (count($table['options']['relations']) > 0) {
                $relations = $table['options']['relations'];
            }
        }
        $tpl->assign('relations', $relations);

        $template = $table['template'];
        $class = new \ReflectionClass('plugin\saiadmin\utils\GenStruct');
        $instance  = $class->newInstanceArgs();
        if (!$class->hasMethod($template)) {
            throw new ApiException('请到GenStruct中为当前模板配置文件结构解析方法!');
        }

        $method = $class->getMethod($template);
        $fileArr = $method->invokeArgs($instance, [$table]);
        foreach ($fileArr as $item) {
            $tpl->gen($item['input'], $item['output']);
        }
    }

    /**
     * 获取数据表字段信息
     * @param $table_id
     * @return mixed
     */
    public function getTableColumns($table_id)
    {
        $query = $this->columnLogic->where('table_id', $table_id);
        return $this->columnLogic->getAll($query);
    }

    /**
     * 更新表结构和字段信息
     * @param $data
     * @return void
     */
    public function updateTableAndColumns($data)
    {
        $id = $data['id'];
        $columns = $data['columns'];

        unset($data['columns']);

        if (!empty($data['belong_menu_id'])) {
            $data['belong_menu_id'] = is_array($data['belong_menu_id']) ? array_pop($data['belong_menu_id']) : $data['belong_menu_id'];
        } else {
            $data['belong_menu_id'] = 0;
        }

        $data['generate_menus'] = implode(',', $data['generate_menus']);

        if (empty($data['options'])) {
            unset($data['options']);
        }

        $data['options'] = json_encode($data['options'], JSON_UNESCAPED_UNICODE);

        // 更新业务表
        $this->update($data, ['id' => $id]);

        // 更新业务字段表
        foreach ($columns as $column) {
            if ($column['options']) {
                $column['options'] = json_encode($column['options'], JSON_NUMERIC_CHECK);
            }
            $this->columnLogic->update($column, ['id' => $column['id']]);
        }
    }

}
