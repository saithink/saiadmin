<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateEbToolGenerateTables extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $table = $this->table('eb_tool_generate_tables', [
            'comment' => '代码生成业务表',
            'id' => false,
            'primary_key' => ['id'],
        ]);
        $table->addColumn('id', 'integer', ['signed' => false, 'identity' => true])
            ->addColumn('table_name', 'string', ['limit' => 200, 'null' => true, 'default' => null, 'comment' => '表名称'])
            ->addColumn('table_comment', 'string', ['limit' => 500, 'null' => true, 'default' => null, 'comment' => '表注释'])
            ->addColumn('stub', 'string', ['limit' => 50, 'null' => true, 'default' => null, 'comment' => 'stub类型'])
            ->addColumn('template', 'string', ['limit' => 50, 'null' => true, 'default' => null, 'comment' => '模板名称'])
            ->addColumn('namespace', 'string', ['limit' => 255, 'null' => true, 'default' => null, 'comment' => '命名空间'])
            ->addColumn('package_name', 'string', ['limit' => 100, 'null' => true, 'default' => null, 'comment' => '控制器包名'])
            ->addColumn('business_name', 'string', ['limit' => 50, 'null' => true, 'default' => null, 'comment' => '业务名称'])
            ->addColumn('class_name', 'string', ['limit' => 50, 'null' => true, 'default' => null, 'comment' => '类名称'])
            ->addColumn('menu_name', 'string', ['limit' => 100, 'null' => true, 'default' => null, 'comment' => '生成菜单名'])
            ->addColumn('belong_menu_id', 'integer', ['null' => true, 'default' => null, 'comment' => '所属菜单'])
            ->addColumn('tpl_category', 'string', ['limit' => 100, 'null' => true, 'default' => null, 'comment' => '生成类型,single 单表CRUD,tree 树表CRUD,parent_sub父子表CRUD'])
            ->addColumn('generate_type', 'integer', ['null' => true, 'default' => 1, 'comment' => '1 压缩包下载 2 生成到模块'])
            ->addColumn('generate_path', 'string', ['limit' => 255, 'null' => true, 'default' => 'saiadmin-vue', 'comment' => '前端根目录'])
            ->addColumn('generate_menus', 'string', ['limit' => 255, 'null' => true, 'default' => null, 'comment' => '生成菜单列表'])
            ->addColumn('build_menu', 'integer', ['null' => true, 'default' => 1, 'comment' => '是否构建菜单'])
            ->addColumn('component_type', 'integer', ['null' => true, 'default' => 1, 'comment' => '组件显示方式'])
            ->addColumn('options', 'string', ['limit' => 1500, 'null' => true, 'default' => null, 'comment' => '其他业务选项'])
            ->addColumn('remark', 'string', ['limit' => 255, 'null' => true, 'default' => null, 'comment' => '备注'])
            ->addColumn('source', 'string', ['limit' => 255, 'null' => true, 'default' => null, 'comment' => '数据源'])
            ->addColumn('created_by', 'integer', ['null' => true, 'default' => null, 'comment' => '创建者'])
            ->addColumn('updated_by', 'integer', ['null' => true, 'default' => null, 'comment' => '更新者'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '修改时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '删除时间'])
            ->addIndex(['table_name'], ['name' => 'idx_table_name'])
            ->create();

        // 插入记录
        $data = [
            [
                'id' => 3,
                'table_name' => 'eb_article',
                'table_comment' => '文章表',
                'stub' => 'saiadmin',
                'template' => 'app',
                'namespace' => 'cms',
                'package_name' => 'news',
                'business_name' => 'article',
                'class_name' => 'Article',
                'menu_name' => '文章管理',
                'belong_menu_id' => 4000,
                'tpl_category' => 'single',
                'generate_type' => 1,
                'generate_path' => 'saiadmin-vue',
                'generate_menus' => 'save,update,read,delete,recycle,recovery,changeStatus',
                'build_menu' => 1,
                'component_type' => 1,
                'options' => '{"relations":[{"name":"category","type":"belongsTo","model":"ArticleCategory","foreignKey":"id","localKey":"category_id","table":""}],"tree_id":"id","tree_name":"category_name","tree_parent_id":"parent_id","tag_id":"10086","tag_name":"文章管理","tag_view_name":"id"}',
                'created_by' => null,
                'updated_by' => null,
                'create_time' => '2023-11-30 22:23:17',
                'update_time' => '2024-01-20 15:41:16',
                'delete_time' => null,
            ],
            [
                'id' => 4,
                'table_name' => 'eb_article_category',
                'table_comment' => '文章分类表',
                'stub' => 'saiadmin',
                'template' => 'app',
                'namespace' => 'cms',
                'package_name' => 'news',
                'business_name' => 'category',
                'class_name' => 'ArticleCategory',
                'menu_name' => '文章分类',
                'belong_menu_id' => 4000,
                'tpl_category' => 'tree',
                'generate_type' => 1,
                'generate_path' => 'saiadmin-vue',
                'generate_menus' => 'save,update,read,delete,recycle,recovery,changeStatus',
                'build_menu' => 1,
                'component_type' => 1,
                'options' => '{"relations":[],"tree_id":"id","tree_name":"category_name","tree_parent_id":"parent_id"}',
                'created_by' => null,
                'updated_by' => null,
                'create_time' => '2023-11-30 22:23:17',
                'update_time' => '2024-01-20 15:40:16',
                'delete_time' => null,
            ],
        ];
        $table->insert($data)->save();
    }

    public function down()
    {
        $this->table('eb_tool_generate_tables')->drop()->save();
    }
}
