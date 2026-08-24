<?php
declare(strict_types=1);

/**
 * 迁移公共助手：统一建表选项，屏蔽 MySQL / PostgreSQL 的差异。
 *
 * 由迁移文件 require_once 引入（Phinx 只扫描 migrations 目录，不会把这里当作迁移类）。
 */
trait SaiSchema
{
    /**
     * 当前连接是否 PostgreSQL
     */
    protected function isPgsql(): bool
    {
        return $this->getAdapter()->getAdapterType() === 'pgsql';
    }

    /**
     * 主键列类型
     *
     * PostgreSQL 下所有表的主键统一放大为 int8（bigserial），避免各表宽度不一；
     * MySQL 保持迁移里原本声明的类型不变（int(11) / bigint(20)），以免影响存量库。
     *
     * @param string $mysqlType MySQL 下使用的 Phinx 类型，默认 integer
     */
    protected function pkType(string $mysqlType = 'integer'): string
    {
        return $this->isPgsql() ? 'biginteger' : $mysqlType;
    }

    /**
     * 通用建表选项
     *
     * - id => false + primary_key：主键由迁移显式声明（identity 列），不让 Phinx 自动追加 id
     * - engine / row_format：MySQL 专有选项，PostgresAdapter 会直接忽略
     * - comment：MySQL 写进 DDL，PG 通过 COMMENT ON TABLE 落库
     * - 字符集与排序规则在 phinx.php 的环境配置里统一指定（DB_COLLATION），PG 下无意义
     *
     * @param string $comment 表注释
     * @param array $primaryKey 主键列，默认单列 id
     */
    protected function tableOptions(string $comment, array $primaryKey = ['id']): array
    {
        return [
            'id' => false,
            'primary_key' => $primaryKey,
            'comment' => $comment,
            'engine' => 'InnoDB',
            'row_format' => 'Dynamic',
        ];
    }

    /**
     * 按建表的相反顺序删表
     *
     * @param array $tables 表名列表（建表顺序）
     */
    protected function dropTables(array $tables): void
    {
        foreach (array_reverse($tables) as $table) {
            if ($this->hasTable($table)) {
                $this->table($table)->drop()->save();
            }
        }
    }
}
