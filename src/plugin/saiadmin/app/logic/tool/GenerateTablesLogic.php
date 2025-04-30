<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\tool;

use plugin\saiadmin\app\logic\system\DatabaseLogic;
use plugin\saiadmin\app\model\system\SystemMenu;
use plugin\saiadmin\app\model\tool\GenerateTables;
use plugin\saiadmin\app\model\tool\GenerateColumns;
use plugin\saiadmin\exception\ApiException;
use plugin\saiadmin\basic\BaseLogic;
use plugin\saiadmin\utils\Helper;
use plugin\saiadmin\utils\code\CodeZip;
use plugin\saiadmin\utils\code\CodeEngine;

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
        $this->dataLogic = new DatabaseLogic();
    }

    /**
     * 删除表和字段信息
     * @param $ids
     */
    public function destroy($ids)
    {
        $this->transaction(function () use ($ids) {
            parent::destroy($ids);
            GenerateColumns::destroy(function ($query) use ($ids) {
                $query->where('table_id', 'in', $ids);
            });
        });
    }

    /**
     * 装载表信息
     * @param $names
     * @param $source
     * @return void
     */
    public function loadTable($names, $source): void
    {
        $config = dbSource()[$source];
        if (!$config) {
            throw new ApiException('数据库配置读取失败');
        }

        $prefix = $config['prefix'] ?? '';
        foreach ($names as $item) {
            $class_name = $item['name'];
            if (!empty($prefix)) {
                $class_name = Helper::str_replace_once($prefix, '', $class_name);
            }
            $class_name = Helper::camel($class_name);
            $tableInfo = [
                'table_name' => $item['name'],
                'table_comment' => $item['comment'],
                'class_name' => $class_name,
                'business_name' => Helper::get_business($item['name']),
                'belong_menu_id' => 4000,
                'menu_name' => $item['comment'],
                'tpl_category' => 'single',
                'template' => 'app',
                'stub' => 'saiadmin',
                'namespace' => '',
                'package_name' => '',
                'source' => $source,
                'generate_menus' => 'index,save,update,read,delete',
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
        $model = $this->model->findOrEmpty($id);
        // 拉取已有数据表信息
        $queryModel = $this->columnLogic->model->where('table_id', $id);
        $columnLogicData = $this->columnLogic->getAll($queryModel);
        $columnLogicList = [];
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
                // 存在历史信息的情况
                $getcolumnLogicItem = $columnLogicList[$column['column_name']];
                if ($getcolumnLogicItem['column_type'] == $column['column_type']) {
                    $column['is_cover'] = true;
                    foreach ($getcolumnLogicItem as $key => $item) {
                        $array = [
                            'column_comment', 'column_type', 'default_value', 'is_pk', 'is_required', 'is_insert', 'is_edit', 'is_list',
                            'is_query', 'is_sort', 'query_type', 'view_type', 'dict_type', 'options', 'sort', 'is_cover'
                        ];
                        if (in_array($key, $array)){
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
        $data = $this->renderData($id);

        $codeEngine = new CodeEngine($data);
        $controllerContent = $codeEngine->renderContent('php', 'controller.stub');
        $logicContent = $codeEngine->renderContent('php', 'logic.stub');
        $modelContent = $codeEngine->renderContent('php', 'model.stub');
        $validateContent = $codeEngine->renderContent('php', 'validate.stub');
        $sqlContent = $codeEngine->renderContent('sql', 'sql.stub');
        $indexContent = $codeEngine->renderContent('vue', 'index.stub');
        $editContent = $codeEngine->renderContent('vue', 'edit.stub');
        $apiContent = $codeEngine->renderContent('js', 'api.stub');

        // 返回生成内容
        return [
            [
                'tab_name' => 'controller.php',
                'name' => 'controller',
                'lang' => 'php',
                'code' => $controllerContent
            ],
            [
                'tab_name' => 'logic.php',
                'name' => 'logic',
                'lang' => 'php',
                'code' => $logicContent
            ],
            [
                'tab_name' => 'model.php',
                'name' => 'model',
                'lang' => 'php',
                'code' => $modelContent
            ],
            [
                'tab_name' => 'validate.php',
                'name' => 'validate',
                'lang' => 'php',
                'code' => $validateContent
            ],
            [
                'tab_name' => 'sql.sql',
                'name' => 'sql',
                'lang' => 'mysql',
                'code' => $sqlContent
            ],
            [
                'tab_name' => 'index.vue',
                'name' => 'index',
                'lang' => 'html',
                'code' => $indexContent
            ],
            [
                'tab_name' => 'edit.vue',
                'name' => 'edit',
                'lang' => 'html',
                'code' => $editContent
            ],
            [
                'tab_name' => 'api.js',
                'name' => 'api',
                'lang' => 'javascript',
                'code' => $apiContent
            ]
        ];
    }

    /**
     * 生成到模块
     * @param $id
     */
    public function genModule($id)
    {
        $data = $this->renderData($id);

        // 生成文件到模块
        $codeEngine = new CodeEngine($data);
        $codeEngine->generateBackend('controller', $codeEngine->renderContent('php', 'controller.stub'));
        $codeEngine->generateBackend('logic', $codeEngine->renderContent('php', 'logic.stub'));
        $codeEngine->generateBackend('model', $codeEngine->renderContent('php', 'model.stub'));
        $codeEngine->generateBackend('validate', $codeEngine->renderContent('php', 'validate.stub'));
        $codeEngine->generateFrontend('index', $codeEngine->renderContent('vue', 'index.stub'));
        $codeEngine->generateFrontend('edit', $codeEngine->renderContent('vue', 'edit.stub'));
        $codeEngine->generateFrontend('api', $codeEngine->renderContent('js', 'api.stub'));
    }

    /**
     * 处理数据
     * @param $id
     * @return array
     */
    protected function renderData($id): array
    {
        $table = $this->model->findOrEmpty($id);
        if (!in_array($table['template'], ["plugin", "app"])) {
            throw new ApiException('应用类型必须为plugin或者app');
        }
        if (empty($table['namespace'])) {
            throw new ApiException('请先设置应用名称');
        }

        $columns = $this->columnLogic->where('table_id', $id)
            ->order('sort', 'desc')
            ->select()
            ->toArray();
        $pk = 'id';
        foreach ($columns as &$column) {
            if ($column['is_pk'] == 2) {
                $pk = $column['column_name'];
            }
            if ($column['column_name'] == 'delete_time') {
                unset($column['column_name']);
            }
        }

        // 处理特殊变量
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
        $data = $table->toArray();
        $data['pk'] = $pk;
        $data['namespace_start'] = $namespace_start;
        $data['namespace_end'] = $namespace_end;
        $data['url_path'] = $url_path;
        $data['route'] = $route;
        $data['tables'] = [$data];
        $data['columns'] = $columns;
        $data['db_source'] = defaultDbSource();

        return $data;
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
        $this->genModule($id);
        $this->updateMenu($table);
    }

    /**
     * 代码生成下载
     */
    public function generate($idsArr): array
    {
        $zip = new CodeZip();
        $tables = $this->model->where('id', 'in', $idsArr)->select()->toArray();
        foreach ($idsArr as $table_id) {
            $data = $this->renderData($table_id);
            $data['tables'] = $tables;
            $codeEngine = new CodeEngine($data);
            $codeEngine->generateTemp();
        }

        $filename = 'saiadmin.zip';
        $download = $zip->compress();

        return compact('filename', 'download');
    }

    /**
     * 处理菜单列表
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
        $tableMenu = $model->where('generate_id', $tables['id'])->findOrEmpty();
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
        if ($tableMenu->isEmpty()) {
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
            ['name' => '删除', 'key' => 'destroy'],
        ];

        foreach ($childNodes as $node) {
            $nodeData = $model->where('parent_id', $fistMenuId)->where('generate_key', $node['key'])->findOrEmpty();
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
     * 获取数据表字段信息
     * @param $table_id
     * @return mixed
     */
    public function getTableColumns($table_id): mixed
    {
        $query = $this->columnLogic->where('table_id', $table_id);
        return $this->columnLogic->getAll($query);
    }

    /**
     * 编辑数据
     * @param $id
     * @param $data
     * @return mixed
     */
    public function edit($id, $data): mixed
    {
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

        return true;
    }

}
