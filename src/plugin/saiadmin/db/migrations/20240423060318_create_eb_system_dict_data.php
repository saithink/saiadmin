<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateEbSystemDictData extends AbstractMigration
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
        $table = $this->table('eb_system_dict_data', [
            'id' => false,
            'primary_key' => 'id',
            'comment' => '字典数据表'
        ]);
        $table->addColumn('id', 'integer', ['signed' => false, 'identity' => true])
            ->addColumn('type_id', 'integer', ['null' => true, 'default' => null, 'comment' => '字典类型ID'])
            ->addColumn('label', 'string', ['limit' => 50, 'null' => true, 'default' => null, 'collation' => 'utf8_general_ci', 'comment' => '字典标签'])
            ->addColumn('value', 'string', ['limit' => 100, 'null' => true, 'default' => null, 'collation' => 'utf8_general_ci', 'comment' => '字典值'])
            ->addColumn('code', 'string', ['limit' => 100, 'null' => true, 'default' => null, 'collation' => 'utf8_general_ci', 'comment' => '字典标示'])
            ->addColumn('sort', 'integer', ['null' => true, 'default' => 0, 'comment' => '排序'])
            ->addColumn('status', 'integer', ['null' => true, 'default' => 1, 'comment' => '状态 (1正常 2停用)'])
            ->addColumn('remark', 'string', ['limit' => 255, 'null' => true, 'default' => null, 'collation' => 'utf8_general_ci', 'comment' => '备注'])
            ->addColumn('created_by', 'integer', ['null' => true, 'default' => null, 'comment' => '创建者'])
            ->addColumn('updated_by', 'integer', ['null' => true, 'default' => null, 'comment' => '更新者'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '修改时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '删除时间'])
            ->addIndex('type_id')
            ->create();

        $data = [
            [
                'id' => 1,
                'type_id' => 1,
                'label' => 'InnoDB',
                'value' => 'InnoDB',
                'code' => 'table_engine',
                'sort' => 1,
                'status' => 1,
                'remark' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2021-06-27 00:37:11',
                'update_time' => '2023-12-06 21:54:25',
                'delete_time' => null
            ],
            [
                'id' => 2,
                'type_id' => 1,
                'label' => 'MyISAM',
                'value' => 'MyISAM',
                'code' => 'table_engine',
                'sort' => 1,
                'status' => 1,
                'remark' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2021-06-27 00:37:21',
                'update_time' => '2023-11-16 11:51:35',
                'delete_time' => null
            ],
            [
                'id' => 3,
                'type_id' => 2,
                'label' => '本地存储',
                'value' => '1',
                'code' => 'upload_mode',
                'sort' => 99,
                'status' => 1,
                'remark' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2021-06-27 13:33:43',
                'update_time' => '2021-06-27 13:33:43',
                'delete_time' => null
            ],
            [
                'id' => 4,
                'type_id' => 2,
                'label' => '阿里云OSS',
                'value' => '2',
                'code' => 'upload_mode',
                'sort' => 98,
                'status' => 1,
                'remark' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2021-06-27 13:33:55',
                'update_time' => '2021-06-27 13:33:55',
                'delete_time' => null
            ],
            [
                'id' => 5,
                'type_id' => 2,
                'label' => '七牛云',
                'value' => '3',
                'code' => 'upload_mode',
                'sort' => 97,
                'status' => 1,
                'remark' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2021-06-27 13:34:07',
                'update_time' => '2023-12-13 16:50:26',
                'delete_time' => null
            ],
            [
                'id' => 6,
                'type_id' => 2,
                'label' => '腾讯云COS',
                'value' => '4',
                'code' => 'upload_mode',
                'sort' => 96,
                'status' => 1,
                'remark' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2021-06-27 13:34:19',
                'update_time' => '2023-12-13 16:47:34',
                'delete_time' => null
            ],
            [
                'id' => 7,
                'type_id' => 3,
                'label' => '正常',
                'value' => '1',
                'code' => 'data_status',
                'sort' => 0,
                'status' => 1,
                'remark' => '1为正常',
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2021-06-27 13:36:51',
                'update_time' => '2021-06-27 13:37:01',
                'delete_time' => null
            ],
            [
                'id' => 8,
                'type_id' => 3,
                'label' => '停用',
                'value' => '2',
                'code' => 'data_status',
                'sort' => 0,
                'status' => 1,
                'remark' => '2为停用',
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2021-06-27 13:37:10',
                'update_time' => '2021-06-27 13:37:10',
                'delete_time' => null
            ],
            [
                'id' => 9,
                'type_id' => 4,
                'label' => '统计页面',
                'value' => 'statistics',
                'code' => 'dashboard',
                'sort' => 0,
                'status' => 1,
                'remark' => '管理员用',
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2021-08-09 12:53:53',
                'update_time' => '2023-11-16 11:39:17',
                'delete_time' => null
            ],
            [
                'id' => 10,
                'type_id' => 4,
                'label' => '工作台',
                'value' => 'work',
                'code' => 'dashboard',
                'sort' => 0,
                'status' => 1,
                'remark' => '员工使用',
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2021-08-09 12:54:18',
                'update_time' => '2021-08-09 12:54:18',
                'delete_time' => null
            ],
            [
                'id' => 11,
                'type_id' => 5,
                'label' => '男',
                'value' => '1',
                'code' => 'sex',
                'sort' => 0,
                'status' => 1,
                'remark' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2021-08-09 12:55:00',
                'update_time' => '2021-08-09 12:55:00',
                'delete_time' => null
            ],
            [
                'id' => 12,
                'type_id' => 5,
                'label' => '女',
                'value' => '2',
                'code' => 'sex',
                'sort' => 0,
                'status' => 1,
                'remark' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2021-08-09 12:55:08',
                'update_time' => '2021-08-09 12:55:08',
                'delete_time' => null
            ],
            [
                'id' => 13,
                'type_id' => 5,
                'label' => '未知',
                'value' => '3',
                'code' => 'sex',
                'sort' => 0,
                'status' => 1,
                'remark' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2021-08-09 12:55:16',
                'update_time' => '2021-08-09 12:55:16',
                'delete_time' => null
            ],
            [
                'id' => 22,
                'type_id' => 7,
                'label' => '通知',
                'value' => '1',
                'code' => 'backend_notice_type',
                'sort' => 2,
                'status' => 1,
                'remark' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2021-11-11 17:29:27',
                'update_time' => '2021-11-11 17:30:51',
                'delete_time' => null
            ],
            [
                'id' => 23,
                'type_id' => 7,
                'label' => '公告',
                'value' => '2',
                'code' => 'backend_notice_type',
                'sort' => 1,
                'status' => 1,
                'remark' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2021-11-11 17:31:42',
                'update_time' => '2021-11-11 17:31:42',
                'delete_time' => null
            ],
            [
                'id' => 24,
                'type_id' => 8,
                'label' => '所有',
                'value' => 'A',
                'code' => 'request_mode',
                'sort' => 5,
                'status' => 1,
                'remark' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2021-11-14 17:23:25',
                'update_time' => '2023-12-13 17:21:28',
                'delete_time' => null
            ],
            [
                'id' => 25,
                'type_id' => 8,
                'label' => 'GET',
                'value' => 'G',
                'code' => 'request_mode',
                'sort' => 4,
                'status' => 1,
                'remark' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2021-11-14 17:23:45',
                'update_time' => '2023-12-13 17:21:28',
                'delete_time' => null
            ],
            [
                'id' => 26,
                'type_id' => 8,
                'label' => 'POST',
                'value' => 'P',
                'code' => 'request_mode',
                'sort' => 3,
                'status' => 1,
                'remark' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2021-11-14 17:23:38',
                'update_time' => '2023-12-13 17:21:28',
                'delete_time' => null
            ],
            [
                'id' => 27,
                'type_id' => 8,
                'label' => 'PUT',
                'value' => 'U',
                'code' => 'request_mode',
                'sort' => 2,
                'status' => 1,
                'remark' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2021-11-14 17:23:45',
                'update_time' => '2023-12-13 17:21:28',
                'delete_time' => null
            ],
            [
                'id' => 28,
                'type_id' => 8,
                'label' => 'DELETE',
                'value' => 'D',
                'code' => 'request_mode',
                'sort' => 1,
                'status' => 1,
                'remark' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2021-11-14 17:23:45',
                'update_time' => '2023-12-13 17:21:28',
                'delete_time' => null
            ],
            [
                'id' => 39,
                'type_id' => 6,
                'label' => '通知',
                'value' => 'notice',
                'code' => 'queue_msg_type',
                'sort' => 1,
                'status' => 1,
                'remark' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2021-12-25 18:30:31',
                'update_time' => '2024-01-20 14:42:55',
                'delete_time' => null
            ],
            [
                'id' => 40,
                'type_id' => 6,
                'label' => '公告',
                'value' => 'announcement',
                'code' => 'queue_msg_type',
                'sort' => 2,
                'status' => 1,
                'remark' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2021-12-25 18:31:00',
                'update_time' => '2024-01-20 14:42:57',
                'delete_time' => null
            ],
            [
                'id' => 41,
                'type_id' => 6,
                'label' => '待办',
                'value' => 'todo',
                'code' => 'queue_msg_type',
                'sort' => 3,
                'status' => 1,
                'remark' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2021-12-25 18:31:26',
                'update_time' => '2024-01-20 14:42:59',
                'delete_time' => null
            ],
            [
                'id' => 42,
                'type_id' => 6,
                'label' => '抄送我的',
                'value' => 'carbon_copy_mine',
                'code' => 'queue_msg_type',
                'sort' => 4,
                'status' => 1,
                'remark' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2021-12-25 18:31:26',
                'update_time' => '2024-01-20 14:42:59',
                'delete_time' => null
            ],
            [
                'id' => 43,
                'type_id' => 6,
                'label' => '私信',
                'value' => 'private_message',
                'code' => 'queue_msg_type',
                'sort' => 5,
                'status' => 1,
                'remark' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2021-12-25 18:31:26',
                'update_time' => '2024-01-20 14:42:59',
                'delete_time' => null
            ],
            [
                'id' => 44,
                'type_id' => 12,
                'label' => '图片',
                'value' => 'image',
                'code' => 'attachment_type',
                'sort' => 10,
                'status' => 1,
                'remark' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2022-03-17 14:49:59',
                'update_time' => '2022-03-17 14:49:59',
                'delete_time' => null
            ],
            [
                'id' => 45,
                'type_id' => 12,
                'label' => '文档',
                'value' => 'text',
                'code' => 'attachment_type',
                'sort' => 9,
                'status' => 1,
                'remark' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2022-03-17 14:50:20',
                'update_time' => '2022-03-17 14:50:49',
                'delete_time' => null
            ],
            [
                'id' => 46,
                'type_id' => 12,
                'label' => '音频',
                'value' => 'audio',
                'code' => 'attachment_type',
                'sort' => 8,
                'status' => 1,
                'remark' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2022-03-17 14:50:37',
                'update_time' => '2022-03-17 14:50:52',
                'delete_time' => null
            ],
            [
                'id' => 47,
                'type_id' => 12,
                'label' => '视频',
                'value' => 'video',
                'code' => 'attachment_type',
                'sort' => 7,
                'status' => 1,
                'remark' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2022-03-17 14:50:45',
                'update_time' => '2022-03-17 14:50:57',
                'delete_time' => null
            ],
            [
                'id' => 48,
                'type_id' => 12,
                'label' => '应用程序',
                'value' => 'application',
                'code' => 'attachment_type',
                'sort' => 6,
                'status' => 1,
                'remark' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'create_time' => '2022-03-17 14:50:52',
                'update_time' => '2022-03-17 14:50:59',
                'delete_time' => null
            ]
        ];

        $table->insert($data)->save();
    }

    public function down()
    {
        $this->table('eb_system_dict_data')->drop()->save();
    }
}
