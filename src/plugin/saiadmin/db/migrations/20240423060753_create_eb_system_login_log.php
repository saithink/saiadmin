<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateEbSystemLoginLog extends AbstractMigration
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
        $table = $this->table('eb_system_login_log', ['comment' => '登录日志表']);
        $table->addColumn('username', 'string', ['limit' => 20, 'null' => true, 'comment' => '用户名'])
            ->addColumn('ip', 'string', ['limit' => 45, 'null' => true, 'comment' => '登录IP地址'])
            ->addColumn('ip_location', 'string', ['limit' => 255, 'null' => true, 'comment' => 'IP所属地'])
            ->addColumn('os', 'string', ['limit' => 50, 'null' => true, 'comment' => '操作系统'])
            ->addColumn('browser', 'string', ['limit' => 50, 'null' => true, 'comment' => '浏览器'])
            ->addColumn('status', 'integer', ['null' => true, 'default' => 1, 'comment' => '登录状态 (1成功 2失败)'])
            ->addColumn('message', 'string', ['limit' => 50, 'null' => true, 'comment' => '提示消息'])
            ->addColumn('login_time', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '登录时间'])
            ->addColumn('remark', 'string', ['limit' => 255, 'null' => true, 'comment' => '备注'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'comment' => '更新时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'comment' => '删除时间'])
            ->addIndex('username', ['name' => 'idx_username'])
            ->create();
    }

    public function down()
    {
        $this->table('eb_system_login_log')->drop()->save();
    }
}
