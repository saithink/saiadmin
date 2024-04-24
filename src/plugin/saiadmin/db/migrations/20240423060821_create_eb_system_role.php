<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateEbSystemRole extends AbstractMigration
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
        $table = $this->table('eb_system_role', [
            'id' => false,
            'primary_key' => 'id',
            'comment' => '角色信息表'
        ]);
        $table->addColumn('id', 'integer', ['signed' => false, 'identity' => true])
            ->addColumn('name', 'string', ['limit' => 30, 'null' => true, 'default' => null, 'comment' => '角色名称'])
            ->addColumn('code', 'string', ['limit' => 100, 'null' => true, 'default' => null, 'comment' => '角色代码'])
            ->addColumn('data_scope', 'integer', ['null' => true, 'default' => 1, 'comment' => '数据范围(1:全部数据权限 2:自定义数据权限 3:本部门数据权限 4:本部门及以下数据权限 5:本人数据权限)'])
            ->addColumn('status', 'integer', ['null' => true, 'default' => 1, 'comment' => '状态 (1正常 2停用)'])
            ->addColumn('sort', 'integer', ['null' => true, 'default' => 0, 'comment' => '排序'])
            ->addColumn('remark', 'string', ['limit' => 255, 'null' => true, 'default' => null, 'comment' => '备注'])
            ->addColumn('created_by', 'integer', ['null' => true, 'default' => null, 'comment' => '创建者'])
            ->addColumn('updated_by', 'integer', ['null' => true, 'default' => null, 'comment' => '更新者'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '修改时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '删除时间'])
            ->create();

        // 插入数据
        $data = [
            ['id' => 1, 'name' => '超级管理员（创始人）', 'code' => 'superAdmin', 'data_scope' => 1, 'status' => 1, 'sort' => 0, 'remark' => '系统内置角色，不可删除', 'created_by' => 1, 'updated_by' => 1, 'create_time' => '2023-10-24 12:00:00', 'update_time' => '2023-10-24 12:00:00', 'delete_time' => null],
            ['id' => 2, 'name' => '总管理员', 'code' => 'maxAdmin', 'data_scope' => 5, 'status' => 1, 'sort' => 1, 'remark' => null, 'created_by' => 1, 'updated_by' => 1, 'create_time' => '2023-10-24 12:00:00', 'update_time' => '2023-11-22 23:06:36', 'delete_time' => null],
            ['id' => 3, 'name' => '区域管理员', 'code' => 'areaAdmin', 'data_scope' => 2, 'status' => 1, 'sort' => 1, 'remark' => '', 'created_by' => 1, 'updated_by' => 1, 'create_time' => '2023-10-24 12:00:00', 'update_time' => '2023-10-24 12:00:00', 'delete_time' => null],
            ['id' => 4, 'name' => '部门领导', 'code' => 'deptLeader', 'data_scope' => 3, 'status' => 1, 'sort' => 1, 'remark' => null, 'created_by' => 1, 'updated_by' => 1, 'create_time' => '2023-10-24 12:00:00', 'update_time' => '2023-10-24 12:00:00', 'delete_time' => null],
            ['id' => 5, 'name' => '机构管理员', 'code' => 'companyAdmin', 'data_scope' => 4, 'status' => 1, 'sort' => 1, 'remark' => null, 'created_by' => 1, 'updated_by' => 1, 'create_time' => '2023-10-24 12:00:00', 'update_time' => '2023-10-24 12:00:00', 'delete_time' => null],
            ['id' => 6, 'name' => '员工', 'code' => 'staff', 'data_scope' => 5, 'status' => 1, 'sort' => 1, 'remark' => null, 'created_by' => 1, 'updated_by' => 1, 'create_time' => '2023-10-24 12:00:00', 'update_time' => '2023-12-12 16:11:12', 'delete_time' => null]
        ];

        $table->insert($data)->save();
    }

    public function down()
    {
        $this->table('eb_system_role')->drop()->save();
    }
}
