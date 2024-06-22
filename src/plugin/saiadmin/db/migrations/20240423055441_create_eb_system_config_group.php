<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateEbSystemConfigGroup extends AbstractMigration
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
        $table = $this->table('eb_system_config_group', [
            'comment' => '参数配置分组表',
            'id' => false,
            'primary_key' => ['id']
        ]);
        $table->addColumn('id', 'integer', ['signed' => false, 'identity' => true])
            ->addColumn('name', 'string', ['limit' => 50, 'null' => true, 'default' => null, 'comment' => '字典名称'])
            ->addColumn('code', 'string', ['limit' => 100, 'null' => true, 'default' => null, 'comment' => '字典标示'])
            ->addColumn('remark', 'string', ['limit' => 255, 'null' => true, 'default' => null, 'comment' => '备注'])
            ->addColumn('created_by', 'integer', ['null' => true, 'default' => null, 'comment' => '创建人'])
            ->addColumn('updated_by', 'integer', ['null' => true, 'default' => null, 'comment' => '更新人'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '修改时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '删除时间'])
            ->create();

        // Insert initial records
        $data = [
            [
                'id' => 1,
                'name' => '站点配置',
                'code' => 'site_config',
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2021-11-23 10:49:29',
                'update_time' => '2021-11-23 10:49:29',
                'delete_time' => null
            ],
            [
                'id' => 2,
                'name' => '上传配置',
                'code' => 'upload_config',
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2021-11-23 10:49:29',
                'update_time' => '2021-11-23 10:49:29',
                'delete_time' => null
            ]
        ];

        $table->insert($data)->save();
    }

    public function down()
    {
        $this->table('eb_system_config_group')->drop()->save();
    }
}
