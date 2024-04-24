<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateEbSystemCrontab extends AbstractMigration
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
        $table = $this->table('eb_system_crontab', [
            'comment' => '定时任务信息表',
            'id' => false,
            'primary_key' => ['id']
        ]);
        $table->addColumn('id', 'integer', ['signed' => false, 'identity' => true])
            ->addColumn('name', 'string', ['limit' => 100, 'null' => true, 'default' => null, 'comment' => '任务名称'])
            ->addColumn('type', 'integer', ['null' => true, 'default' => 1, 'comment' => '任务类型'])
            ->addColumn('target', 'string', ['limit' => 500, 'null' => true, 'default' => null, 'comment' => '调用任务字符串'])
            ->addColumn('parameter', 'string', ['limit' => 1000, 'null' => true, 'default' => null, 'comment' => '调用任务参数'])
            ->addColumn('rule', 'string', ['limit' => 32, 'null' => true, 'default' => null, 'comment' => '任务执行表达式'])
            ->addColumn('singleton', 'integer', ['null' => true, 'default' => 1, 'comment' => '是否单次执行 (1 是 2 不是)'])
            ->addColumn('status', 'integer', ['null' => true, 'default' => 1, 'comment' => '状态 (1正常 2停用)'])
            ->addColumn('remark', 'string', ['limit' => 255, 'null' => true, 'default' => null, 'comment' => '备注'])
            ->addColumn('created_by', 'integer', ['null' => true, 'default' => null, 'comment' => '创建者'])
            ->addColumn('updated_by', 'integer', ['null' => true, 'default' => null, 'comment' => '更新者'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '修改时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '删除时间'])
            ->create();

        // Insert initial records
        $data = [
            [
                'name' => '访问官网',
                'type' => 1,
                'target' => 'https://saithink.top',
                'rule' => '0 0 8 * * *',
                'singleton' => 2,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2024-01-20 14:21:11',
                'update_time' => '2024-01-20 15:26:41',
                'delete_time' => null
            ],
            [
                'name' => '登录gitee',
                'type' => 2,
                'target' => 'https://gitee.com/check_user_login',
                'parameter' => '{"user_login": "saiadmin"}',
                'rule' => '0 0 10 * * *',
                'singleton' => 2,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2024-01-20 14:31:51',
                'update_time' => '2024-01-20 15:21:33',
                'delete_time' => null
            ],
            [
                'name' => '定时执行任务',
                'type' => 3,
                'target' => '\\plugin\\saiadmin\\process\\Task',
                'parameter' => '{"type":"1"}',
                'rule' => '0 0 12 * * *',
                'singleton' => 2,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2024-01-20 14:38:03',
                'update_time' => '2024-01-20 15:21:42',
                'delete_time' => null
            ]
        ];

        $table->insert($data)->save();
    }

    public function down()
    {
        $this->table('eb_system_crontab')->drop()->save();
    }
}
