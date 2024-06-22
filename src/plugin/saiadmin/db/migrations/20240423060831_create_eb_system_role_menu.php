<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateEbSystemRoleMenu extends AbstractMigration
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
        $table = $this->table('eb_system_role_menu', [
            'id' => false,
            'primary_key' => ['role_id', 'menu_id'],
            'comment' => '角色与菜单关联表'
        ]);
        $table->addColumn('role_id', 'integer', ['signed' => false, 'null' => false, 'comment' => '角色主键'])
            ->addColumn('menu_id', 'integer', ['signed' => false, 'null' => false, 'comment' => '菜单主键'])
            ->create();
    }

    public function down()
    {
        $this->table('eb_system_role_menu')->drop()->save();
    }
}
