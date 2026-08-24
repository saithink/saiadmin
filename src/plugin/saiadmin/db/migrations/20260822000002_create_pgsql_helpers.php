<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

require_once __DIR__ . '/../support/SaiSchema.php';

/**
 * 创建 PostgreSQL 下 think-orm 依赖的辅助函数（MySQL 下为空操作）
 *
 * think-orm 的 Pgsql 连接器用 table_msg() 这个自定义函数读取表字段信息
 * （见 vendor/topthink/think-orm/src/db/connector/Pgsql.php::getFields），
 * 缺少它模型的任何写操作都会报错。这里内置 PG 12+ 版本的定义
 * （官方 pgsql.sql 用的 pg_attrdef.adsrc 在 PG 12 已被移除，改用 pg_get_expr）。
 */
final class CreatePgsqlHelpers extends AbstractMigration
{
    use SaiSchema;

    public function up(): void
    {
        if (!$this->isPgsql()) {
            return;
        }

        $this->execute(<<<'SQL'
CREATE OR REPLACE FUNCTION pgsql_type(a_type varchar) RETURNS varchar AS
$BODY$
DECLARE
    v_type varchar;
BEGIN
    IF a_type = 'int8' THEN
        v_type := 'bigint';
    ELSIF a_type = 'int4' THEN
        v_type := 'integer';
    ELSIF a_type = 'int2' THEN
        v_type := 'smallint';
    ELSIF a_type = 'bpchar' THEN
        v_type := 'char';
    ELSE
        v_type := a_type;
    END IF;
    RETURN v_type;
END;
$BODY$
LANGUAGE PLPGSQL;
SQL);

        // 复合类型没有 CREATE OR REPLACE，重复执行时跳过
        $this->execute(<<<'SQL'
DO $$
BEGIN
    IF NOT EXISTS (
        SELECT 1 FROM pg_type t
        JOIN pg_namespace n ON n.oid = t.typnamespace
        WHERE t.typname = 'tablestruct' AND n.nspname = current_schema()
    ) THEN
        CREATE TYPE tablestruct AS (
            fields_key_name varchar(100),
            fields_name varchar(200),
            fields_type varchar(20),
            fields_length bigint,
            fields_not_null varchar(10),
            fields_default varchar(500),
            fields_comment varchar(1000)
        );
    END IF;
END $$;
SQL);

        $this->execute(<<<'SQL'
CREATE OR REPLACE FUNCTION table_msg(a_schema_name varchar, a_table_name varchar) RETURNS SETOF tablestruct AS
$body$
DECLARE
    v_ret tablestruct;
    v_oid oid;
    v_sql varchar;
    v_rec RECORD;
    v_key varchar;
BEGIN
    SELECT pg_class.oid INTO v_oid
    FROM pg_class
    INNER JOIN pg_namespace ON (pg_class.relnamespace = pg_namespace.oid AND lower(pg_namespace.nspname) = a_schema_name)
    WHERE pg_class.relname = a_table_name;
    IF NOT FOUND THEN
        RETURN;
    END IF;

    v_sql = '
    SELECT
        pg_attribute.attname AS fields_name,
        pg_attribute.attnum AS fields_index,
        pgsql_type(pg_type.typname::varchar) AS fields_type,
        pg_attribute.atttypmod - 4 AS fields_length,
        CASE WHEN pg_attribute.attnotnull THEN ''not null'' ELSE '''' END AS fields_not_null,
        pg_get_expr(pg_attrdef.adbin, pg_attrdef.adrelid) AS fields_default,
        pg_description.description AS fields_comment
    FROM pg_attribute
    INNER JOIN pg_class ON pg_attribute.attrelid = pg_class.oid
    INNER JOIN pg_type ON pg_attribute.atttypid = pg_type.oid
    LEFT OUTER JOIN pg_attrdef ON pg_attrdef.adrelid = pg_class.oid AND pg_attrdef.adnum = pg_attribute.attnum
    LEFT OUTER JOIN pg_description ON pg_description.objoid = pg_class.oid AND pg_description.objsubid = pg_attribute.attnum
    WHERE pg_attribute.attnum > 0
      AND attisdropped <> ''t''
      AND pg_class.oid = ' || v_oid || '
    ORDER BY pg_attribute.attnum';

    FOR v_rec IN EXECUTE v_sql LOOP
        v_ret.fields_name = v_rec.fields_name;
        v_ret.fields_type = v_rec.fields_type;
        IF v_rec.fields_length > 0 THEN
            v_ret.fields_length := v_rec.fields_length;
        ELSE
            v_ret.fields_length := NULL;
        END IF;
        v_ret.fields_not_null = v_rec.fields_not_null;
        v_ret.fields_default = v_rec.fields_default;
        v_ret.fields_comment = v_rec.fields_comment;
        SELECT constraint_name INTO v_key FROM information_schema.key_column_usage
        WHERE table_schema = a_schema_name AND table_name = a_table_name AND column_name = v_rec.fields_name;
        IF FOUND THEN
            v_ret.fields_key_name = v_key;
        ELSE
            v_ret.fields_key_name = '';
        END IF;
        RETURN NEXT v_ret;
    END LOOP;
    RETURN;
END;
$body$
LANGUAGE 'plpgsql' VOLATILE CALLED ON NULL INPUT SECURITY INVOKER;
SQL);

        $this->execute(<<<'SQL'
CREATE OR REPLACE FUNCTION table_msg(a_table_name varchar) RETURNS SETOF tablestruct AS
$body$
DECLARE
    v_ret tablestruct;
BEGIN
    FOR v_ret IN SELECT * FROM table_msg(current_schema()::varchar, a_table_name) LOOP
        RETURN NEXT v_ret;
    END LOOP;
    RETURN;
END;
$body$
LANGUAGE 'plpgsql' VOLATILE CALLED ON NULL INPUT SECURITY INVOKER;
SQL);
    }

    public function down(): void
    {
        if (!$this->isPgsql()) {
            return;
        }

        $this->execute('DROP FUNCTION IF EXISTS table_msg(varchar)');
        $this->execute('DROP FUNCTION IF EXISTS table_msg(varchar, varchar)');
        $this->execute('DROP TYPE IF EXISTS tablestruct');
        $this->execute('DROP FUNCTION IF EXISTS pgsql_type(varchar)');
    }
}
