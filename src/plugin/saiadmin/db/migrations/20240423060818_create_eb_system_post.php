<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateEbSystemPost extends AbstractMigration
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
        $table = $this->table('eb_system_post', [
            'id' => false,
            'primary_key' => 'id',
            'comment' => '岗位信息表'
        ]);
        $table->addColumn('id', 'integer', ['signed' => false, 'identity' => true])
            ->addColumn('name', 'string', ['limit' => 50, 'null' => true, 'default' => null, 'comment' => '岗位名称'])
            ->addColumn('code', 'string', ['limit' => 100, 'null' => true, 'default' => null, 'comment' => '岗位代码'])
            ->addColumn('sort', 'integer', ['null' => true, 'default' => 0, 'comment' => '排序'])
            ->addColumn('status', 'integer', ['null' => true, 'default' => 1, 'comment' => '状态 (1正常 2停用)'])
            ->addColumn('remark', 'string', ['limit' => 255, 'null' => true, 'default' => null, 'comment' => '备注'])
            ->addColumn('created_by', 'integer', ['null' => true, 'default' => null, 'comment' => '创建者'])
            ->addColumn('updated_by', 'integer', ['null' => true, 'default' => null, 'comment' => '更新者'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '修改时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '删除时间'])
            ->create();

        // 插入数据
        $data = [
            ['id' => 1, 'name' => '总经理', 'code' => 'zongjingli', 'sort' => 1, 'status' => 1, 'remark' => null, 'created_by' => 1, 'updated_by' => 1, 'create_time' => '2023-10-24 12:00:00', 'update_time' => '2023-12-04 18:02:32', 'delete_time' => null],
            ['id' => 2, 'name' => '技术经理', 'code' => 'jishujingli', 'sort' => 10, 'status' => 1, 'remark' => null, 'created_by' => 1, 'updated_by' => 1, 'create_time' => '2023-10-24 12:00:00', 'update_time' => '2023-11-15 10:29:47', 'delete_time' => null],
            ['id' => 3, 'name' => '销售经理', 'code' => 'xiaoshoujingli', 'sort' => 5, 'status' => 1, 'remark' => null, 'created_by' => 1, 'updated_by' => 1, 'create_time' => '2023-10-24 12:00:00', 'update_time' => '2023-11-15 11:54:50', 'delete_time' => null],
            ['id' => 4, 'name' => '员工', 'code' => 'yuangong', 'sort' => 1, 'status' => 1, 'remark' => null, 'created_by' => 1, 'updated_by' => 1, 'create_time' => '2023-10-24 12:00:00', 'update_time' => '2023-11-15 09:51:12', 'delete_time' => null],
            ['id' => 5, 'name' => '测试岗位', 'code' => 'test', 'sort' => 15, 'status' => 1, 'remark' => null, 'created_by' => 1, 'updated_by' => 1, 'create_time' => '2023-11-15 09:42:08', 'update_time' => '2023-12-06 21:40:46', 'delete_time' => null],
            ['id' => 6, 'name' => '技术部', 'code' => 'jishu', 'sort' => 100, 'status' => 1, 'remark' => null, 'created_by' => 1, 'updated_by' => 1, 'create_time' => '2023-12-12 16:19:33', 'update_time' => '2023-12-12 16:28:24', 'delete_time' => null]
        ];

        $table->insert($data)->save();
    }

    public function down()
    {
        $this->table('eb_system_post')->drop()->save();
    }
}
