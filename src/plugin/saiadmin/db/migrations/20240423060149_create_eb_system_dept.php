<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateEbSystemDept extends AbstractMigration
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
        $table = $this->table('eb_system_dept', [
            'comment' => '部门信息表',
            'id' => false,
            'primary_key' => ['id']
        ]);
        $table->addColumn('id', 'integer', ['signed' => false, 'identity' => true])
            ->addColumn('parent_id', 'integer', ['null' => true, 'default' => null, 'comment' => '父ID'])
            ->addColumn('level', 'string', ['limit' => 500, 'null' => true, 'default' => null, 'comment' => '组级集合'])
            ->addColumn('name', 'string', ['limit' => 30, 'null' => true, 'default' => null, 'comment' => '部门名称'])
            ->addColumn('leader', 'string', ['limit' => 20, 'null' => true, 'default' => null, 'comment' => '负责人'])
            ->addColumn('phone', 'string', ['limit' => 11, 'null' => true, 'default' => null, 'comment' => '联系电话'])
            ->addColumn('status', 'integer', ['null' => true, 'default' => 1, 'comment' => '状态 (1正常 2停用)'])
            ->addColumn('sort', 'integer', ['null' => true, 'default' => 0, 'comment' => '排序'])
            ->addColumn('remark', 'string', ['limit' => 255, 'null' => true, 'default' => null, 'comment' => '备注'])
            ->addColumn('created_by', 'integer', ['null' => true, 'default' => null, 'comment' => '创建者'])
            ->addColumn('updated_by', 'integer', ['null' => true, 'default' => null, 'comment' => '更新者'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '修改时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '删除时间'])
            ->create();

        // Insert initial records
        $data = [
            [
                'id' => 1,
                'parent_id' => 0,
                'level' => '0',
                'name' => '赛弟科技',
                'leader' => '赛弟',
                'phone' => '18888888888',
                'status' => 1,
                'sort' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2023-10-24 12:00:00',
                'update_time' => '2023-10-24 12:00:00',
                'delete_time' => null
            ],
            [
                'id' => 2,
                'parent_id' => 1,
                'level' => '0,1',
                'name' => '青岛分公司',
                'status' => 1,
                'sort' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2023-10-24 12:00:00',
                'update_time' => '2023-10-24 12:00:00',
                'delete_time' => null
            ],
            [
                'id' => 3,
                'parent_id' => 1,
                'level' => '0,1',
                'name' => '洛阳总公司',
                'status' => 1,
                'sort' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2023-10-24 12:00:00',
                'update_time' => '2023-10-24 12:00:00',
                'delete_time' => null
            ],
            [
                'id' => 4,
                'parent_id' => 2,
                'level' => '0,1,2',
                'name' => '市场部门',
                'status' => 1,
                'sort' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2023-10-24 12:00:00',
                'update_time' => '2023-10-24 12:00:00',
                'delete_time' => null
            ],
            [
                'id' => 5,
                'parent_id' => 2,
                'level' => '0,1,2',
                'name' => '财务部门',
                'status' => 1,
                'sort' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2023-10-24 12:00:00',
                'update_time' => '2023-10-24 12:00:00',
                'delete_time' => null
            ],
            [
                'id' => 6,
                'parent_id' => 3,
                'level' => '0,1,3',
                'name' => '研发部门',
                'status' => 1,
                'sort' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2023-10-24 12:00:00',
                'update_time' => '2023-10-24 12:00:00',
                'delete_time' => null
            ],
            [
                'id' => 7,
                'parent_id' => 3,
                'level' => '0,1,3',
                'name' => '市场部门',
                'status' => 1,
                'sort' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2023-10-24 12:00:00',
                'update_time' => '2023-10-24 12:00:00',
                'delete_time' => null
            ]
        ];

        $table->insert($data)->save();
    }

    public function down()
    {
        $this->table('eb_system_dept')->drop()->save();
    }
}
