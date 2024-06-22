<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateEbSystemDictType extends AbstractMigration
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
        $table = $this->table('eb_system_dict_type', [
            'id' => false,
            'primary_key' => ['id'],
            'comment' => '字典类型表'
        ]);
        $table->addColumn('id', 'integer', ['signed' => false, 'identity' => true])
            ->addColumn('name', 'string', ['limit' => 50, 'null' => true, 'comment' => '字典名称'])
            ->addColumn('code', 'string', ['limit' => 100, 'null' => true, 'comment' => '字典标示'])
            ->addColumn('status', 'integer', ['null' => true, 'default' => 1, 'comment' => '状态 (1正常 2停用)'])
            ->addColumn('remark', 'string', ['limit' => 255, 'null' => true, 'comment' => '备注'])
            ->addColumn('created_by', 'integer', ['null' => true, 'comment' => '创建者'])
            ->addColumn('updated_by', 'integer', ['null' => true, 'comment' => '更新者'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'comment' => '修改时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'comment' => '删除时间'])
            ->addIndex('name')
            ->create();

        // Insert initial data
        $data = [
            ['id' => 1, 'name' => '数据表引擎', 'code' => 'table_engine', 'status' => 1, 'remark' => '数据表引擎字典', 'created_by' => 1, 'updated_by' => 1, 'create_time' => '2024-03-17 14:50:52', 'update_time' => '2024-03-17 14:50:52'],
            ['id' => 2, 'name' => '存储模式', 'code' => 'upload_mode', 'status' => 1, 'remark' => '上传文件存储模式', 'created_by' => 1, 'updated_by' => 1, 'create_time' => '2024-03-17 14:50:52', 'update_time' => '2024-03-17 14:50:52'],
            ['id' => 3, 'name' => '数据状态', 'code' => 'data_status', 'status' => 1, 'remark' => '通用数据状态', 'created_by' => 1, 'updated_by' => 1, 'create_time' => '2024-03-17 14:50:52', 'update_time' => '2024-03-17 14:50:52'],
            ['id' => 4, 'name' => '后台首页', 'code' => 'dashboard', 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'create_time' => '2024-03-17 14:50:52', 'update_time' => '2024-03-17 14:50:52'],
            ['id' => 5, 'name' => '性别', 'code' => 'sex', 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'create_time' => '2024-03-17 14:50:52', 'update_time' => '2024-03-17 14:50:52'],
            ['id' => 6, 'name' => '消息类型', 'code' => 'queue_msg_type', 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'create_time' => '2024-03-17 14:50:52', 'update_time' => '2024-03-17 14:50:52'],
            ['id' => 7, 'name' => '后台公告类型', 'code' => 'backend_notice_type', 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'create_time' => '2024-03-17 14:50:52', 'update_time' => '2024-03-17 14:50:52'],
            ['id' => 8, 'name' => '请求方式', 'code' => 'request_mode', 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'create_time' => '2024-03-17 14:50:52', 'update_time' => '2024-03-17 14:50:52'],
            ['id' => 12, 'name' => '附件类型', 'code' => 'attachment_type', 'status' => 1, 'created_by' => 1, 'updated_by' => 1, 'create_time' => '2024-03-17 14:50:52', 'update_time' => '2024-03-17 14:50:52'],
        ];

        $table->insert($data)->save();
    }

    public function down()
    {
        $this->table('eb_system_dict_type')->drop()->save();
    }
}
