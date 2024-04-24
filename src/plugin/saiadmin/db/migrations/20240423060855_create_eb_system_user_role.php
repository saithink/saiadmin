<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateEbSystemUserRole extends AbstractMigration
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
        $table = $this->table('eb_system_user_role', [
            'comment' => '用户与角色关联表',
            'id' => false,
            'primary_key' => ['user_id', 'role_id']
        ]);
        $table->addColumn('user_id', 'integer', ['signed' => false, 'null' => false, 'comment' => '用户主键'])
            ->addColumn('role_id', 'integer', ['signed' => false, 'null' => false, 'comment' => '角色主键'])
            ->create();

        // 插入记录
        $data = [
            ['user_id' => 1, 'role_id' => 1],
            ['user_id' => 2, 'role_id' => 2],
            ['user_id' => 3, 'role_id' => 2],
        ];
        $table->insert($data)->save();
    }

    public function down()
    {
        $this->table('eb_system_user_role')->drop()->save();
    }
}
