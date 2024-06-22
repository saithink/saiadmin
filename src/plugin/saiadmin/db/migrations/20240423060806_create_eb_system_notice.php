<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateEbSystemNotice extends AbstractMigration
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
        $table = $this->table('eb_system_notice', [
            'id' => false,
            'primary_key' => ['id'],
            'comment' => '系统公告表'
        ]);
        $table->addColumn('id', 'integer', ['signed' => false, 'identity' => true])
            ->addColumn('message_id', 'integer', ['null' => true, 'default' => null, 'comment' => '消息ID'])
            ->addColumn('title', 'string', ['limit' => 255, 'null' => true, 'comment' => '标题'])
            ->addColumn('type', 'integer', ['null' => true, 'default' => null, 'comment' => '公告类型(1通知 2公告)'])
            ->addColumn('content', 'text', ['null' => true, 'comment' => '公告内容'])
            ->addColumn('click_num', 'integer', ['null' => true, 'default' => 0, 'comment' => '浏览次数'])
            ->addColumn('remark', 'string', ['limit' => 255, 'null' => true, 'comment' => '备注'])
            ->addColumn('created_by', 'integer', ['null' => true, 'default' => null, 'comment' => '创建人'])
            ->addColumn('updated_by', 'integer', ['null' => true, 'default' => null, 'comment' => '更新人'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'comment' => '修改时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'comment' => '删除时间'])
            ->addIndex('message_id')
            ->create();

        $data = [
            [
                'id' => 1,
                'message_id' => null,
                'title' => '欢迎使用SaiAdmin',
                'type' => 1,
                'content' => '<p>saiadmin是一款基于vue3 + webman 的极速开发框架，前端开发采用JavaScript，后端采用PHP</p>',
                'click_num' => 0,
                'remark' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2024-01-20 15:55:36',
                'update_time' => '2024-01-20 15:55:36',
                'delete_time' => null
            ]
        ];

        $table->insert($data)->save();
    }

    public function down()
    {
        $this->table('eb_system_notice')->drop()->save();
    }
}
