<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateEbSystemOperLog extends AbstractMigration
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
        $table = $this->table('eb_system_oper_log', [
            'id' => false,
            'primary_key' => ['id'],
            'comment' => '操作日志表'
        ]);
        $table->addColumn('id', 'integer', ['signed' => false, 'identity' => true])
            ->addColumn('username', 'string', ['limit' => 20, 'null' => true, 'default' => null, 'comment' => '用户名'])
            ->addColumn('app', 'string', ['limit' => 50, 'null' => true, 'default' => null, 'comment' => '应用名称'])
            ->addColumn('method', 'string', ['limit' => 20, 'null' => true, 'default' => null, 'comment' => '请求方式'])
            ->addColumn('router', 'string', ['limit' => 500, 'null' => true, 'default' => null, 'comment' => '请求路由'])
            ->addColumn('service_name', 'string', ['limit' => 30, 'null' => true, 'default' => null, 'comment' => '业务名称'])
            ->addColumn('ip', 'string', ['limit' => 45, 'null' => true, 'default' => null, 'comment' => '请求IP地址'])
            ->addColumn('ip_location', 'string', ['limit' => 255, 'null' => true, 'default' => null, 'comment' => 'IP所属地'])
            ->addColumn('request_data', 'text', ['null' => true, 'comment' => '请求数据'])
            ->addColumn('remark', 'string', ['limit' => 255, 'null' => true, 'default' => null, 'comment' => '备注'])
            ->addColumn('created_by', 'integer', ['null' => true, 'default' => null, 'comment' => '创建者'])
            ->addColumn('updated_by', 'integer', ['null' => true, 'default' => null, 'comment' => '更新者'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '更新时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '删除时间'])
            ->addIndex(['username'], ['name' => 'username_index'])
            ->create();
    }

    public function down()
    {
        $this->table('eb_system_oper_log')->drop()->save();
    }
}
