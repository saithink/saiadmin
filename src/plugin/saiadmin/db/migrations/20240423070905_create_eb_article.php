<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateEbArticle extends AbstractMigration
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
        $table = $this->table('eb_article', [
            'comment' => '文章表',
            'id' => false,
            'primary_key' => ['id']
        ]);
        $table->addColumn('id', 'integer', ['signed' => false, 'identity' => true])
            ->addColumn('category_id', 'integer', ['null' => false, 'comment' => '分类id'])
            ->addColumn('title', 'string', ['limit' => 255, 'null' => false, 'default' => '', 'comment' => '文章标题'])
            ->addColumn('author', 'string', ['limit' => 255, 'null' => true, 'default' => null, 'comment' => '文章作者'])
            ->addColumn('image', 'string', ['limit' => 1000, 'null' => true, 'default' => '', 'comment' => '文章图片'])
            ->addColumn('describe', 'string', ['limit' => 1000, 'null' => false, 'comment' => '文章简介'])
            ->addColumn('content', 'text', ['null' => false, 'comment' => '文章内容'])
            ->addColumn('views', 'integer', ['null' => true, 'default' => 0, 'comment' => '浏览次数'])
            ->addColumn('sort', 'integer', ['null' => true, 'default' => 100, 'comment' => '排序'])
            ->addColumn('status', 'integer', ['null' => true, 'default' => 1, 'comment' => '状态'])
            ->addColumn('is_link', 'integer', ['null' => true, 'default' => 2, 'comment' => '是否外链'])
            ->addColumn('link_url', 'string', ['limit' => 255, 'null' => true, 'default' => null, 'comment' => '链接地址'])
            ->addColumn('is_hot', 'integer', ['null' => true, 'default' => 2, 'comment' => '是否热门'])
            ->addColumn('created_by', 'integer', ['null' => true, 'default' => null, 'comment' => '创建者'])
            ->addColumn('updated_by', 'integer', ['null' => true, 'default' => null, 'comment' => '更新者'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '修改时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '删除时间'])
            ->addIndex('category_id', ['name' => 'idx_category_id'])
            ->create();

        $data = [
            [
                'id' => 1,
                'category_id' => 3,
                'title' => '全球气候峰会达成历史性协议，承诺减缓气候变化',
                'author' => 'chatgpt',
                'image' => 'http://localhost:8787/upload/image/20240120/65ab7b675f01.jpg',
                'describe' => '',
                'content' => '<p>&mdash;&mdash; 在本周的联合国气候变化大会上，全球领导人达成了一项具有历史性意义的协议，致力于减缓气候变化的严重影响。这一协议标志着国际社会对气候行动的强烈承诺，将为创造更可持续的未来奠定基础。</p><p>与会的国家首脑一致同意在未来十年内采取更为积极的行动，以降低温室气体排放并推动可再生能源的发展。协议还明确了全球范围内实现零碳排放的目标，并呼吁发达国家向发展中国家提供更多的气候援助。</p><p>联合国秘书长表示，这一协议是对全球气候变化问题最强烈的回应之一，是对科学家们发出的气候紧急警告的直接回应。他强调，各国领导人的团结和决心是实现全球气候可持续未来的关键。</p><p>该协议的一项重要承诺是在未来五年内定期审查并加强各国的减排目标，以确保全球采取的行动与气候变化的紧迫性相匹配。此外，协议还建立了一个国际合作框架，促进技术转让和知识共享，以帮助各国更好地适应气候变化的影响。</p><p>全球气候峰会的成功举办表明了国际社会在面对共同挑战时的团结和决心。各国领导人强调，气候变化不仅是一个全球性问题，也是一个需要集体努力的问题。这一协议的达成为全球未来的可持续发展奠定了坚实的基础，为下一代创造了更为清洁、绿色的生态环境。</p>',
                'views' => 0,
                'sort' => 100,
                'status' => 1,
                'is_link' => 2,
                'is_hot' => 2,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2024-01-20 15:53:48',
                'update_time' => '2024-01-20 15:53:48',
                'delete_time' => null,
            ]
        ];

        $table->insert($data)->save();
    }

    public function down()
    {
        $this->table('eb_article')->drop()->save();
    }
}
