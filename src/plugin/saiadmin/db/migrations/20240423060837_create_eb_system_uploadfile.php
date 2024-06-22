<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateEbSystemUploadfile extends AbstractMigration
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
        $table = $this->table('eb_system_uploadfile', [
            'id' => false,
            'primary_key' => ['id'],
            'comment' => '上传文件信息表'
        ]);
        $table->addColumn('id', 'integer', ['signed' => false, 'identity' => true])
            ->addColumn('storage_mode', 'integer', ['null' => true, 'default' => 1, 'comment' => '存储模式 (1 本地 2 阿里云 3 七牛云 4 腾讯云)'])
            ->addColumn('origin_name', 'string', ['limit' => 255, 'null' => true, 'default' => null, 'comment' => '原文件名'])
            ->addColumn('object_name', 'string', ['limit' => 50, 'null' => true, 'default' => null, 'comment' => '新文件名'])
            ->addColumn('hash', 'string', ['limit' => 64, 'null' => true, 'default' => null, 'comment' => '文件hash'])
            ->addColumn('mime_type', 'string', ['limit' => 255, 'null' => true, 'default' => null, 'comment' => '资源类型'])
            ->addColumn('storage_path', 'string', ['limit' => 100, 'null' => true, 'default' => null, 'comment' => '存储目录'])
            ->addColumn('suffix', 'string', ['limit' => 10, 'null' => true, 'default' => null, 'comment' => '文件后缀'])
            ->addColumn('size_byte', 'biginteger', ['null' => true, 'default' => null, 'comment' => '字节数'])
            ->addColumn('size_info', 'string', ['limit' => 50, 'null' => true, 'default' => null, 'comment' => '文件大小'])
            ->addColumn('url', 'string', ['limit' => 255, 'null' => true, 'default' => null, 'comment' => 'url地址'])
            ->addColumn('remark', 'string', ['limit' => 255, 'null' => true, 'default' => null, 'comment' => '备注'])
            ->addColumn('created_by', 'integer', ['null' => true, 'default' => null, 'comment' => '创建者'])
            ->addColumn('updated_by', 'integer', ['null' => true, 'default' => null, 'comment' => '更新者'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '修改时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'default' => null, 'comment' => '删除时间'])
            ->addIndex(['hash'], ['unique' => true])
            ->addIndex(['storage_path'])
            ->create();
    }

    public function down()
    {
        $this->table('eb_system_uploadfile')->drop()->save();
    }
}
