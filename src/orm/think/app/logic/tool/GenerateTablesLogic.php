<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\tool;

use plugin\saiadmin\app\cache\UserMenuCache;
use plugin\saiadmin\app\logic\system\DatabaseLogic;
use plugin\saiadmin\app\model\system\SystemMenu;
use plugin\saiadmin\app\model\tool\GenerateTables;
use plugin\saiadmin\app\model\tool\GenerateColumns;
use plugin\saiadmin\exception\ApiException;
use plugin\saiadmin\basic\think\BaseLogic;
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
     * @return bool
     */
    public function destroy($ids): bool
    {
        return $this->transaction(function () use ($ids) {
            parent::destroy($ids);
            GenerateColumns::destroy(function ($query) use ($ids) {
                $query->where('table_id', 'in', $ids);
            });
            return true;
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
        $data = config('think-orm.connections');
        $config = $data[$source];
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
                'belong_menu_id' => 80,
                'menu_name' => $item['comment'],
                'tpl_category' => 'single',
                'template' => 'app',
                'stub' => 'think',
                'namespace' => '',
                'package_name' => '',
                'source' => $source,
                'generate_menus' => 'index,save,update,read,destroy',
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
        GenerateColumns::destroy(function ($query) use ($id) {
            $query->where('table_id', $id);
        });
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
                            'column_comment',
                            'column_type',
                            'default_value',
                            'is_pk',
                            'is_required',
                            'is_insert',
                            'is_edit',
                            'is_list',
                            'is_query',
                            'is_sort',
                            'query_type',
                            'view_type',
                            'dict_type',
                            'options',
                            'sort',
                            'is_cover'
                        ];
                        if (in_array($key, $array)) {
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
        $editContent = $codeEngine->renderContent('vue', 'edit-dialog.stub');
        $searchContent = $codeEngine->renderContent('vue', 'table-search.stub');
        $apiContent = $codeEngine->renderContent('ts', 'api.stub');

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
                'lang' => 'sql',
                'code' => $sqlContent
            ],
            [
                'tab_name' => 'index.vue',
                'name' => 'index',
                'lang' => 'html',
                'code' => $indexContent
            ],
            [
                'tab_name' => 'edit-dialog.vue',
                'name' => 'edit-dialog',
                'lang' => 'html',
                'code' => $editContent
            ],
            [
                'tab_name' => 'table-search.vue',
                'name' => 'table-search',
                'lang' => 'html',
                'code' => $searchContent
            ],
            [
                'tab_name' => 'api.ts',
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
        $codeEngine->generateFrontend('edit-dialog', $codeEngine->renderContent('vue', 'edit-dialog.stub'));
        $codeEngine->generateFrontend('table-search', $codeEngine->renderContent('vue', 'table-search.stub'));
        $codeEngine->generateFrontend('api', $codeEngine->renderContent('ts', 'api.stub'));
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
            $namespace_start = "plugin\\" . $table['namespace'] . "\\app\\admin\\";
            $namespace_start_model = "plugin\\" . $table['namespace'] . "\\app\\";
            $namespace_end = "\\" . $table['package_name'];
            $url_path = 'app/' . $table['namespace'] . '/admin/' . $table['package_name'] . '/' . $table['class_name'];
            $route = 'app/';
        } else {
            $namespace_start = "app\\" . $table['namespace'] . "\\";
            $namespace_start_model = "app\\" . $table['namespace'] . "\\";
            $namespace_end = "\\" . $table['package_name'];
            $url_path = $table['namespace'] . '/' . $table['package_name'] . '/' . $table['class_name'];
            $route = '';
        }

        $config = config('think-orm');

        $data = $table->toArray();
        $data['pk'] = $pk;
        $data['namespace_start'] = $namespace_start;
        $data['namespace_start_model'] = $namespace_start_model;
        $data['namespace_end'] = $namespace_end;
        $data['url_path'] = $url_path;
        $data['route'] = $route;
        $data['tables'] = [$data];
        $data['columns'] = $columns;
        $data['db_source'] = $config['default'] ?? 'mysql';

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
        $this->updateMenu($table);
        $this->genModule($id);
        UserMenuCache::clearMenuCache();
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
        $url_path = $tables['namespace'] . ":" . $tables['package_name'] . ':' . $tables['business_name'];
        $code = $tables['namespace'] . "/" . $tables['package_name'] . '/' . $tables['business_name'];
        $path = $tables['package_name'] . '/' . $tables['business_name'];
        $component = $tables['namespace'] . "/" . $tables['package_name'] . '/' . $tables['business_name'];

        /*先获取一下已有的路由中是否包含当前ID的路由的核心信息*/
        $model = new SystemMenu();
        $tableMenu = $model->where('generate_id', $tables['id'])->findOrEmpty();
        $fistMenu = [
            'parent_id' => $tables['belong_menu_id'],
            'name' => $tables['menu_name'],
            'code' => $code,
            'path' => $path,
            'icon' => 'ri:home-2-line',
            'component' => "/plugin/$component/index",
            'type' => 2,
            'sort' => 100,
            'is_iframe' => 2,
            'is_keep_alive' => 2,
            'is_hidden' => 2,
            'is_fixed_tab' => 2,
            'is_full_page' => 2,
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
                'name' => $node['name'],
                'slug' => "$url_path:{$node['key']}",
                'type' => 3,
                'sort' => 100,
                'is_iframe' => 2,
                'is_keep_alive' => 2,
                'is_hidden' => 2,
                'is_fixed_tab' => 2,
                'is_full_page' => 2,
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
