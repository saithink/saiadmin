<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

require_once __DIR__ . '/../support/SaiSchema.php';

/**
 * 初始化 SaiAdmin 基础数据表（sa_system_* / sa_tool_*，共 22 张）
 *
 * 使用 Phinx 可移植建表 API，同一份迁移同时支持 MySQL 与 PostgreSQL：
 * - 索引不指定名称，交由 Phinx 自动命名。PG 的索引名在 schema 内唯一，
 *   而基础表里存在多张表重名的索引（idx_code / idx_create_time 等），写死会冲突
 * - 自增列显式带 'generated' => null：PG 下改用 SERIAL 而不是 GENERATED AS IDENTITY，
 *   这样 think-orm 的 Pgsql 连接器才能靠 nextval( 默认值识别出自增主键；MySQL 忽略该选项
 * - 整型的 limit、signed 只影响 MySQL，PG 适配器会忽略
 * - 表的 engine / row_format 同理，仅 MySQL 生效；字符集与排序规则在 phinx.php 里统一指定
 *
 * 警告：down() 会删除全部基础表及其数据，仅用于开发环境！
 */
final class InitBaseTables extends AbstractMigration
{
    use SaiSchema;

    public function up(): void
    {
        $this->table('sa_system_attachment', $this->tableOptions('附件信息表'))
            ->addColumn('id', $this->pkType(), ['limit' => 11, 'null' => false, 'signed' => false, 'identity' => true, 'generated' => null, 'comment' => '主键'])
            ->addColumn('category_id', 'integer', ['limit' => 11, 'null' => true, 'default' => 0, 'comment' => '文件分类'])
            ->addColumn('storage_mode', 'smallinteger', ['limit' => 6, 'null' => true, 'default' => 1, 'comment' => '存储模式 (1 本地 2 阿里云 3 七牛云 4 腾讯云)'])
            ->addColumn('origin_name', 'string', ['limit' => 255, 'null' => true, 'comment' => '原文件名'])
            ->addColumn('object_name', 'string', ['limit' => 50, 'null' => true, 'comment' => '新文件名'])
            ->addColumn('hash', 'string', ['limit' => 64, 'null' => true, 'comment' => '文件hash'])
            ->addColumn('mime_type', 'string', ['limit' => 255, 'null' => true, 'comment' => '资源类型'])
            ->addColumn('storage_path', 'string', ['limit' => 100, 'null' => true, 'comment' => '存储目录'])
            ->addColumn('suffix', 'string', ['limit' => 10, 'null' => true, 'comment' => '文件后缀'])
            ->addColumn('size_byte', 'biginteger', ['limit' => 20, 'null' => true, 'comment' => '字节数'])
            ->addColumn('size_info', 'string', ['limit' => 50, 'null' => true, 'comment' => '文件大小'])
            ->addColumn('url', 'string', ['limit' => 255, 'null' => true, 'comment' => 'url地址'])
            ->addColumn('remark', 'string', ['limit' => 255, 'null' => true, 'comment' => '备注'])
            ->addColumn('created_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '创建者'])
            ->addColumn('updated_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '更新者'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '修改时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '删除时间'])
            ->addIndex(['hash'])
            ->addIndex(['url'])
            ->addIndex(['create_time'])
            ->addIndex(['category_id'])
            ->create();

        $this->table('sa_system_category', $this->tableOptions('附件分类表'))
            ->addColumn('id', $this->pkType(), ['limit' => 11, 'null' => false, 'identity' => true, 'generated' => null, 'comment' => '分类ID'])
            ->addColumn('parent_id', 'integer', ['limit' => 11, 'null' => false, 'default' => 0, 'comment' => '父id'])
            ->addColumn('level', 'string', ['limit' => 255, 'null' => true, 'comment' => '组集关系'])
            ->addColumn('category_name', 'string', ['limit' => 100, 'null' => false, 'default' => '', 'comment' => '分类名称'])
            ->addColumn('sort', 'integer', ['limit' => 11, 'null' => false, 'default' => 0, 'comment' => '排序'])
            ->addColumn('status', 'tinyinteger', ['limit' => 1, 'null' => true, 'default' => 1, 'comment' => '状态'])
            ->addColumn('remark', 'string', ['limit' => 255, 'null' => true, 'comment' => '备注'])
            ->addColumn('created_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '创建者'])
            ->addColumn('updated_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '更新者'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '修改时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '删除时间'])
            ->addIndex(['parent_id'])
            ->addIndex(['sort'])
            ->create();

        $this->table('sa_system_config', $this->tableOptions('参数配置信息表', ['id', 'key']))
            ->addColumn('id', $this->pkType(), ['limit' => 11, 'null' => false, 'signed' => false, 'identity' => true, 'generated' => null, 'comment' => '编号'])
            ->addColumn('group_id', 'integer', ['limit' => 11, 'null' => true, 'comment' => '组id'])
            ->addColumn('key', 'string', ['limit' => 32, 'null' => false, 'comment' => '配置键名'])
            ->addColumn('value', 'text', ['null' => true, 'comment' => '配置值'])
            ->addColumn('name', 'string', ['limit' => 255, 'null' => true, 'comment' => '配置名称'])
            ->addColumn('input_type', 'string', ['limit' => 32, 'null' => true, 'comment' => '数据输入类型'])
            ->addColumn('config_select_data', 'string', ['limit' => 500, 'null' => true, 'comment' => '配置选项数据'])
            ->addColumn('sort', 'smallinteger', ['limit' => 5, 'null' => true, 'default' => 0, 'signed' => false, 'comment' => '排序'])
            ->addColumn('remark', 'string', ['limit' => 255, 'null' => true, 'comment' => '备注'])
            ->addColumn('created_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '创建人'])
            ->addColumn('updated_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '更新人'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '修改时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '删除时间'])
            ->addIndex(['group_id'])
            ->create();

        $this->table('sa_system_config_group', $this->tableOptions('参数配置分组表'))
            ->addColumn('id', $this->pkType(), ['limit' => 11, 'null' => false, 'signed' => false, 'identity' => true, 'generated' => null, 'comment' => '主键'])
            ->addColumn('name', 'string', ['limit' => 50, 'null' => true, 'comment' => '字典名称'])
            ->addColumn('code', 'string', ['limit' => 100, 'null' => true, 'comment' => '字典标示'])
            ->addColumn('remark', 'string', ['limit' => 255, 'null' => true, 'comment' => '备注'])
            ->addColumn('created_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '创建人'])
            ->addColumn('updated_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '更新人'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '修改时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '删除时间'])
            ->create();

        $this->table('sa_system_dept', $this->tableOptions('部门表'))
            ->addColumn('id', $this->pkType('biginteger'), ['limit' => 20, 'null' => false, 'signed' => false, 'identity' => true, 'generated' => null])
            ->addColumn('parent_id', 'biginteger', ['limit' => 20, 'null' => true, 'default' => 0, 'signed' => false, 'comment' => '父级ID，0为根节点'])
            ->addColumn('name', 'string', ['limit' => 64, 'null' => false, 'comment' => '部门名称'])
            ->addColumn('code', 'string', ['limit' => 64, 'null' => true, 'comment' => '部门编码'])
            ->addColumn('leader_id', 'biginteger', ['limit' => 20, 'null' => true, 'signed' => false, 'comment' => '部门负责人ID'])
            ->addColumn('level', 'string', ['limit' => 255, 'null' => true, 'default' => '', 'comment' => '祖级列表，格式: 0,1,5, (便于查询子孙节点)'])
            ->addColumn('sort', 'integer', ['limit' => 11, 'null' => true, 'default' => 0, 'comment' => '排序，数字越小越靠前'])
            ->addColumn('status', 'tinyinteger', ['limit' => 1, 'null' => true, 'default' => 1, 'comment' => '状态: 1启用, 0禁用'])
            ->addColumn('remark', 'string', ['limit' => 255, 'null' => true, 'comment' => '备注'])
            ->addColumn('created_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '创建者'])
            ->addColumn('updated_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '更新者'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '修改时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '删除时间'])
            ->addIndex(['parent_id'])
            ->addIndex(['level'])
            ->create();

        $this->table('sa_system_dict_data', $this->tableOptions('字典数据表'))
            ->addColumn('id', $this->pkType(), ['limit' => 11, 'null' => false, 'signed' => false, 'identity' => true, 'generated' => null, 'comment' => '主键'])
            ->addColumn('type_id', 'integer', ['limit' => 11, 'null' => true, 'signed' => false, 'comment' => '字典类型ID'])
            ->addColumn('label', 'string', ['limit' => 50, 'null' => true, 'comment' => '字典标签'])
            ->addColumn('value', 'string', ['limit' => 100, 'null' => true, 'comment' => '字典值'])
            ->addColumn('color', 'string', ['limit' => 50, 'null' => true, 'comment' => '字典颜色'])
            ->addColumn('code', 'string', ['limit' => 100, 'null' => true, 'comment' => '字典标示'])
            ->addColumn('sort', 'smallinteger', ['limit' => 5, 'null' => true, 'default' => 0, 'signed' => false, 'comment' => '排序'])
            ->addColumn('status', 'smallinteger', ['limit' => 6, 'null' => true, 'default' => 1, 'comment' => '状态 (1正常 2停用)'])
            ->addColumn('remark', 'string', ['limit' => 255, 'null' => true, 'comment' => '备注'])
            ->addColumn('created_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '创建者'])
            ->addColumn('updated_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '更新者'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '修改时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '删除时间'])
            ->addIndex(['type_id'])
            ->addIndex(['code'])
            ->create();

        $this->table('sa_system_dict_type', $this->tableOptions('字典类型表'))
            ->addColumn('id', $this->pkType(), ['limit' => 11, 'null' => false, 'signed' => false, 'identity' => true, 'generated' => null, 'comment' => '主键'])
            ->addColumn('name', 'string', ['limit' => 50, 'null' => true, 'comment' => '字典名称'])
            ->addColumn('code', 'string', ['limit' => 100, 'null' => true, 'comment' => '字典标示'])
            ->addColumn('status', 'smallinteger', ['limit' => 6, 'null' => true, 'default' => 1, 'comment' => '状态 (1正常 2停用)'])
            ->addColumn('remark', 'string', ['limit' => 255, 'null' => true, 'comment' => '备注'])
            ->addColumn('created_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '创建者'])
            ->addColumn('updated_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '更新者'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '修改时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '删除时间'])
            ->addIndex(['code'])
            ->addIndex(['name'])
            ->create();

        $this->table('sa_system_login_log', $this->tableOptions('登录日志表'))
            ->addColumn('id', $this->pkType(), ['limit' => 11, 'null' => false, 'signed' => false, 'identity' => true, 'generated' => null, 'comment' => '主键'])
            ->addColumn('username', 'string', ['limit' => 20, 'null' => true, 'comment' => '用户名'])
            ->addColumn('ip', 'string', ['limit' => 45, 'null' => true, 'comment' => '登录IP地址'])
            ->addColumn('ip_location', 'string', ['limit' => 255, 'null' => true, 'comment' => 'IP所属地'])
            ->addColumn('os', 'string', ['limit' => 50, 'null' => true, 'comment' => '操作系统'])
            ->addColumn('browser', 'string', ['limit' => 50, 'null' => true, 'comment' => '浏览器'])
            ->addColumn('status', 'smallinteger', ['limit' => 6, 'null' => true, 'default' => 1, 'comment' => '登录状态 (1成功 2失败)'])
            ->addColumn('message', 'string', ['limit' => 50, 'null' => true, 'comment' => '提示消息'])
            ->addColumn('login_time', 'datetime', ['null' => false, 'precision' => 0, 'default' => Literal::from('CURRENT_TIMESTAMP'), 'update' => 'CURRENT_TIMESTAMP', 'comment' => '登录时间'])
            ->addColumn('remark', 'string', ['limit' => 255, 'null' => true, 'comment' => '备注'])
            ->addColumn('created_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '创建者'])
            ->addColumn('updated_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '更新者'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '更新时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '删除时间'])
            ->addIndex(['username'])
            ->addIndex(['create_time'])
            ->addIndex(['login_time'])
            ->create();

        $this->table('sa_system_mail', $this->tableOptions('邮件记录'))
            ->addColumn('id', $this->pkType(), ['limit' => 11, 'null' => false, 'signed' => false, 'identity' => true, 'generated' => null, 'comment' => '编号'])
            ->addColumn('gateway', 'string', ['limit' => 50, 'null' => true, 'comment' => '网关'])
            ->addColumn('from', 'string', ['limit' => 50, 'null' => true, 'comment' => '发送人'])
            ->addColumn('email', 'string', ['limit' => 50, 'null' => true, 'comment' => '接收人'])
            ->addColumn('code', 'string', ['limit' => 20, 'null' => true, 'comment' => '验证码'])
            ->addColumn('content', 'string', ['limit' => 500, 'null' => true, 'comment' => '邮箱内容'])
            ->addColumn('status', 'string', ['limit' => 20, 'null' => true, 'comment' => '发送状态'])
            ->addColumn('response', 'string', ['limit' => 500, 'null' => true, 'comment' => '返回结果'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '修改时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '删除时间'])
            ->addIndex(['create_time'])
            ->create();

        $this->table('sa_system_menu', $this->tableOptions('菜单权限表'))
            ->addColumn('id', $this->pkType('biginteger'), ['limit' => 20, 'null' => false, 'signed' => false, 'identity' => true, 'generated' => null])
            ->addColumn('parent_id', 'biginteger', ['limit' => 20, 'null' => true, 'default' => 0, 'signed' => false, 'comment' => '父级ID'])
            ->addColumn('name', 'string', ['limit' => 64, 'null' => false, 'comment' => '菜单名称'])
            ->addColumn('code', 'string', ['limit' => 64, 'null' => true, 'comment' => '组件名称'])
            ->addColumn('slug', 'string', ['limit' => 100, 'null' => true, 'comment' => '权限标识，如 user:list, user:add'])
            ->addColumn('type', 'tinyinteger', ['limit' => 1, 'null' => false, 'default' => 1, 'comment' => '类型: 1目录, 2菜单, 3按钮/API'])
            ->addColumn('path', 'string', ['limit' => 255, 'null' => true, 'comment' => '路由地址(前端)或API路径(后端)'])
            ->addColumn('component', 'string', ['limit' => 255, 'null' => true, 'comment' => '前端组件路径，如 layout/User'])
            ->addColumn('method', 'string', ['limit' => 10, 'null' => true, 'comment' => '请求方式'])
            ->addColumn('icon', 'string', ['limit' => 64, 'null' => true, 'comment' => '图标'])
            ->addColumn('sort', 'integer', ['limit' => 11, 'null' => true, 'default' => 100, 'comment' => '排序'])
            ->addColumn('link_url', 'string', ['limit' => 255, 'null' => true, 'comment' => '外部链接'])
            ->addColumn('is_iframe', 'tinyinteger', ['limit' => 1, 'null' => true, 'default' => 2, 'comment' => '是否iframe'])
            ->addColumn('is_keep_alive', 'tinyinteger', ['limit' => 1, 'null' => true, 'default' => 2, 'comment' => '是否缓存'])
            ->addColumn('is_hidden', 'tinyinteger', ['limit' => 1, 'null' => true, 'default' => 2, 'comment' => '是否隐藏'])
            ->addColumn('is_fixed_tab', 'tinyinteger', ['limit' => 1, 'null' => true, 'default' => 2, 'comment' => '是否固定标签页'])
            ->addColumn('is_full_page', 'tinyinteger', ['limit' => 1, 'null' => true, 'default' => 2, 'comment' => '是否全屏'])
            ->addColumn('generate_id', 'integer', ['limit' => 11, 'null' => true, 'default' => 0, 'comment' => '生成id'])
            ->addColumn('generate_key', 'string', ['limit' => 255, 'null' => true, 'comment' => '生成key'])
            ->addColumn('status', 'tinyinteger', ['limit' => 1, 'null' => true, 'default' => 1, 'comment' => '状态'])
            ->addColumn('remark', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('created_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '创建者'])
            ->addColumn('updated_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '更新者'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '修改时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '删除时间'])
            ->addIndex(['parent_id'])
            ->addIndex(['slug'])
            ->create();

        $this->table('sa_system_oper_log', $this->tableOptions('操作日志表'))
            ->addColumn('id', $this->pkType('biginteger'), ['limit' => 20, 'null' => false, 'signed' => false, 'identity' => true, 'generated' => null, 'comment' => '主键'])
            ->addColumn('username', 'string', ['limit' => 20, 'null' => true, 'comment' => '用户名'])
            ->addColumn('app', 'string', ['limit' => 50, 'null' => true, 'comment' => '应用名称'])
            ->addColumn('method', 'string', ['limit' => 20, 'null' => true, 'comment' => '请求方式'])
            ->addColumn('router', 'string', ['limit' => 500, 'null' => true, 'comment' => '请求路由'])
            ->addColumn('service_name', 'string', ['limit' => 30, 'null' => true, 'comment' => '业务名称'])
            ->addColumn('ip', 'string', ['limit' => 45, 'null' => true, 'comment' => '请求IP地址'])
            ->addColumn('ip_location', 'string', ['limit' => 255, 'null' => true, 'comment' => 'IP所属地'])
            ->addColumn('request_data', 'text', ['null' => true, 'comment' => '请求数据'])
            ->addColumn('remark', 'string', ['limit' => 255, 'null' => true, 'comment' => '备注'])
            ->addColumn('created_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '创建者'])
            ->addColumn('updated_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '更新者'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '更新时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '删除时间'])
            ->addIndex(['username'])
            ->addIndex(['create_time'])
            ->create();

        $this->table('sa_system_post', $this->tableOptions('岗位信息表'))
            ->addColumn('id', $this->pkType(), ['limit' => 11, 'null' => false, 'signed' => false, 'identity' => true, 'generated' => null, 'comment' => '主键'])
            ->addColumn('name', 'string', ['limit' => 50, 'null' => true, 'comment' => '岗位名称'])
            ->addColumn('code', 'string', ['limit' => 100, 'null' => true, 'comment' => '岗位代码'])
            ->addColumn('sort', 'smallinteger', ['limit' => 5, 'null' => true, 'default' => 0, 'signed' => false, 'comment' => '排序'])
            ->addColumn('status', 'smallinteger', ['limit' => 6, 'null' => true, 'default' => 1, 'comment' => '状态 (1正常 2停用)'])
            ->addColumn('remark', 'string', ['limit' => 255, 'null' => true, 'comment' => '备注'])
            ->addColumn('created_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '创建者'])
            ->addColumn('updated_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '更新者'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '修改时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '删除时间'])
            ->create();

        $this->table('sa_system_role', $this->tableOptions('角色表'))
            ->addColumn('id', $this->pkType('biginteger'), ['limit' => 20, 'null' => false, 'signed' => false, 'identity' => true, 'generated' => null])
            ->addColumn('name', 'string', ['limit' => 64, 'null' => false, 'comment' => '角色名称'])
            ->addColumn('code', 'string', ['limit' => 64, 'null' => false, 'comment' => '角色标识(英文唯一)，如: hr_manager'])
            ->addColumn('level', 'integer', ['limit' => 11, 'null' => true, 'default' => 1, 'comment' => '角色级别(1-100)：用于行政控制，不可操作级别>=自己的角色'])
            ->addColumn('data_scope', 'tinyinteger', ['limit' => 4, 'null' => true, 'default' => 1, 'comment' => '数据范围: 1全部, 2本部门及下属, 3本部门, 4仅本人, 5自定义'])
            ->addColumn('remark', 'string', ['limit' => 255, 'null' => true, 'comment' => '备注'])
            ->addColumn('sort', 'integer', ['limit' => 11, 'null' => true, 'default' => 100])
            ->addColumn('status', 'tinyinteger', ['limit' => 1, 'null' => true, 'default' => 1, 'comment' => '状态: 1启用, 0禁用'])
            ->addColumn('created_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '创建者'])
            ->addColumn('updated_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '更新者'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '修改时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '删除时间'])
            ->addIndex(['code'], ['unique' => true])
            ->create();

        $this->table('sa_system_role_dept', $this->tableOptions('角色-自定义数据权限关联'))
            ->addColumn('id', $this->pkType('biginteger'), ['limit' => 20, 'null' => false, 'signed' => false, 'identity' => true, 'generated' => null])
            ->addColumn('role_id', 'biginteger', ['limit' => 20, 'null' => false, 'signed' => false])
            ->addColumn('dept_id', 'biginteger', ['limit' => 20, 'null' => false, 'signed' => false])
            ->addIndex(['role_id'])
            ->addIndex(['dept_id'])
            ->create();

        $this->table('sa_system_role_menu', $this->tableOptions('角色权限关联'))
            ->addColumn('id', $this->pkType('biginteger'), ['limit' => 20, 'null' => false, 'signed' => false, 'identity' => true, 'generated' => null])
            ->addColumn('role_id', 'biginteger', ['limit' => 20, 'null' => false, 'signed' => false])
            ->addColumn('menu_id', 'biginteger', ['limit' => 20, 'null' => false, 'signed' => false])
            ->addIndex(['menu_id'])
            ->addIndex(['role_id'])
            ->create();

        $this->table('sa_system_user', $this->tableOptions('用户表'))
            ->addColumn('id', $this->pkType(), ['limit' => 11, 'null' => false, 'signed' => false, 'identity' => true, 'generated' => null])
            ->addColumn('username', 'string', ['limit' => 64, 'null' => false, 'comment' => '登录账号'])
            ->addColumn('password', 'string', ['limit' => 255, 'null' => false, 'comment' => '加密密码'])
            ->addColumn('realname', 'string', ['limit' => 64, 'null' => true, 'comment' => '真实姓名'])
            ->addColumn('gender', 'string', ['limit' => 10, 'null' => true, 'comment' => '性别'])
            ->addColumn('avatar', 'string', ['limit' => 255, 'null' => true, 'comment' => '头像'])
            ->addColumn('email', 'string', ['limit' => 128, 'null' => true, 'comment' => '邮箱'])
            ->addColumn('phone', 'string', ['limit' => 20, 'null' => true, 'comment' => '手机号'])
            ->addColumn('signed', 'string', ['limit' => 255, 'null' => true, 'comment' => '个性签名'])
            ->addColumn('dashboard', 'string', ['limit' => 255, 'null' => true, 'default' => 'work', 'comment' => '工作台'])
            ->addColumn('dept_id', 'biginteger', ['limit' => 20, 'null' => true, 'signed' => false, 'comment' => '主归属部门'])
            ->addColumn('is_super', 'tinyinteger', ['limit' => 1, 'null' => true, 'default' => 0, 'comment' => '是否超级管理员: 1是(跳过权限检查), 0否'])
            ->addColumn('status', 'tinyinteger', ['limit' => 1, 'null' => true, 'default' => 1, 'comment' => '状态: 1启用, 0禁用'])
            ->addColumn('remark', 'string', ['limit' => 255, 'null' => true, 'comment' => '备注'])
            ->addColumn('login_time', 'timestamp', ['null' => true, 'precision' => 0, 'comment' => '最后登录时间'])
            ->addColumn('login_ip', 'string', ['limit' => 45, 'null' => true, 'comment' => '最后登录IP'])
            ->addColumn('created_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '创建者'])
            ->addColumn('updated_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '更新者'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '修改时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '删除时间'])
            ->addIndex(['username'], ['unique' => true])
            ->addIndex(['dept_id'])
            ->create();

        $this->table('sa_system_user_post', $this->tableOptions('用户与岗位关联表'))
            ->addColumn('id', $this->pkType('biginteger'), ['limit' => 20, 'null' => false, 'signed' => false, 'identity' => true, 'generated' => null, 'comment' => '主键'])
            ->addColumn('user_id', 'biginteger', ['limit' => 20, 'null' => false, 'signed' => false, 'comment' => '用户主键'])
            ->addColumn('post_id', 'biginteger', ['limit' => 20, 'null' => false, 'signed' => false, 'comment' => '岗位主键'])
            ->addIndex(['user_id'])
            ->addIndex(['post_id'])
            ->create();

        $this->table('sa_system_user_role', $this->tableOptions('用户角色关联'))
            ->addColumn('id', $this->pkType('biginteger'), ['limit' => 20, 'null' => false, 'signed' => false, 'identity' => true, 'generated' => null])
            ->addColumn('user_id', 'biginteger', ['limit' => 20, 'null' => false, 'signed' => false])
            ->addColumn('role_id', 'biginteger', ['limit' => 20, 'null' => false, 'signed' => false])
            ->addIndex(['role_id'])
            ->addIndex(['user_id'])
            ->create();

        $this->table('sa_tool_crontab', $this->tableOptions('定时任务信息表'))
            ->addColumn('id', $this->pkType(), ['limit' => 11, 'null' => false, 'signed' => false, 'identity' => true, 'generated' => null, 'comment' => '主键'])
            ->addColumn('name', 'string', ['limit' => 100, 'null' => true, 'comment' => '任务名称'])
            ->addColumn('type', 'smallinteger', ['limit' => 6, 'null' => true, 'default' => 4, 'comment' => '任务类型'])
            ->addColumn('target', 'string', ['limit' => 500, 'null' => true, 'comment' => '调用任务字符串'])
            ->addColumn('parameter', 'string', ['limit' => 1000, 'null' => true, 'comment' => '调用任务参数'])
            ->addColumn('task_style', 'tinyinteger', ['limit' => 1, 'null' => true, 'comment' => '执行类型'])
            ->addColumn('rule', 'string', ['limit' => 32, 'null' => true, 'comment' => '任务执行表达式'])
            ->addColumn('singleton', 'smallinteger', ['limit' => 6, 'null' => true, 'default' => 1, 'comment' => '是否单次执行 (1 是 2 不是)'])
            ->addColumn('status', 'smallinteger', ['limit' => 6, 'null' => true, 'default' => 1, 'comment' => '状态 (1正常 2停用)'])
            ->addColumn('remark', 'string', ['limit' => 255, 'null' => true, 'comment' => '备注'])
            ->addColumn('created_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '创建者'])
            ->addColumn('updated_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '更新者'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '修改时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '删除时间'])
            ->create();

        $this->table('sa_tool_crontab_log', $this->tableOptions('定时任务执行日志表'))
            ->addColumn('id', $this->pkType(), ['limit' => 11, 'null' => false, 'signed' => false, 'identity' => true, 'generated' => null, 'comment' => '主键'])
            ->addColumn('crontab_id', 'integer', ['limit' => 11, 'null' => true, 'signed' => false, 'comment' => '任务ID'])
            ->addColumn('name', 'string', ['limit' => 255, 'null' => true, 'comment' => '任务名称'])
            ->addColumn('target', 'string', ['limit' => 500, 'null' => true, 'comment' => '任务调用目标字符串'])
            ->addColumn('parameter', 'string', ['limit' => 1000, 'null' => true, 'comment' => '任务调用参数'])
            ->addColumn('exception_info', 'string', ['limit' => 2000, 'null' => true, 'comment' => '异常信息'])
            ->addColumn('status', 'smallinteger', ['limit' => 6, 'null' => true, 'default' => 1, 'comment' => '执行状态 (1成功 2失败)'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '修改时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '删除时间'])
            ->create();

        $this->table('sa_tool_generate_columns', $this->tableOptions('代码生成业务字段表'))
            ->addColumn('id', $this->pkType(), ['limit' => 11, 'null' => false, 'signed' => false, 'identity' => true, 'generated' => null, 'comment' => '主键'])
            ->addColumn('table_id', 'integer', ['limit' => 11, 'null' => true, 'signed' => false, 'comment' => '所属表ID'])
            ->addColumn('column_name', 'string', ['limit' => 200, 'null' => true, 'comment' => '字段名称'])
            ->addColumn('column_comment', 'string', ['limit' => 255, 'null' => true, 'comment' => '字段注释'])
            ->addColumn('column_type', 'string', ['limit' => 50, 'null' => true, 'comment' => '字段类型'])
            ->addColumn('default_value', 'string', ['limit' => 50, 'null' => true, 'comment' => '默认值'])
            ->addColumn('is_pk', 'smallinteger', ['limit' => 6, 'null' => true, 'default' => 1, 'comment' => '1 非主键 2 主键'])
            ->addColumn('is_required', 'smallinteger', ['limit' => 6, 'null' => true, 'default' => 1, 'comment' => '1 非必填 2 必填'])
            ->addColumn('is_insert', 'smallinteger', ['limit' => 6, 'null' => true, 'default' => 1, 'comment' => '1 非插入字段 2 插入字段'])
            ->addColumn('is_edit', 'smallinteger', ['limit' => 6, 'null' => true, 'default' => 1, 'comment' => '1 非编辑字段 2 编辑字段'])
            ->addColumn('is_list', 'smallinteger', ['limit' => 6, 'null' => true, 'default' => 1, 'comment' => '1 非列表显示字段 2 列表显示字段'])
            ->addColumn('is_query', 'smallinteger', ['limit' => 6, 'null' => true, 'default' => 1, 'comment' => '1 非查询字段 2 查询字段'])
            ->addColumn('is_sort', 'smallinteger', ['limit' => 6, 'null' => true, 'default' => 1, 'comment' => '1 非排序 2 排序'])
            ->addColumn('query_type', 'string', ['limit' => 100, 'null' => true, 'default' => 'eq', 'comment' => '查询方式 eq 等于, neq 不等于, gt 大于, lt 小于, like 范围'])
            ->addColumn('view_type', 'string', ['limit' => 100, 'null' => true, 'default' => 'text', 'comment' => '页面控件,text, textarea, password, select, checkbox, radio, date, upload, ma-upload(封装的上传控件)'])
            ->addColumn('dict_type', 'string', ['limit' => 200, 'null' => true, 'comment' => '字典类型'])
            ->addColumn('allow_roles', 'string', ['limit' => 255, 'null' => true, 'comment' => '允许查看该字段的角色'])
            ->addColumn('options', 'string', ['limit' => 1000, 'null' => true, 'comment' => '字段其他设置'])
            ->addColumn('sort', 'tinyinteger', ['limit' => 3, 'null' => true, 'default' => 0, 'signed' => false, 'comment' => '排序'])
            ->addColumn('remark', 'string', ['limit' => 255, 'null' => true, 'comment' => '备注'])
            ->addColumn('created_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '创建者'])
            ->addColumn('updated_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '更新者'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '修改时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '删除时间'])
            ->create();

        $this->table('sa_tool_generate_tables', $this->tableOptions('代码生成业务表'))
            ->addColumn('id', $this->pkType(), ['limit' => 11, 'null' => false, 'signed' => false, 'identity' => true, 'generated' => null, 'comment' => '主键'])
            ->addColumn('table_name', 'string', ['limit' => 200, 'null' => true, 'comment' => '表名称'])
            ->addColumn('table_comment', 'string', ['limit' => 500, 'null' => true, 'comment' => '表注释'])
            ->addColumn('stub', 'string', ['limit' => 50, 'null' => true, 'comment' => 'stub类型'])
            ->addColumn('template', 'string', ['limit' => 50, 'null' => true, 'comment' => '模板名称'])
            ->addColumn('namespace', 'string', ['limit' => 255, 'null' => true, 'comment' => '命名空间'])
            ->addColumn('package_name', 'string', ['limit' => 100, 'null' => true, 'comment' => '控制器包名'])
            ->addColumn('business_name', 'string', ['limit' => 50, 'null' => true, 'comment' => '业务名称'])
            ->addColumn('class_name', 'string', ['limit' => 50, 'null' => true, 'comment' => '类名称'])
            ->addColumn('menu_name', 'string', ['limit' => 100, 'null' => true, 'comment' => '生成菜单名'])
            ->addColumn('belong_menu_id', 'integer', ['limit' => 11, 'null' => true, 'comment' => '所属菜单'])
            ->addColumn('tpl_category', 'string', ['limit' => 100, 'null' => true, 'comment' => '生成类型,single 单表CRUD,tree 树表CRUD,parent_sub父子表CRUD'])
            ->addColumn('generate_type', 'smallinteger', ['limit' => 6, 'null' => true, 'default' => 1, 'comment' => '1 压缩包下载 2 生成到模块'])
            ->addColumn('generate_path', 'string', ['limit' => 100, 'null' => true, 'default' => 'saiadmin-artd', 'comment' => '前端根目录'])
            ->addColumn('generate_model', 'smallinteger', ['limit' => 6, 'null' => true, 'default' => 1, 'comment' => '1 软删除 2 非软删除'])
            ->addColumn('generate_menus', 'string', ['limit' => 255, 'null' => true, 'comment' => '生成菜单列表'])
            ->addColumn('build_menu', 'smallinteger', ['limit' => 6, 'null' => true, 'default' => 1, 'comment' => '是否构建菜单'])
            ->addColumn('component_type', 'smallinteger', ['limit' => 6, 'null' => true, 'default' => 1, 'comment' => '组件显示方式'])
            ->addColumn('options', 'string', ['limit' => 1500, 'null' => true, 'comment' => '其他业务选项'])
            ->addColumn('form_width', 'integer', ['limit' => 11, 'null' => true, 'default' => 800, 'comment' => '表单宽度'])
            ->addColumn('is_full', 'tinyinteger', ['limit' => 1, 'null' => true, 'default' => 1, 'comment' => '是否全屏'])
            ->addColumn('remark', 'string', ['limit' => 255, 'null' => true, 'comment' => '备注'])
            ->addColumn('source', 'string', ['limit' => 255, 'null' => true, 'comment' => '数据源'])
            ->addColumn('created_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '创建者'])
            ->addColumn('updated_by', 'integer', ['limit' => 11, 'null' => true, 'comment' => '更新者'])
            ->addColumn('create_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '创建时间'])
            ->addColumn('update_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '修改时间'])
            ->addColumn('delete_time', 'datetime', ['null' => true, 'precision' => 0, 'comment' => '删除时间'])
            ->create();
    }

    public function down(): void
    {
        $this->dropTables([
            'sa_system_attachment',
            'sa_system_category',
            'sa_system_config',
            'sa_system_config_group',
            'sa_system_dept',
            'sa_system_dict_data',
            'sa_system_dict_type',
            'sa_system_login_log',
            'sa_system_mail',
            'sa_system_menu',
            'sa_system_oper_log',
            'sa_system_post',
            'sa_system_role',
            'sa_system_role_dept',
            'sa_system_role_menu',
            'sa_system_user',
            'sa_system_user_post',
            'sa_system_user_role',
            'sa_tool_crontab',
            'sa_tool_crontab_log',
            'sa_tool_generate_columns',
            'sa_tool_generate_tables',
        ]);
    }
}
