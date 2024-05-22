<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UpdateEbSystemConfig extends AbstractMigration
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
                'group_id' => 2,
                'key' => 'local_root',
                'value' => 'public/storage/',
                'name' => '本地存储路径',
                'input_type' => 'input',
                'sort' => 0,
                'remark' => '本地存储文件路径'
            ],
            [
                'group_id' => 2,
                'key' => 'local_domain',
                'value' => 'http://127.0.0.1:8787',
                'name' => '本地存储域名',
                'input_type' => 'input',
                'sort' => 0,
                'remark' => 'http://127.0.0.1:8787'
            ],
            [
                'group_id' => 2,
                'key' => 'local_uri',
                'value' => '/storage/',
                'name' => '本地访问路径',
                'input_type' => 'input',
                'sort' => 0,
                'remark' => '访问是通过domain + uri'
            ],
            [
                'group_id' => 2,
                'key' => 'qiniu_accessKey',
                'value' => '',
                'name' => '七牛key',
                'input_type' => 'input',
                'sort' => 0,
                'remark' => '七牛云存储secretId'
            ],
            [
                'group_id' => 2,
                'key' => 'qiniu_secretKey',
                'value' => '',
                'name' => '七牛secret',
                'input_type' => 'input',
                'sort' => 0,
                'remark' => '七牛云存储secretKey'
            ],
            [
                'group_id' => 2,
                'key' => 'qiniu_bucket',
                'value' => '',
                'name' => '七牛bucket',
                'input_type' => 'input',
                'sort' => 0,
                'remark' => '七牛云存储bucket'
            ],
            [
                'group_id' => 2,
                'key' => 'qiniu_dirname',
                'value' => '',
                'name' => '七牛dirname',
                'input_type' => 'input',
                'sort' => 0,
                'remark' => '七牛云存储dirname'
            ],
            [
                'group_id' => 2,
                'key' => 'qiniu_domain',
                'value' => '',
                'name' => '七牛domain',
                'input_type' => 'input',
                'sort' => 0,
                'remark' => '七牛云存储domain'
            ],
            [
                'group_id' => 2,
                'key' => 'cos_secretId',
                'value' => '',
                'name' => '腾讯Id',
                'input_type' => 'input',
                'sort' => 0,
                'remark' => '腾讯云存储secretId'
            ],
            [
                'group_id' => 2,
                'key' => 'cos_secretKey',
                'value' => '',
                'name' => '腾讯key',
                'input_type' => 'input',
                'sort' => 0,
                'remark' => '腾讯云secretKey'
            ],
            [
                'group_id' => 2,
                'key' => 'cos_bucket',
                'value' => '',
                'name' => '腾讯bucket',
                'input_type' => 'input',
                'sort' => 0,
                'remark' => '腾讯云存储bucket'
            ],
            [
                'group_id' => 2,
                'key' => 'cos_dirname',
                'value' => '',
                'name' => '腾讯dirname',
                'input_type' => 'input',
                'sort' => 0,
                'remark' => '腾讯云存储dirname'
            ],
            [
                'group_id' => 2,
                'key' => 'cos_domain',
                'value' => '',
                'name' => '腾讯domain',
                'input_type' => 'input',
                'sort' => 0,
                'remark' => '腾讯云存储domain'
            ],
            [
                'group_id' => 2,
                'key' => 'cos_region',
                'value' => '',
                'name' => '腾讯region',
                'input_type' => 'input',
                'sort' => 0,
                'remark' => '腾讯云存储region'
            ],
            [
                'group_id' => 2,
                'key' => 'oss_accessKeyId',
                'value' => '',
                'name' => '阿里Id',
                'input_type' => 'input',
                'sort' => 0,
                'remark' => '阿里云存储accessKeyId'
            ],
            [
                'group_id' => 2,
                'key' => 'oss_accessKeySecret',
                'value' => '',
                'name' => '阿里Secret',
                'input_type' => 'input',
                'sort' => 0,
                'remark' => '阿里云存储accessKeySecret'
            ],
            [
                'group_id' => 2,
                'key' => 'oss_bucket',
                'value' => '',
                'name' => '阿里bucket',
                'input_type' => 'input',
                'sort' => 0,
                'remark' => '阿里云存储bucket'
            ],
            [
                'group_id' => 2,
                'key' => 'oss_dirname',
                'value' => '',
                'name' => '阿里dirname',
                'input_type' => 'input',
                'sort' => 0,
                'remark' => '阿里云存储dirname'
            ],
            [
                'group_id' => 2,
                'key' => 'oss_domain',
                'value' => '',
                'name' => '阿里domain',
                'input_type' => 'input',
                'sort' => 0,
                'remark' => '阿里云存储domain'
            ],
            [
                'group_id' => 2,
                'key' => 'oss_endpoint',
                'value' => '',
                'name' => '阿里endpoint',
                'input_type' => 'input',
                'sort' => 0,
                'remark' => '阿里云存储endpoint'
            ]
        ];
        $this->table('eb_system_config')->insert($data)->save();
    }

    public function down()
    {
        $this->execute("DELETE FROM eb_system_config where group_id = 2 and `key` = 'local_root' ");
        $this->execute("DELETE FROM eb_system_config where group_id = 2 and `key` = 'local_domain' ");
        $this->execute("DELETE FROM eb_system_config where group_id = 2 and `key` = 'local_uri' ");
        $this->execute("DELETE FROM eb_system_config where group_id = 2 and `key` = 'qiniu_accessKey' ");
        $this->execute("DELETE FROM eb_system_config where group_id = 2 and `key` = 'qiniu_secretKey' ");
        $this->execute("DELETE FROM eb_system_config where group_id = 2 and `key` = 'qiniu_bucket' ");
        $this->execute("DELETE FROM eb_system_config where group_id = 2 and `key` = 'qiniu_dirname' ");
        $this->execute("DELETE FROM eb_system_config where group_id = 2 and `key` = 'qiniu_domain' ");
        $this->execute("DELETE FROM eb_system_config where group_id = 2 and `key` = 'cos_secretId' ");
        $this->execute("DELETE FROM eb_system_config where group_id = 2 and `key` = 'cos_secretKey' ");
        $this->execute("DELETE FROM eb_system_config where group_id = 2 and `key` = 'cos_bucket' ");
        $this->execute("DELETE FROM eb_system_config where group_id = 2 and `key` = 'cos_dirname' ");
        $this->execute("DELETE FROM eb_system_config where group_id = 2 and `key` = 'cos_domain' ");
        $this->execute("DELETE FROM eb_system_config where group_id = 2 and `key` = 'cos_region' ");
        $this->execute("DELETE FROM eb_system_config where group_id = 2 and `key` = 'oss_accessKeyId' ");
        $this->execute("DELETE FROM eb_system_config where group_id = 2 and `key` = 'oss_accessKeySecret' ");
        $this->execute("DELETE FROM eb_system_config where group_id = 2 and `key` = 'oss_bucket' ");
        $this->execute("DELETE FROM eb_system_config where group_id = 2 and `key` = 'oss_dirname' ");
        $this->execute("DELETE FROM eb_system_config where group_id = 2 and `key` = 'oss_domain' ");
        $this->execute("DELETE FROM eb_system_config where group_id = 2 and `key` = 'oss_endpoint' ");
    }
}
