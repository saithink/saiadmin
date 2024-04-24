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
        $table = $this->table('eb_system_role_menu', ['id' => false, 'primary_key' => ['role_id', 'menu_id'], 'comment' => '角色与菜单关联表']);
        $table->addColumn('role_id', 'integer', ['signed' => false, 'null' => false, 'comment' => '角色主键'])
            ->addColumn('menu_id', 'integer', ['signed' => false, 'null' => false, 'comment' => '菜单主键'])
            ->create();

        // 插入数据
        $data = [
            ['role_id' => 2, 'menu_id' => 1000],
            ['role_id' => 2, 'menu_id' => 1100],
            ['role_id' => 2, 'menu_id' => 1101],
            ['role_id' => 2, 'menu_id' => 1102],
            ['role_id' => 2, 'menu_id' => 1103],
            ['role_id' => 2, 'menu_id' => 1104],
            ['role_id' => 2, 'menu_id' => 1105],
            ['role_id' => 2, 'menu_id' => 1106],
            ['role_id' => 2, 'menu_id' => 1107],
            ['role_id' => 2, 'menu_id' => 1111],
            ['role_id' => 2, 'menu_id' => 1112],
            ['role_id' => 2, 'menu_id' => 1113],
            ['role_id' => 2, 'menu_id' => 1114],
            ['role_id' => 2, 'menu_id' => 1200],
            ['role_id' => 2, 'menu_id' => 1201],
            ['role_id' => 2, 'menu_id' => 1202],
            ['role_id' => 2, 'menu_id' => 1203],
            ['role_id' => 2, 'menu_id' => 1204],
            ['role_id' => 2, 'menu_id' => 1205],
            ['role_id' => 2, 'menu_id' => 1206],
            ['role_id' => 2, 'menu_id' => 1207],
            ['role_id' => 2, 'menu_id' => 1300],
            ['role_id' => 2, 'menu_id' => 1301],
            ['role_id' => 2, 'menu_id' => 1302],
            ['role_id' => 2, 'menu_id' => 1303],
            ['role_id' => 2, 'menu_id' => 1304],
            ['role_id' => 2, 'menu_id' => 1305],
            ['role_id' => 2, 'menu_id' => 1306],
            ['role_id' => 2, 'menu_id' => 1307],
            ['role_id' => 2, 'menu_id' => 1311],
            ['role_id' => 2, 'menu_id' => 1400],
            ['role_id' => 2, 'menu_id' => 1401],
            ['role_id' => 2, 'menu_id' => 1402],
            ['role_id' => 2, 'menu_id' => 1403],
            ['role_id' => 2, 'menu_id' => 1404],
            ['role_id' => 2, 'menu_id' => 1405],
            ['role_id' => 2, 'menu_id' => 1406],
            ['role_id' => 2, 'menu_id' => 1407],
            ['role_id' => 2, 'menu_id' => 1411],
            ['role_id' => 2, 'menu_id' => 1412],
            ['role_id' => 2, 'menu_id' => 1413],
            ['role_id' => 2, 'menu_id' => 1500],
            ['role_id' => 2, 'menu_id' => 1501],
            ['role_id' => 2, 'menu_id' => 1502],
            ['role_id' => 2, 'menu_id' => 1503],
            ['role_id' => 2, 'menu_id' => 1504],
            ['role_id' => 2, 'menu_id' => 1505],
            ['role_id' => 2, 'menu_id' => 1506],
            ['role_id' => 2, 'menu_id' => 1507],
            ['role_id' => 2, 'menu_id' => 1511],
            ['role_id' => 2, 'menu_id' => 1512],
            ['role_id' => 2, 'menu_id' => 1513],
            ['role_id' => 2, 'menu_id' => 2000],
            ['role_id' => 2, 'menu_id' => 2100],
            ['role_id' => 2, 'menu_id' => 2101],
            ['role_id' => 2, 'menu_id' => 2102],
            ['role_id' => 2, 'menu_id' => 2103],
            ['role_id' => 2, 'menu_id' => 2104],
            ['role_id' => 2, 'menu_id' => 2105],
            ['role_id' => 2, 'menu_id' => 2106],
            ['role_id' => 2, 'menu_id' => 2107],
            ['role_id' => 2, 'menu_id' => 2112],
            ['role_id' => 2, 'menu_id' => 2200],
            ['role_id' => 2, 'menu_id' => 2201],
            ['role_id' => 2, 'menu_id' => 2202],
            ['role_id' => 2, 'menu_id' => 2203],
            ['role_id' => 2, 'menu_id' => 2204],
            ['role_id' => 2, 'menu_id' => 2300],
            ['role_id' => 2, 'menu_id' => 2301],
            ['role_id' => 2, 'menu_id' => 2302],
            ['role_id' => 2, 'menu_id' => 2303],
            ['role_id' => 2, 'menu_id' => 2304],
            ['role_id' => 2, 'menu_id' => 2700],
            ['role_id' => 2, 'menu_id' => 2701],
            ['role_id' => 2, 'menu_id' => 2702],
            ['role_id' => 2, 'menu_id' => 2703],
            ['role_id' => 2, 'menu_id' => 2704],
            ['role_id' => 2, 'menu_id' => 2705],
            ['role_id' => 2, 'menu_id' => 2706],
            ['role_id' => 2, 'menu_id' => 2707],
            ['role_id' => 2, 'menu_id' => 3000],
            ['role_id' => 2, 'menu_id' => 3200],
            ['role_id' => 2, 'menu_id' => 3300],
            ['role_id' => 2, 'menu_id' => 3400],
            ['role_id' => 2, 'menu_id' => 3401],
            ['role_id' => 2, 'menu_id' => 3500],
            ['role_id' => 2, 'menu_id' => 3501],
            ['role_id' => 2, 'menu_id' => 4000],
            ['role_id' => 2, 'menu_id' => 4200],
            ['role_id' => 2, 'menu_id' => 4400],
            ['role_id' => 2, 'menu_id' => 4401],
            ['role_id' => 2, 'menu_id' => 4402],
            ['role_id' => 2, 'menu_id' => 4403],
            ['role_id' => 2, 'menu_id' => 4404],
            ['role_id' => 2, 'menu_id' => 4405],
            ['role_id' => 2, 'menu_id' => 4408],
            ['role_id' => 2, 'menu_id' => 4409],
            ['role_id' => 2, 'menu_id' => 4500],
            ['role_id' => 2, 'menu_id' => 4502],
            ['role_id' => 2, 'menu_id' => 4504],
            ['role_id' => 2, 'menu_id' => 4505],
            ['role_id' => 2, 'menu_id' => 4506],
            ['role_id' => 2, 'menu_id' => 4507],
            ['role_id' => 2, 'menu_id' => 4602],
            ['role_id' => 2, 'menu_id' => 4604],
            ['role_id' => 2, 'menu_id' => 4605],
            ['role_id' => 2, 'menu_id' => 4612],
            ['role_id' => 2, 'menu_id' => 4613],
            ['role_id' => 2, 'menu_id' => 4614],
            ['role_id' => 2, 'menu_id' => 4615]
        ];

        $table->insert($data)->save();
    }

    public function down()
    {
        $this->table('eb_system_role_menu')->drop()->save();
    }
}
