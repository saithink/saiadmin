<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateEbSystemUser extends AbstractMigration
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
        $table = $this->table('eb_system_user', [
            'id' => false,
            'primary_key' => 'id',
            'comment' => '用户信息表'
        ]);
        $table->addColumn('id', 'integer', ['signed' => false, 'identity' => true])
            ->addColumn('username', 'string', ['limit' => 20, 'null' => false, 'comment' => '用户名'])
            ->addColumn('password', 'string', ['limit' => 100, 'null' => false, 'comment' => '密码'])
            ->addColumn('user_type', 'string', ['limit' => 3, 'null' => true, 'default' => '100', 'comment' => '用户类型:(100系统用户)'])
            ->addColumn('nickname', 'string', ['limit' => 30, 'null' => true, 'default' => null, 'comment' => '用户昵称'])
            ->addColumn('phone', 'string', ['limit' => 11, 'null' => true, 'default' => null, 'comment' => '手机'])
            ->addColumn('email', 'string', ['limit' => 50, 'null' => true, 'default' => null, 'comment' => '用户邮箱'])
            ->addColumn('avatar', 'string', ['limit' => 255, 'null' => true, 'default' => null, 'comment' => '用户头像'])
            ->addColumn('signed', 'string', ['limit' => 255, 'null' => true, 'default' => null, 'comment' => '个人签名'])
            ->addColumn('dashboard', 'string', ['limit' => 100, 'null' => true, 'default' => null, 'comment' => '后台首页类型'])
            ->addColumn('dept_id', 'integer', ['null' => true, 'default' => null, 'comment' => '部门ID'])
            ->addColumn('status', 'integer', ['null' => true, 'default' => 1, 'comment' => '状态 (1正常 2停用)'])
            ->addColumn('login_ip', 'string', ['limit' => 45, 'null' => true, 'default' => null, 'comment' => '最后登陆IP'])
            ->addColumn('login_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '最后登陆时间'])
            ->addColumn('backend_setting', 'string', ['limit' => 500, 'null' => true, 'default' => null, 'comment' => '后台设置数据'])
            ->addColumn('remark', 'string', ['limit' => 255, 'null' => true, 'default' => null, 'comment' => '备注'])
            ->addColumn('created_by', 'integer', ['null' => true, 'default' => null, 'comment' => '创建者'])
            ->addColumn('updated_by', 'integer', ['null' => true, 'default' => null, 'comment' => '更新者'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '修改时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '删除时间'])
            ->addIndex('username', ['name' => 'unx_dept_id', 'unique' => true])
            ->addIndex('dept_id', ['name' => 'idx_dept_id'])
            ->create();

        $data = [
            [
                'id' => 1,
                'username' => 'admin',
                'password' => '$2y$10$Q70WC9RBqMSS72DmppsbIuQtyAydXSmeD.Ae6W8YhmE/w15uLLpiy',
                'user_type' => '100',
                'nickname' => '祭道之上',
                'phone' => '13888888888',
                'email' => 'admin@admin.com',
                'avatar' => 'http://localhost:8787/upload/image/20240120/65ab6c56850a.jpg',
                'signed' => 'Today is very good！',
                'dashboard' => 'statistics',
                'dept_id' => null,
                'status' => 1,
                'login_ip' => '127.0.0.1',
                'login_time' => '2024-01-20 16:02:22',
                'backend_setting' => '{"mode":"light","tag":true,"menuCollapse":false,"menuWidth":230,"layout":"classic","skin":"mine","i18n":true,"language":"zh_CN","animation":"ma-slide-down","color":"#165DFF"}',
                'remark' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2024-01-20 16:02:23',
                'update_time' => '2024-01-20 16:02:23',
                'delete_time' => null,
            ],
            [
                'id' => 2,
                'username' => 'test1',
                'password' => '$2y$10$Q70WC9RBqMSS72DmppsbIuQtyAydXSmeD.Ae6W8YhmE/w15uLLpiy',
                'user_type' => '100',
                'nickname' => '小小测试员',
                'phone' => '15822222222',
                'email' => 'test@saadmin.com',
                'avatar' => 'http://localhost:8787/app/manage/upload/image/20231116/655565cb38b4.jpg',
                'signed' => null,
                'dashboard' => 'work',
                'dept_id' => null,
                'status' => 1,
                'login_ip' => '127.0.0.1',
                'login_time' => '2024-01-20 15:59:17',
                'backend_setting' => 'null',
                'remark' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2023-11-15 14:30:14',
                'update_time' => '2024-01-20 15:59:18',
                'delete_time' => null,
            ],
            [
                'id' => 3,
                'username' => 'test2',
                'password' => '',
                'user_type' => '100',
                'nickname' => '酱油党',
                'phone' => '13977777777',
                'email' => 'zhang@saadmin.com',
                'avatar' => 'http://localhost:8787/upload/image/20231222/65854211f2a6.jpg',
                'signed' => null,
                'dashboard' => 'statistics',
                'dept_id' => null,
                'status' => 1,
                'login_ip' => '127.0.0.1',
                'login_time' => '2023-11-22 22:47:26',
                'backend_setting' => 'null',
                'remark' => '5566',
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2023-11-15 16:27:27',
                'update_time' => '2023-12-22 16:00:24',
                'delete_time' => null,
            ],
        ];

        $table->insert($data)->save();
    }

    public function down()
    {
        $this->table('eb_system_user')->drop()->save();
    }
}
