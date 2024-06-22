<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateEbSystemRoleDept extends AbstractMigration
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
        $table = $this->table('eb_system_role_dept', [
            'id' => false,
            'primary_key' => ['role_id', 'dept_id'],
            'comment' => '角色与部门关联表'
        ]);
        $table->addColumn('role_id', 'integer', ['signed' => false, 'null' => false, 'comment' => '用户主键'])
            ->addColumn('dept_id', 'integer', ['signed' => false, 'null' => false, 'comment' => '角色主键'])
            ->create();

        // 插入数据
        $data = [
            ['role_id' => 2, 'dept_id' => 2],
            ['role_id' => 2, 'dept_id' => 4],
            ['role_id' => 2, 'dept_id' => 5]
        ];

        $table->insert($data)->save();
    }

    public function down()
    {
        $this->table('eb_system_role_dept')->drop()->save();
    }
}
