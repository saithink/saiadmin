<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateEbSystemCrontabLog extends AbstractMigration
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
        $table = $this->table('eb_system_crontab_log', [
            'id' => false,
            'primary_key' => ['id'],
            'comment' => '定时任务执行日志表'
        ]);
        $table->addColumn('id', 'integer', ['signed' => false, 'identity' => true])
            ->addColumn('crontab_id', 'integer', ['null' => true, 'default' => null, 'comment' => '任务ID'])
            ->addColumn('name', 'string', ['limit' => 255, 'null' => true, 'default' => null, 'comment' => '任务名称'])
            ->addColumn('target', 'string', ['limit' => 500, 'null' => true, 'default' => null, 'comment' => '任务调用目标字符串'])
            ->addColumn('parameter', 'string', ['limit' => 1000, 'null' => true, 'default' => null, 'comment' => '任务调用参数'])
            ->addColumn('exception_info', 'string', ['limit' => 2000, 'null' => true, 'default' => null, 'comment' => '异常信息'])
            ->addColumn('status', 'integer', ['null' => true, 'default' => 1, 'comment' => '执行状态 (1成功 2失败)'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '修改时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '删除时间'])
            ->create();
    }

    public function down()
    {
        $this->table('eb_system_crontab_log')->drop()->save();
    }
}
