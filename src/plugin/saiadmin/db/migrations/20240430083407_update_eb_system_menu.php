<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UpdateEbSystemMenu extends AbstractMigration
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
        $data = [
            [
                'parent_id' => 4612,
                'level' => '0,4602,4612',
                'name' => '文章分类销毁',
                'code' => '/news/category/realDestroy',
                'type' => 'B',
                'status' => 1,
                'sort' => 0,
                'is_hidden' => 2,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2024-04-30 16:30:00',
                'update_time' => '2023-04-30 16:30:00',
                'delete_time' => null,
            ],
            [
                'parent_id' => 4604,
                'level' => '0,4602,4604',
                'name' => '文章管理销毁',
                'code' => '/news/article/realDestroy',
                'type' => 'B',
                'status' => 1,
                'sort' => 0,
                'is_hidden' => 2,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2024-04-30 16:30:00',
                'update_time' => '2023-04-30 16:30:00',
                'delete_time' => null,
            ],
            [
                'parent_id' => 1100,
                'level' => '0,1000,1100',
                'name' => '用户销毁',
                'code' => '/core/user/realDestroy',
                'type' => 'B',
                'status' => 1,
                'sort' => 0,
                'is_hidden' => 2,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2024-04-30 16:30:00',
                'update_time' => '2023-04-30 16:30:00',
                'delete_time' => null,
            ],
            [
                'parent_id' => 1200,
                'level' => '0,1000,1200',
                'name' => '菜单销毁',
                'code' => '/core/menu/realDestroy',
                'type' => 'B',
                'status' => 1,
                'sort' => 0,
                'is_hidden' => 2,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2024-04-30 16:30:00',
                'update_time' => '2023-04-30 16:30:00',
                'delete_time' => null,
            ],
            [
                'parent_id' => 1300,
                'level' => '0,1000,1300',
                'name' => '部门销毁',
                'code' => '/core/dept/realDestroy',
                'type' => 'B',
                'status' => 1,
                'sort' => 0,
                'is_hidden' => 2,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2024-04-30 16:30:00',
                'update_time' => '2023-04-30 16:30:00',
                'delete_time' => null,
            ],
            [
                'parent_id' => 1400,
                'level' => '0,1000,1400',
                'name' => '角色销毁',
                'code' => '/core/role/realDestroy',
                'type' => 'B',
                'status' => 1,
                'sort' => 0,
                'is_hidden' => 2,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2024-04-30 16:30:00',
                'update_time' => '2023-04-30 16:30:00',
                'delete_time' => null,
            ],
            [
                'parent_id' => 1500,
                'level' => '0,1000,1500',
                'name' => '岗位销毁',
                'code' => '/core/post/realDestroy',
                'type' => 'B',
                'status' => 1,
                'sort' => 0,
                'is_hidden' => 2,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2024-04-30 16:30:00',
                'update_time' => '2023-04-30 16:30:00',
                'delete_time' => null,
            ],
            [
                'parent_id' => 2200,
                'level' => '0,2000,2200',
                'name' => '附件销毁',
                'code' => '/core/attachment/realDestroy',
                'type' => 'B',
                'status' => 1,
                'sort' => 0,
                'is_hidden' => 2,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2024-04-30 16:30:00',
                'update_time' => '2023-04-30 16:30:00',
                'delete_time' => null,
            ],
            [
                'parent_id' => 2700,
                'level' => '0,2000,2700',
                'name' => '系统公告销毁',
                'code' => '/core/notice/realDestroy',
                'type' => 'B',
                'status' => 1,
                'sort' => 0,
                'is_hidden' => 2,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2024-04-30 16:30:00',
                'update_time' => '2023-04-30 16:30:00',
                'delete_time' => null,
            ],
            [
                'parent_id' => 2100,
                'level' => '0,2000,2100',
                'name' => '数据字典销毁',
                'code' => '/core/dictType/realDestroy',
                'type' => 'B',
                'status' => 1,
                'sort' => 0,
                'is_hidden' => 2,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2024-04-30 16:30:00',
                'update_time' => '2023-04-30 16:30:00',
                'delete_time' => null,
            ],
        ];
        $this->table('eb_system_menu')->insert($data)->save();
    }

    public function down()
    {
        $this->execute("DELETE FROM eb_system_menu where parent_id = 4612 and code = '/news/category/realDestroy' ");
        $this->execute("DELETE FROM eb_system_menu where parent_id = 4604 and code = '/news/article/realDestroy' ");
        $this->execute("DELETE FROM eb_system_menu where parent_id = 1100 and code = '/core/user/realDestroy' ");
        $this->execute("DELETE FROM eb_system_menu where parent_id = 1200 and code = '/core/menu/realDestroy' ");
        $this->execute("DELETE FROM eb_system_menu where parent_id = 1300 and code = '/core/dept/realDestroy' ");
        $this->execute("DELETE FROM eb_system_menu where parent_id = 1400 and code = '/core/role/realDestroy' ");
        $this->execute("DELETE FROM eb_system_menu where parent_id = 1500 and code = '/core/post/realDestroy' ");
        $this->execute("DELETE FROM eb_system_menu where parent_id = 2200 and code = '/core/attachment/realDestroy' ");
        $this->execute("DELETE FROM eb_system_menu where parent_id = 2700 and code = '/core/notice/realDestroy' ");
        $this->execute("DELETE FROM eb_system_menu where parent_id = 2100 and code = '/core/dictType/realDestroy' ");
    }
}
