<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

require_once __DIR__ . '/../support/SaiSchema.php';

/**
 * 创建演示用文章模块数据表（sa_article / sa_article_banner / sa_article_category）
 *
 * 与 InitBaseTables 一样使用可移植 API，MySQL 与 PostgreSQL 通用。
 * 演示数据由 DemoSeeder 写入；纯净安装只建表、不写数据。
 */
final class CreateArticleTables extends AbstractMigration
{
    use SaiSchema;

    public function up(): void
    {
        $this->table('sa_article', $this->tableOptions('文章表'))
            ->addColumn('id', $this->pkType(), ['limit' => 10, 'null' => false, 'identity' => true, 'generated' => null, 'comment' => '编号'])
            ->addColumn('category_id', 'integer', ['limit' => 10, 'null' => false, 'comment' => '分类id'])
            ->addColumn('title', 'string', ['limit' => 255, 'null' => false, 'default' => '', 'comment' => '文章标题'])
            ->addColumn('author', 'string', ['limit' => 255, 'null' => true, 'comment' => '文章作者'])
            ->addColumn('image', 'string', ['limit' => 1000, 'null' => true, 'default' => '', 'comment' => '文章图片'])
            ->addColumn('describe', 'string', ['limit' => 1000, 'null' => false, 'comment' => '文章简介'])
            ->addColumn('content', 'text', ['null' => false, 'comment' => '文章内容'])
            ->addColumn('views', 'integer', ['limit' => 11, 'null' => true, 'default' => 0, 'comment' => '浏览次数'])
            ->addColumn('sort', 'integer', ['limit' => 10, 'null' => true, 'default' => 100, 'signed' => false, 'comment' => '排序'])
            ->addColumn('status', 'tinyinteger', ['limit' => 1, 'null' => true, 'default' => 1, 'signed' => false, 'comment' => '状态'])
            ->addColumn('is_link', 'tinyinteger', ['limit' => 1, 'null' => true, 'default' => 2, 'comment' => '是否外链'])
            ->addColumn('link_url', 'string', ['limit' => 255, 'null' => true, 'comment' => '链接地址'])
            ->addColumn('is_hot', 'tinyinteger', ['limit' => 1, 'null' => true, 'default' => 2, 'signed' => false, 'comment' => '是否热门'])
            ->addColumn('created_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '创建者'])
            ->addColumn('updated_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '创建者'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '修改时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '删除时间'])
            ->addIndex(['category_id'])
            ->create();

        $this->table('sa_article_banner', $this->tableOptions('文章轮播图'))
            ->addColumn('id', $this->pkType(), ['limit' => 11, 'null' => false, 'identity' => true, 'generated' => null, 'comment' => '编号'])
            ->addColumn('banner_type', 'integer', ['limit' => 11, 'null' => true, 'comment' => '类型'])
            ->addColumn('image', 'string', ['limit' => 1000, 'null' => true, 'comment' => '图片地址'])
            ->addColumn('is_href', 'tinyinteger', ['limit' => 1, 'null' => true, 'default' => 1, 'comment' => '是否链接'])
            ->addColumn('url', 'string', ['limit' => 255, 'null' => true, 'comment' => '链接地址'])
            ->addColumn('title', 'string', ['limit' => 255, 'null' => true, 'comment' => '标题'])
            ->addColumn('status', 'tinyinteger', ['limit' => 1, 'null' => true, 'default' => 1, 'comment' => '状态'])
            ->addColumn('sort', 'integer', ['limit' => 11, 'null' => true, 'default' => 0, 'comment' => '排序'])
            ->addColumn('remark', 'string', ['limit' => 255, 'null' => true, 'comment' => '描述'])
            ->addColumn('created_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '创建者'])
            ->addColumn('updated_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '创建者'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '修改时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '删除时间'])
            ->create();

        $this->table('sa_article_category', $this->tableOptions('文章分类表'))
            ->addColumn('id', $this->pkType(), ['limit' => 11, 'null' => false, 'signed' => false, 'identity' => true, 'generated' => null, 'comment' => '编号'])
            ->addColumn('parent_id', 'integer', ['limit' => 11, 'null' => false, 'default' => 0, 'comment' => '父级ID'])
            ->addColumn('category_name', 'string', ['limit' => 255, 'null' => false, 'comment' => '分类标题'])
            ->addColumn('describe', 'string', ['limit' => 255, 'null' => true, 'comment' => '分类简介'])
            ->addColumn('image', 'string', ['limit' => 255, 'null' => true, 'comment' => '分类图片'])
            ->addColumn('sort', 'integer', ['limit' => 10, 'null' => true, 'default' => 100, 'signed' => false, 'comment' => '排序'])
            ->addColumn('status', 'tinyinteger', ['limit' => 1, 'null' => true, 'default' => 1, 'signed' => false, 'comment' => '状态'])
            ->addColumn('created_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '创建者'])
            ->addColumn('updated_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '创建者'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '修改时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '删除时间'])
            ->create();
    }

    public function down(): void
    {
        $this->dropTables([
            'sa_article',
            'sa_article_banner',
            'sa_article_category',
        ]);
    }
}
