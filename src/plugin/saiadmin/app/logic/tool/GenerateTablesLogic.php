<?php

// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------

namespace plugin\saiadmin\app\logic\tool;

use plugin\saiadmin\app\model\system\SystemMenu;
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
    public function destroy($ids, $force = false)
    {
        $this->transaction(function () use ($ids, $force) {
            $this->model->destroy($ids, $force);
            if ($force) {
                GenerateColumns::destroy(function ($query) use ($ids) {
                    $query->where('table_id', 'in', $ids);
                }, $force);
            }
        });
    }

    /**
     * 装载表信息
     * @param $names
     * @return void
     */
    public function loadTable($names, $source)
    {
        $config = config('thinkorm.connections')[$source];
        $prefix = $config['prefix'];
        foreach ($names as $item) {
            $class_name = !empty($prefix) ? Helper::camel(Helper::str_replace_once($prefix, '', $item['name'])) : $item['name'];
            $tableInfo = [
                'table_name' => $item['name'],
                'table_comment' => $item['comment'],
                'menu_name' => $item['comment'],
                'tpl_category' => 'single',
                'template' => 'plugin',
                'namespace' => '',
                'package_name' => '',
                'source' => $source,
                'business_name' => Helper::get_business($item['name']),
                'class_name' => $class_name,
                'generate_menus' => 'save,update,read,delete,recycle,recovery',
            ];
            $model = GenerateTables::create($tableInfo);
            $columns = $this->dataLogic->getColumnList($item['name'], $source);
            foreach ($columns as &$column) {
                $column['table_id'] = $model->id;
                $column['is_cover'] = false;
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
         /*拉取已有的数据表信息*/
        $queryModel = $this->columnLogic->model->where([['table_id', '=', $id]]);
        $columnLogicData = $this->columnLogic->getAll($queryModel);
        $columnLogicList = array();
        foreach ($columnLogicData as $item) {
            $columnLogicList[$item['column_name']] = $item;
        }
        $this->columnLogic->destroy(function ($query) use ($id) {
            $query->where('table_id', $id);
        }, true);
        $columns = $this->dataLogic->getColumnList($model->table_name, $model->source ?? '');
        foreach ($columns as &$column) {
            $column['table_id'] = $model->id;
            $column['is_cover'] = false;
            if (isset($columnLogicList[$column['column_name']])) {
                /*存在历史信息的情况下*/
                $getcolumnLogicItem = $columnLogicList[$column['column_name']];
                if ($getcolumnLogicItem['column_type'] == $column['column_type']) {
                    $column['is_cover'] = true;
                    foreach ($getcolumnLogicItem as $key => $item) {
                        if (in_array($key, array(
                            'column_comment', 'default_value', 'is_pk', 'is_required', 'is_insert', 'is_edit', 'is_list', 'is_query', 'query_type',
                            'view_type', 'dict_type', 'allow_roles', 'remark','options'
                        ))){
                            $column[$key] = $item;
                        }
                    }
                }
            }
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
        if (!in_array($table['template'], ["plugin", "app"])) {
            throw new ApiException('模板必须为plugin或者app');
        }
        $columns = $this->columnLogic->where('table_id', $id)->order('sort', 'desc')->select()->toArray();
        $pk = 'id';
        foreach ($columns as &$column) {
            if ($column['is_pk'] == 2) {
                $pk = $column['column_name'];
            }
            if ($column['column_name'] == 'delete_time') {
                unset($column['column_name']);
            }
        }

        $template_name = '/plugin/saiadmin/stub/saiadmin';
        if (isset($table['stub']) && $table['stub'] != '') {
            $template_name = '/plugin/saiadmin/stub/'.$table['stub'];
        }
        $tpl = new Template($template_name);
        $tpl->assign('pk', $pk);
        $tpl->assignArray($table);
        $tpl->assign('tables', [$table]);
        $tpl->assign('columns', $columns);
        if ($table['tpl_category'] == 'tree') {
            $tree_id = $table['options']['tree_id'] ?? '';
            $tree_parent_id = $table['options']['tree_parent_id'] ?? '';
            $tree_name = $table['options']['tree_name'] ?? '';
            $tpl->assign('tree_id', $tree_id);
            $tpl->assign('tree_parent_id', $tree_parent_id);
            $tpl->assign('tree_name', $tree_name);
        }
        if ($table['template'] == 'plugin') {
            $namespace_start = "plugin\\".$table['namespace']."\\app\\";
            $namespace_end =  $table['package_name'] != "" ? "\\".$table['package_name'] : "";
            $url_path = 'app/'.$table['namespace'] . ($table['package_name'] != "" ? "/".$table['package_name'] : "") .'/'.$table['class_name'];
            $route = 'app/';
        } else {
            $namespace_start = "app\\".$table['namespace']."\\";
            $namespace_end =  $table['package_name'] != "" ? "\\".$table['package_name'] : "";
            $url_path = $table['namespace'] . ($table['package_name'] != "" ? "/".$table['package_name'] : "") .'/'.$table['class_name'];
            $route = '';
        }
        if ($table['component_type'] == 3) {
            $tpl->assign('tag_id', $table['options']['tag_id'] ?? mt_rand(10000, 99999));
            $tpl->assign('tag_name', $table['options']['tag_name'] ?? $table['menu_name']);
        }
        $tpl->assign('namespace_start', $namespace_start);
        $tpl->assign('namespace_end', $namespace_end);
        $tpl->assign('url_path', $url_path);
        $tpl->assign('route', $route);

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
     * 生成到模块
     */
    public function generateFile($id)
    {
        $table = $this->model->where('id', $id)->findOrEmpty();
        if ($table->isEmpty()) {
            throw new ApiException('请选择要生成的表');
        }
        $debug = config('app.debug', true);
        if (!$debug) {
            throw new ApiException('非调试模式下，不允许生成文件');
        }
        if ($table['generate_type'] == 2) {
            $this->genUnit($id, $table);
            $this->updateMenu($table);
            $this->genFile($table['generate_path'], $table['template']);
        } else {
            throw new ApiException('当前表的生成模式为压缩包模式，生成失败');
        }

    }

    public function genFile($fileName, $template)
    {
        $zip_path = runtime_path().DIRECTORY_SEPARATOR.'saiadmin';
        if (!is_dir($zip_path)) {
            throw new ApiException('代码文件查找失败');
        }
        $parent_path = dirname(base_path());
        $front_path = $parent_path.DIRECTORY_SEPARATOR.$fileName;
        if (!is_dir($front_path)) {
            throw new ApiException('前端项目目录查找失败');
        }
        $vue_path = $front_path.DIRECTORY_SEPARATOR.'src';
        $php_path = base_path().DIRECTORY_SEPARATOR.$template;

        copy_dir($zip_path.DIRECTORY_SEPARATOR.'src', $vue_path, true);
        copy_dir($zip_path.DIRECTORY_SEPARATOR.'php'.DIRECTORY_SEPARATOR.$template, $php_path, true);

        // 清理源目录
        if (is_dir($zip_path)) {
            $this->recursiveDelete($zip_path);
        }
    }


    /**
     * 部署菜单列表
     * @param $tables
     */
    public function updateMenu($tables)
    {
        /*不存在的情况下进行新建操作*/

        if ($tables['template'] == 'plugin') {
            $url_path = 'app/'.$tables['namespace'] . ($tables['package_name'] != "" ? "/".$tables['package_name'] : "") .'/'.$tables['class_name'];
            $code = 'app/'.$tables['namespace'] . ($tables['package_name'] != "" ? "/".$tables['package_name'] : "") .'/'.$tables['business_name'];
        } else {
            $url_path = $tables['namespace'] . ($tables['package_name'] != "" ? "/".$tables['package_name'] : "") .'/'.$tables['class_name'];
            $code = $tables['namespace'] . ($tables['package_name'] != "" ? "/".$tables['package_name'] : "") .'/'.$tables['business_name'];
        }
        $component = $tables['namespace'] . ($tables['package_name'] != "" ? "/".$tables['package_name'] : "") .'/'.$tables['business_name'];

        /*先获取一下已有的路由中是否包含当前ID的路由的核心信息*/
        $model = new SystemMenu();
        $tableMenu = $model->where('generate_id', $tables['id'])->find();
        $fistMenu = [
            'parent_id' => $tables['belong_menu_id'],
            'level' => '0,' . $tables['belong_menu_id'],
            'name' => $tables['menu_name'],
            'code' => $code,
            'icon' => 'icon-home',
            'route' => $code,
            'component' => "$component/index",
            'redirect' => null,
            'is_hidden' => 2,
            'type' => 'M',
            'status' => 1,
            'sort' => 0,
            'remark' => null,
            'generate_id' => $tables['id']
        ];
        if (empty($tableMenu)) {
            $temp = SystemMenu::create($fistMenu);
            $fistMenuId = $temp->id;
        } else {
            $fistMenu['id'] = $tableMenu['id'];
            $tableMenu->save($fistMenu);
            $fistMenuId = $tableMenu['id'];
        }
        /*开始进行子权限的判定操作*/
        $childNodes = [
            ['name' => '列表', 'key' => 'index'],
            ['name' => '保存', 'key' => 'save'],
            ['name' => '更新', 'key' => 'update'],
            ['name' => '读取', 'key' => 'read'],
            ['name' => '修改状态', 'key' => 'changeStatus'],
            ['name' => '删除', 'key' => 'destroy'],
            ['name' => '回收', 'key' => 'recycle'],
            ['name' => '恢复', 'key' => 'recovery'],
            ['name' => '销毁', 'key' => 'realDestroy']
        ];
        foreach ($childNodes as $node) {
            $nodeData = $model->where('parent_id', $fistMenuId)->where('generate_key', $node['key'])->find();
            $childNodeData = [
                'parent_id' => $fistMenuId,
                'level' => "{$tables['belong_menu_id']},{$fistMenuId}",
                'name' => $tables['menu_name'] . $node['name'],
                'code' => "/$url_path/{$node['key']}",
                'icon' => null,
                'route' => null,
                'component' => null,
                'redirect' => null,
                'is_hidden' => 1,
                'type' => 'B',
                'status' => 1,
                'sort' => 0,
                'remark' => null,
                'generate_key' => $node['key']
            ];
            if (!empty($nodeData)) {
                $childNodeData['id'] = $nodeData['id'];
                $nodeData->save($childNodeData);
            } else {
                $menuModel = new SystemMenu();
                $menuModel->save($childNodeData);
            }
        }
    }

    /**
     * 递归删除目录下所有文件和文件夹
     */
    public function recursiveDelete($dir)
    {
        // 打开指定目录
        if ($handle = @opendir($dir)) {
            while (($file = readdir($handle)) !== false) {
                if (($file == ".") || ($file == "..")) {
                    continue;
                }
                if (is_dir($dir . '/' . $file)) {
                    // 递归
                    self::recursiveDelete($dir . '/' . $file);
                } else {
                    unlink($dir . '/' . $file); // 删除文件
                }
            }
            @closedir($handle);
        }
        rmdir($dir);
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
        if (!in_array($table['template'], ["plugin", "app"])) {
            throw new ApiException('模板必须为plugin或者app');
        }
        $columns = $this->columnLogic->where('table_id', $table_id)->order('sort', 'desc')->select()->toArray();
        $pk = 'id';
        foreach ($columns as &$column) {
            if ($column['is_pk'] == 2) {
                $pk = $column['column_name'];
            }
            if ($column['column_name'] == 'delete_time') {
                unset($column['column_name']);
            }
        }

        $template_name = '/plugin/saiadmin/stub/saiadmin';
        if (isset($table['stub']) && $table['stub'] != '') {
            $template_name = '/plugin/saiadmin/stub/'.$table['stub'];
        }
        $tpl = new Template($template_name);
        $tpl->assign('pk', $pk);
        $tpl->assignArray($table);
        $tpl->assign('tables', $tables);
        $tpl->assign('columns', $columns);
        if ($table['tpl_category'] == 'tree') {
            $tree_id = $table['options']['tree_id'] ?? '';
            $tree_parent_id = $table['options']['tree_parent_id'] ?? '';
            $tree_name = $table['options']['tree_name'] ?? '';
            $tpl->assign('tree_id', $tree_id);
            $tpl->assign('tree_parent_id', $tree_parent_id);
            $tpl->assign('tree_name', $tree_name);
        }
        if ($table['template'] == 'plugin') {
            $namespace_start = "plugin\\".$table['namespace']."\\app\\";
            $namespace_end =  $table['package_name'] != "" ? "\\".$table['package_name'] : "";
            $url_path = 'app/'.$table['namespace'] . ($table['package_name'] != "" ? "/".$table['package_name'] : "") .'/'.$table['class_name'];
            $route = '/app';
        } else {
            $namespace_start = "app\\".$table['namespace']."\\";
            $namespace_end =  $table['package_name'] != "" ? "\\".$table['package_name'] : "";
            $url_path = $table['namespace'] . ($table['package_name'] != "" ? "/".$table['package_name'] : "") .'/'.$table['class_name'];
            $route = '';
        }
        if ($table['component_type'] == 3) {
            $tpl->assign('tag_id', $table['options']['tag_id'] ?? mt_rand(10000, 99999));
            $tpl->assign('tag_name', $table['options']['tag_name'] ?? $table['menu_name']);
        }
        $tpl->assign('namespace_start', $namespace_start);
        $tpl->assign('namespace_end', $namespace_end);
        $tpl->assign('url_path', $url_path);
        $tpl->assign('route', $route);

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
