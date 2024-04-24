<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateEbSystemConfig extends AbstractMigration
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
        $table = $this->table('eb_system_config', [
            'comment' => '参数配置信息表',
            'id' => false,
            'primary_key' => ['id']
        ]);
        $table->addColumn('id', 'integer', ['signed' => false, 'identity' => true])
            ->addColumn('group_id', 'integer', ['null' => true, 'default' => null, 'comment' => '组id'])
            ->addColumn('key', 'string', ['limit' => 32, 'comment' => '配置键名'])
            ->addColumn('value', 'string', ['limit' => 1000, 'null' => true, 'default' => null, 'comment' => '配置值'])
            ->addColumn('name', 'string', ['limit' => 255, 'null' => true, 'default' => null, 'comment' => '配置名称'])
            ->addColumn('input_type', 'string', ['limit' => 32, 'null' => true, 'default' => null, 'comment' => '数据输入类型'])
            ->addColumn('config_select_data', 'string', ['limit' => 500, 'null' => true, 'default' => null, 'comment' => '配置选项数据'])
            ->addColumn('sort', 'integer', ['null' => true, 'default' => 0, 'comment' => '排序'])
            ->addColumn('remark', 'string', ['limit' => 255, 'null' => true, 'default' => null, 'comment' => '备注'])
            ->addIndex('group_id', ['name' => 'idx_group_id'])
            ->create();

        $data = [
            [
                'id' => 1,
                'group_id' => 1,
                'key' => 'site_copyright',
                'value' => 'Copyright © 2024 saithink',
                'name' => '版权信息',
                'input_type' => 'textarea',
                'sort' => 96,
                'remark' => ''
            ],
            [
                'id' => 2,
                'group_id' => 1,
                'key' => 'site_desc',
                'value' => '基于vue3 + webman 的极速开发框架',
                'name' => '网站描述',
                'input_type' => 'textarea',
                'sort' => 97,
                'remark' => null
            ],
            [
                'id' => 3,
                'group_id' => 1,
                'key' => 'site_keywords',
                'value' => '后台管理系统',
                'name' => '网站关键字',
                'input_type' => 'input',
                'sort' => 98,
                'remark' => null
            ],
            [
                'id' => 4,
                'group_id' => 1,
                'key' => 'site_name',
                'value' => 'SaiAdmin',
                'name' => '网站名称',
                'input_type' => 'input',
                'sort' => 99,
                'remark' => null
            ],
            [
                'id' => 5,
                'group_id' => 1,
                'key' => 'site_record_number',
                'value' => '',
                'name' => '网站备案号',
                'input_type' => 'input',
                'sort' => 95,
                'remark' => null
            ],
            [
                'id' => 6,
                'group_id' => 2,
                'key' => 'upload_allow_file',
                'value' => 'txt,doc,docx,xls,xlsx,ppt,pptx,rar,zip,7z,gz,pdf,wps,md',
                'name' => '文件类型',
                'input_type' => 'input',
                'sort' => 0,
                'remark' => null
            ],
            [
                'id' => 7,
                'group_id' => 2,
                'key' => 'upload_allow_image',
                'value' => 'jpg,jpeg,png,gif,svg,bmp',
                'name' => '图片类型',
                'input_type' => 'input',
                'sort' => 0,
                'remark' => null
            ],
            [
                'id' => 8,
                'group_id' => 2,
                'key' => 'upload_mode',
                'value' => '1',
                'name' => '上传模式',
                'input_type' => 'select',
                'config_select_data' => '[{"label":"本地上传","value":"1"},{"label":"阿里云OSS","value":"2"},{"label":"七牛云","value":"3"},{"label":"腾讯云COS","value":"4"}]',
                'sort' => 99,
                'remark' => null
            ],
            [
                'id' => 10,
                'group_id' => 2,
                'key' => 'upload_size',
                'value' => '5242880',
                'name' => '上传大小',
                'input_type' => 'input',
                'sort' => 88,
                'remark' => '单位Byte,1MB=1024*1024Byte'
            ],
        ];

        $table->insert($data)->save();
    }

    public function down()
    {
        $this->table('eb_system_config')->drop()->save();
    }
}
