# 数据库迁移（Phinx）

SaiAdmin 的数据库结构由 [Phinx](https://book.cakephp.org/phinx/3/zh-cn/migrations.html) 管理，**同一份迁移与种子数据同时支持 MySQL 与 PostgreSQL**，用 `.env` 里的 `DB_TYPE`（`mysql` | `pgsql`）切换：

- `migrations/` — 表结构迁移
  - `20260822000000_init_base_tables.php` 初始化 22 张基础表
  - `20260822000001_create_article_tables.php` 创建演示文章模块的 3 张表
  - `20260822000002_create_pgsql_helpers.php` 创建 PostgreSQL 下 think-orm 依赖的辅助函数（MySQL 下为空操作，见下）
- `seeds/` — 初始数据。`PureSeeder` 为纯净基础数据；`DemoSeeder` 额外包含文章模块演示数据
- `data/` — 种子数据的纯 PHP 数组（`pure.php` / `demo.php`），由 Seeder 用预处理语句写入，天然跨库
- `support/` — 迁移与 Seeder 共用的助手（`SaiSchema` 统一建表选项与 `isPgsql()` 判断，`SaiSeed` 负责批量写入与序列/自增值重置）。放在 `migrations/`、`seeds/` 之外，Phinx 不会把它们当作迁移类扫描
- `../../../phinx.php` — 配置文件，位于 server 根目录（`vendor/bin/phinx` 默认从 cwd 找它），`paths` 指向本目录下的 `migrations/` 与 `seeds/`；读取顺序为 `$_ENV` → `getenv()` → 默认值

网页安装向导（`/core/install`）会自动执行 migrate + seed，无需手动操作；向导里可以选择数据库类型。

## 常用命令

```bash
# 推荐方式（Windows/Linux 通用，自动读取 .env）
php webman sai:migrate status                 # 查看迁移状态
php webman sai:migrate                        # 执行待运行的迁移
php webman sai:migrate seed --seed PureSeeder # 执行指定 Seeder
php webman sai:migrate rollback -t 0          # 回退全部迁移（危险！会删表）

# 或直接使用 Phinx CLI（在 server 目录下）
vendor/bin/phinx.bat status -c phinx.php   # Windows CMD
vendor/bin/phinx status -c phinx.php       # Linux / Git Bash
```

## 新增迁移

```bash
vendor/bin/phinx.bat create NewFeatureTables -c phinx.php
# 在生成的文件中编写 change()/up() 后执行 php webman sai:migrate
```

注意：迁移文件名必须是 `版本号_蛇形命名.php`，类名由文件名推导（如 `20260901000000_add_foo.php` → `AddFoo`）。

写迁移时请只用 Phinx 的可移植 API（`addColumn` / `addIndex` / `addForeignKey`），不要写 `$this->execute('原生 MySQL SQL')`，否则 PostgreSQL 下会失败。确实需要方言相关语句时，用 `SaiSchema::isPgsql()` 分支处理。

## PostgreSQL 相关约定

以下几点是保持两种数据库结构一致的关键，新增迁移时请照做：

- **主键**：`tableOptions()` 关掉了 Phinx 的自动 `id` 列，主键列显式声明为 `'identity' => true, 'generated' => null`。`generated => null` 让 PG 生成 `SERIAL`（`nextval(...)` 默认值），think-orm 的 Pgsql 连接器正是靠 `nextval(` 前缀识别自增列的；用 PG 10+ 的 `GENERATED AS IDENTITY` 会导致模型写入时拿不到自增主键。
- **主键类型统一 int8**：主键列的类型一律经 `SaiSchema::pkType()` 取得——PG 下恒为 `biginteger`（即 `bigserial` / `int8`），MySQL 下沿用参数里给的原类型（`pkType()` → `int(11)`，`pkType('biginteger')` → `bigint(20)`）。这样 PG 库里所有表的主键宽度一致，不会出现 int4/int8 混用；MySQL 结构保持不变，存量库不受影响。新增迁移的主键请照此写法。注意外键侧的引用列（`parent_id`、`user_id`、`role_id`、`created_by` 等）仍按迁移里各自声明的宽度，PG 会隐式转换，比较与关联都正常。
- **索引不命名**：PG 的索引名在 schema 内全局唯一，多张表出现同名索引（如 `idx_status`）会冲突，因此迁移里的 `addIndex()` 一律不传 `name`，由两边各自生成默认名。
- **时间列精度**：所有 `datetime` / `timestamp` 列都带 `'precision' => 0`。PG 的 `timestamp` 默认是微秒精度，写入的时间会变成 `2026-08-22 17:01:14.079218`，与 MySQL 的秒级 `datetime` 不一致，前端列表也会直接显示出小数部分。
- **`ON UPDATE CURRENT_TIMESTAMP` 无对应实现**：`sa_system_login_log.login_time` 在 MySQL 下带该属性，PG 没有等价的列属性（需要触发器）。迁移保留了 `'update' => 'CURRENT_TIMESTAMP'`，PostgresAdapter 会忽略它。实际写入由模型显式赋值，两边行为一致，不必补触发器。
- **think-orm 依赖的自定义函数**：`CreatePgsqlHelpers` 会建出 `pgsql_type()`、复合类型 `tablestruct` 和两个 `table_msg()` 重载。think-orm 的 `Pgsql::getFields()` 靠 `table_msg()` 读字段信息，缺了它模型的任何读写都会报错。定义按 PG 12+ 改写（官方 `pgsql.sql` 用的 `pg_attrdef.adsrc` 在 PG 12 已移除，这里改用 `pg_get_expr`）。
- **建库编码**：安装向导执行 `CREATE DATABASE "x" ENCODING 'UTF8'`，模板库不是 UTF8 时退回 `TEMPLATE template0 … LC_COLLATE 'C' LC_CTYPE 'C'`。PG 下 `.env` 里的 `DB_CHARSET` 不起作用，编码在建库时就定了。
- **`DB_SCHEMA`**：默认 `public`。think-orm 的 Pgsql 连接器不支持在 DSN 里指定 schema，改用其他 schema 时需要自行设置连接的 `search_path`。

## 运行期的方言处理

迁移之外，业务代码里也有绕不开数据库方言的地方，约定如下：

- 优先写两种数据库通用的 SQL，不要分支。`SystemLoginLogLogic` 的两个统计图表就是这么处理的：只用 `CAST(x AS DATE)`、`EXTRACT(MONTH FROM x)` 做聚合，日期/月份轴与补 0 都放在 PHP 侧；`SystemRole::scopeAuth` 用 `CONCAT(',', level, ',') LIKE :level` 取代 MySQL 专有的 `FIND_IN_SET`。
- 元数据查询与表维护语句没有通用写法，用 `plugin\saiadmin\utils\DbType`（`get()` / `isPgsql($source)`）判断连接类型后分方言实现。`DatabaseLogic` 里表状态（`show table status` ↔ `pg_class` 等系统表）、字段信息（`SHOW FULL COLUMNS` ↔ `pg_attribute` 等系统表）、优化表（`ANALYZE TABLE` ↔ `ANALYZE`）、清理碎片（`OPTIMIZE TABLE` ↔ `VACUUM FULL`）都是这样分开的。
- **PG 的字段信息要归一成 MySQL 的词汇**：代码生成器与前端模板是按 `varchar` / `int` / `datetime` 这套类型名、以及 `PRI` / `UNI` / `MUL`、`extra = auto_increment` 判断的，所以 `DatabaseLogic::pgsqlColumnList()` 会把 `character varying` → `varchar`、`timestamp without time zone` → `datetime` 等做映射，并剥掉默认值上的 `::类型` 标注。新增依赖字段信息的功能时按这套键名取值即可，不必再判断数据库类型。
- 判断表有没有某个字段用 `Db::getTableFields($table)`（连接器按方言实现），不要写 `SHOW COLUMNS`。
- 代码生成器输出的菜单 SQL 是给人执行的文本，按 `db_type` 分两套模板（见 `utils/code/stub/saiadmin/sql/sql.stub`）：MySQL 用 `SET @id := LAST_INSERT_ID()`，PG 用 `WITH ... RETURNING id` 把父菜单 id 带给按钮菜单。模板变量里 `db_source` 是**连接名**（用于判断模型要不要写 `$connection`），`db_type` 才是驱动类型，别混用。

## 注意事项

- **Seeder 不被跟踪**：`seed:run` 不会记录执行状态，对已有数据的库重复执行会主键冲突。安装向导有防重装保护，请勿手动对已初始化的库执行 seed。
- **rollback 有破坏性**：`InitBaseTables::down()` 会删除全部基础表，仅在开发环境使用。
- **存量旧库接入**：手动导入过 SQL 的库没有 `phinxlog` 表。先运行一次 `php webman sai:migrate status`（会自动创建 phinxlog），再补基线记录即可让后续迁移正常增量执行（导过 demo 数据的库补前两条，纯净库只补第一条；第三条只影响 PostgreSQL，MySQL 库补上也是空操作）：

  ```sql
  INSERT INTO phinxlog (version, migration_name, start_time, end_time, breakpoint)
  VALUES (20260822000000, 'InitBaseTables', NOW(), NOW(), 0),
         (20260822000001, 'CreateArticleTables', NOW(), NOW(), 0),
         (20260822000002, 'CreatePgsqlHelpers', NOW(), NOW(), 0);
  ```

  PostgreSQL 的存量库不要补第三条，让它真正执行一次，否则缺少 `table_msg()` 等函数。
- `plugin/saiadmin/db/*.sql` 仅作为手动建库的参考转储保留（只有 MySQL 版本），安装流程不再读取。
