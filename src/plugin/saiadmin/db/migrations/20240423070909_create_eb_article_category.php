<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateEbArticleCategory extends AbstractMigration
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
        $table = $this->table('eb_article_category', [
            'comment' => '文章分类表',
            'id' => false,
            'primary_key' => ['id']
        ]);
        $table
            ->addColumn('id', 'integer', ['signed' => false, 'identity' => true])
            ->addColumn('parent_id', 'integer', ['default' => 0, 'null' => false, 'comment' => '父级id'])
            ->addColumn('category_name', 'string', ['limit' => 255, 'null' => false, 'comment' => '分类标题'])
            ->addColumn('describe', 'string', ['limit' => 255, 'null' => true, 'default' => null, 'comment' => '分类简介'])
            ->addColumn('image', 'string', ['limit' => 255, 'null' => true, 'default' => null, 'comment' => '分类图片'])
            ->addColumn('sort', 'integer', ['null' => true, 'default' => 100, 'comment' => '排序'])
            ->addColumn('status', 'integer', ['null' => true, 'default' => 1, 'comment' => '状态'])
            ->addColumn('created_by', 'integer', ['null' => true, 'default' => null, 'comment' => '创建者'])
            ->addColumn('updated_by', 'integer', ['null' => true, 'default' => null, 'comment' => '更新者'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '修改时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '删除时间'])
            ->addIndex('parent_id',['name' => 'idx_parent_id'])
            ->create();

        $data = [
            [
                'id' => 1,
                'parent_id' => 0,
                'category_name' => '新闻中心',
                'describe' => '新闻',
                'image' => 'http://localhost:8787/upload/image/20240120/65ab7abd841f.jpg',
                'sort' => 100,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2024-01-20 15:48:15',
                'update_time' => '2024-01-20 15:51:27',
                'delete_time' => null,
            ],
            [
                'id' => 2,
                'parent_id' => 1,
                'category_name' => '国内新闻',
                'describe' => '国内大事',
                'image' => 'http://localhost:8787/upload/image/20240120/65ab7b52bb76.jpg',
                'sort' => 100,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2024-01-20 15:49:55',
                'update_time' => '2024-01-20 15:51:18',
                'delete_time' => null,
            ],
            [
                'id' => 3,
                'parent_id' => 1,
                'category_name' => '国际新闻',
                'describe' => '国际大事',
                'image' => 'http://localhost:8787/upload/image/20240120/65ab7b675f01.jpg',
                'sort' => 100,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2024-01-20 15:51:11',
                'update_time' => '2024-01-20 15:51:11',
                'delete_time' => null,
            ],
        ];

        $table->insert($data)->save();
    }

    public function down()
    {
        $this->table('eb_article_category')->drop()->save();
    }
}
