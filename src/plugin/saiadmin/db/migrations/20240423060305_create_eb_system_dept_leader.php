<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateEbSystemDeptLeader extends AbstractMigration
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
        $table = $this->table('eb_system_dept_leader', [
            'id' => false,
            'primary_key' => ['dept_id', 'user_id'],
            'comment' => '部门领导关联表'
        ]);
        $table->addColumn('dept_id', 'integer', ['null' => false, 'comment' => '部门主键'])
            ->addColumn('user_id', 'integer', ['null' => false, 'comment' => '角色主键'])
            ->create();
    }

    public function down()
    {
        $this->table('eb_system_dept_leader')->drop()->save();
    }
}
