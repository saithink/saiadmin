<?php
declare(strict_types=1);

/**
 * Seeder 公共助手：从同级 data 目录下的数据文件写入初始数据。
 *
 * 数据以 PHP 数组形式保存，由预处理语句绑定，不存在 SQL 引号/转义的方言差异，
 * MySQL 与 PostgreSQL 共用同一份数据。
 *
 * 由 seeder 文件 require_once 引入（Phinx 会扫描 seeds 目录，助手因此放在 support 下）。
 */
trait SaiSeed
{
    /**
     * 单次 bulk insert 的行数上限，避免占位符过多超出驱动限制
     */
    protected int $seedChunkSize = 100;

    /**
     * 写入数据文件
     *
     * @param string $file 数据文件路径，返回 ['表名' => [['列名' => 值, ...], ...]]
     */
    protected function seedFromFile(string $file): void
    {
        if (!is_file($file)) {
            throw new RuntimeException("初始数据文件不存在: $file");
        }

        /** @var array<string, array<int, array<string, mixed>>> $data */
        $data = require $file;

        foreach ($data as $table => $rows) {
            if ($rows === []) {
                continue;
            }
            foreach (array_chunk($rows, $this->seedChunkSize) as $chunk) {
                $this->table($table)->insert($chunk)->saveData();
            }
        }

        $this->syncSequences();
    }

    /**
     * PostgreSQL 下修正自增序列
     *
     * 数据里带了显式主键，PG 的 serial 序列不会因此推进，若不修正，安装后第一次新增
     * 记录就会主键冲突。MySQL 的 AUTO_INCREMENT 会自动跟随，无需处理。
     */
    protected function syncSequences(): void
    {
        if ($this->getAdapter()->getAdapterType() !== 'pgsql') {
            return;
        }

        $this->execute(<<<'SQL'
DO $$
DECLARE
    r record;
    m bigint;
BEGIN
    FOR r IN
        SELECT quote_ident(n.nspname) || '.' || quote_ident(c.relname) AS tbl,
               a.attname AS col,
               pg_get_serial_sequence(quote_ident(n.nspname) || '.' || quote_ident(c.relname), a.attname) AS seq
        FROM pg_class c
        JOIN pg_namespace n ON n.oid = c.relnamespace
        JOIN pg_attribute a ON a.attrelid = c.oid AND a.attnum > 0 AND NOT a.attisdropped
        WHERE n.nspname = current_schema()
          AND c.relkind = 'r'
          AND pg_get_serial_sequence(quote_ident(n.nspname) || '.' || quote_ident(c.relname), a.attname) IS NOT NULL
    LOOP
        EXECUTE format('SELECT COALESCE(MAX(%I), 0) FROM %s', r.col, r.tbl) INTO m;
        PERFORM setval(r.seq, m + 1, false);
    END LOOP;
END $$;
SQL);
    }
}
