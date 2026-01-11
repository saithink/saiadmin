SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for sa_system_menu
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_menu`;
CREATE TABLE `sa_system_menu`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '父级ID',
  `name` varchar(64) NOT NULL COMMENT '菜单名称',
  `code` varchar(64) NULL DEFAULT NULL COMMENT '组件名称',
  `slug` varchar(100) NULL DEFAULT NULL COMMENT '权限标识，如 user:list, user:add',
  `type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '类型: 1目录, 2菜单, 3按钮/API',
  `path` varchar(255) NULL DEFAULT NULL COMMENT '路由地址(前端)或API路径(后端)',
  `component` varchar(255) NULL DEFAULT NULL COMMENT '前端组件路径，如 layout/User',
  `method` varchar(10) NULL DEFAULT NULL COMMENT '请求方式',
  `icon` varchar(64) NULL DEFAULT NULL COMMENT '图标',
  `sort` int(11) NULL DEFAULT 100 COMMENT '排序',
  `link_url` varchar(255) NULL DEFAULT NULL COMMENT '外部链接',
  `is_iframe` tinyint(1) NULL DEFAULT 2 COMMENT '是否iframe',
  `is_keep_alive` tinyint(1) NULL DEFAULT 2 COMMENT '是否缓存',
  `is_hidden` tinyint(1) NULL DEFAULT 2 COMMENT '是否隐藏',
  `is_fixed_tab` tinyint(1) NULL DEFAULT 2 COMMENT '是否固定标签页',
  `is_full_page` tinyint(1) NULL DEFAULT 2 COMMENT '是否全屏',
  `generate_id` int(11) DEFAULT 0 COMMENT '生成id',
  `generate_key` varchar(255) DEFAULT NULL COMMENT '生成key',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `remark` varchar(255) NULL DEFAULT NULL,
  `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  INDEX `idx_parent_id`(`parent_id`),
  INDEX `idx_slug`(`slug`)
) ENGINE = InnoDB AUTO_INCREMENT = 1000 COMMENT = '菜单权限表';

-- ----------------------------
-- Records of sa_system_menu
-- ----------------------------
INSERT INTO `sa_system_menu` VALUES (1, 0, '仪表盘', 'Dashboard', NULL, 1, '/dashboard', NULL, NULL, 'ri:pie-chart-line', 100, NULL, 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (2, 1, '工作台', 'Console', NULL, 2, 'console', '/dashboard/console', NULL, 'ri:home-smile-2-line', 100, NULL, 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (3, 0, '系统管理', 'System', NULL, 1, '/system', NULL, NULL, 'ri:user-3-line', 100, NULL, 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (4, 3, '用户管理', 'User', NULL, 2, 'user', '/system/user', NULL, 'ri:user-line', 100, NULL, 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (5, 3, '部门管理', 'Dept', NULL, 2, 'dept', '/system/dept', NULL, 'ri:node-tree', 100, NULL, 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (6, 3, '角色管理', 'Role', NULL, 2, 'role', '/system/role', NULL, 'ri:admin-line', 100, NULL, 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (7, 3, '岗位管理', 'Post', '', 2, 'post', '/system/post', NULL, 'ri:signpost-line', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (8, 3, '菜单管理', 'Menu', NULL, 2, 'menu', '/system/menu', NULL, 'ri:menu-line', 100, NULL, 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (10, 0, '运维管理', 'Safeguard', NULL, 1, '/safeguard', '', NULL, 'ri:shield-check-line', 100, NULL, 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (11, 10, '缓存管理', 'Cache', '', 2, 'cache', '/safeguard/cache', NULL, 'ri:keyboard-box-line', 80, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (12, 10, '数据字典', 'Dict', NULL, 2, 'dict', '/safeguard/dict', NULL, 'ri:database-2-line', 100, NULL, 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (13, 10, '附件管理', 'Attachment', '', 2, 'attachment', '/safeguard/attachment', NULL, 'ri:file-cloud-line', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (14, 10, '数据表维护', 'Database', '', 2, 'database', '/safeguard/database', NULL, 'ri:database-line', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (15, 10, '登录日志', 'LoginLog', '', 2, 'login-log', '/safeguard/login-log', NULL, 'ri:login-circle-line', 50, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (16, 10, '操作日志', 'OperLog', '', 2, 'oper-log', '/safeguard/oper-log', NULL, 'ri:shield-keyhole-line', 50, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (17, 10, '邮件日志', 'EmailLog', '', 2, 'email-log', '/safeguard/email-log', NULL, 'ri:mail-line', 50, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (18, 3, '系统设置', 'Config', NULL, 2, 'config', '/system/config', NULL, 'ri:settings-4-line', 100, NULL, 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (19, 0, '官方文档', 'Document', '', 4, '', '', NULL, 'ri:file-copy-2-fill', 90, 'https://saithink.top', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (20, 4, '数据列表', '', 'core:user:index', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (21, 1, '个人中心', 'UserCenter', '', 2, 'user-center', '/dashboard/user-center/index', NULL, 'ri:user-2-line', 100, '', 2, 2, 1, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (22, 4, '添加', '', 'core:user:save', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (23, 4, '修改', '', 'core:user:update', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (24, 4, '读取', '', 'core:user:read', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (25, 4, '删除', '', 'core:user:destroy', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (26, 4, '重置密码', '', 'core:user:password', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (27, 4, '清理缓存', '', 'core:user:cache', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (28, 4, '设置工作台', '', 'core:user:home', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (29, 5, '数据列表', '', 'core:dept:index', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (30, 5, '添加', '', 'core:dept:save', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (31, 5, '修改', '', 'core:dept:update', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (32, 5, '读取', '', 'core:dept:read', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (33, 5, '删除', '', 'core:dept:destroy', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (34, 6, '添加', '', 'core:role:save', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (35, 6, '数据列表', '', 'core:role:index', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (36, 6, '修改', '', 'core:role:update', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (37, 6, '读取', '', 'core:role:read', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (38, 6, '删除', '', 'core:role:destroy', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (39, 6, '菜单权限', '', 'core:role:menu', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (41, 7, '数据列表', '', 'core:post:index', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (42, 7, '添加', '', 'core:post:save', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (43, 7, '修改', '', 'core:post:update', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (44, 7, '读取', '', 'core:post:read', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (45, 7, '删除', '', 'core:post:destroy', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (46, 7, '导入', '', 'core:post:import', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (47, 7, '导出', '', 'core:post:export', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (48, 8, '数据列表', '', 'core:menu:index', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (49, 8, '读取', '', 'core:menu:read', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (50, 8, '添加', '', 'core:menu:save', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (51, 8, '修改', '', 'core:menu:update', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (52, 8, '删除', '', 'core:menu:destroy', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (53, 18, '数据列表', '', 'core:config:index', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (54, 18, '管理', '', 'core:config:edit', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (55, 18, '修改', '', 'core:config:update', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (56, 12, '数据列表', '', 'core:dict:index', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (57, 12, '管理', '', 'core:dict:edit', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (58, 13, '数据列表', '', 'core:attachment:index', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (59, 13, '管理', '', 'core:attachment:edit', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (60, 14, '数据表列表', '', 'core:database:index', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (61, 14, '数据表维护', '', 'core:database:edit', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (62, 14, '回收站数据', '', 'core:recycle:index', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (63, 14, '回收站管理', '', 'core:recycle:edit', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (64, 15, '数据列表', '', 'core:logs:login', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (65, 15, '删除', '', 'core:logs:deleteLogin', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (66, 16, '数据列表', '', 'core:logs:Oper', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (67, 16, '删除', '', 'core:logs:deleteOper', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (68, 17, '数据列表', '', 'core:email:index', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (69, 17, '删除', '', 'core:email:destroy', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (70, 10, '服务监控', 'Server', '', 2, 'server', '/safeguard/server', NULL, 'ri:server-line', 90, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (71, 70, '数据列表', '', 'core:server:monitor', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (72, 11, '数据列表', '', 'core:server:cache', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (73, 11, '缓存清理', '', 'core:server:clear', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (74, 2, '登录数据统计', '', 'core:console:list', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (75, 0, '附加权限', 'Permission', '', 1, 'permission', '', NULL, 'ri:apps-2-ai-line', 100, '', 2, 2, 1, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (76, 75, '上传图片', '', 'core:system:uploadImage', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (77, 75, '上传文件', '', 'core:system:uploadFile', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (78, 75, '附件列表', '', 'core:system:resource', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (79, 75, '用户列表', '', 'core:system:user', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (80, 0, '工具', 'Tool', '', 1, '/tool', '', NULL, 'ri:tools-line', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (81, 80, '代码生成', 'Code', '', 2, 'code', '/tool/code', NULL, 'ri:code-s-slash-line', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (82, 80, '定时任务', 'Crontab', '', 2, 'crontab', '/tool/crontab', NULL, 'ri:time-line', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (83, 82, '数据列表', '', 'tool:crontab:index', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (84, 82, '管理', '', 'tool:crontab:edit', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (85, 82, '运行任务', '', 'tool:crontab:run', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (86, 81, '数据列表', '', 'tool:code:index', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);
INSERT INTO `sa_system_menu` VALUES (87, 81, '管理', '', 'tool:code:edit', 3, '', '', NULL, '', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL);

-- ----------------------------
-- Table structure for sa_system_category
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_category`;
CREATE TABLE `sa_system_category`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `parent_id` int(11) NOT NULL DEFAULT 0 COMMENT '父id',
  `level` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '组集关系',
  `category_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  `sort` int(11) NOT NULL DEFAULT 0 COMMENT '排序',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `pid`(`parent_id`) USING BTREE,
  INDEX `sort`(`sort`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '附件分类表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sa_system_category
-- ----------------------------
INSERT INTO `sa_system_category` VALUES (1, 0, '0,', '全部分类', 100, 1, NULL, 1, 1, '2025-11-02 16:33:20', '2025-11-02 16:33:20', NULL);
INSERT INTO `sa_system_category` VALUES (2, 1, '0,1,', '图片分类', 100, 1, NULL, 1, 1, '2025-11-02 16:33:31', '2025-11-02 16:33:31', NULL);
INSERT INTO `sa_system_category` VALUES (3, 1, '0,1,', '文件分类', 100, 1, NULL, 1, 1, '2025-11-02 16:33:47', '2025-12-21 21:31:45', NULL);
INSERT INTO `sa_system_category` VALUES (4, 1, '0,1,', '系统图片', 100, 1, NULL, 1, 1, '2025-11-02 16:33:59', '2025-11-02 16:33:59', NULL);
INSERT INTO `sa_system_category` VALUES (5, 1, '0,1,', '其他分类', 100, 1, NULL, 1, 1, '2025-11-02 16:34:10', '2025-11-02 16:34:10', NULL);

-- ----------------------------
-- Table structure for sa_system_attachment
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_attachment`;
CREATE TABLE `sa_system_attachment`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `category_id` int(11) NULL DEFAULT 0 COMMENT '文件分类',
  `storage_mode` smallint(6) NULL DEFAULT 1 COMMENT '存储模式 (1 本地 2 阿里云 3 七牛云 4 腾讯云)',
  `origin_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '原文件名',
  `object_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '新文件名',
  `hash` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '文件hash',
  `mime_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '资源类型',
  `storage_path` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '存储目录',
  `suffix` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '文件后缀',
  `size_byte` bigint(20) NULL DEFAULT NULL COMMENT '字节数',
  `size_info` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '文件大小',
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'url地址',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `hash`(`hash`) USING BTREE,
  INDEX `idx_url`(`url`) USING BTREE,
  INDEX `idx_create_time`(`create_time`) USING BTREE,
  INDEX `idx_category_id`(`category_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '附件信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sa_system_config_group
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_config_group`;
CREATE TABLE `sa_system_config_group`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '字典名称',
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '字典标示',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `created_by` int(11) NULL DEFAULT NULL COMMENT '创建人',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新人',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '参数配置分组表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sa_system_config_group
-- ----------------------------
INSERT INTO `sa_system_config_group` VALUES (1, '站点配置', 'site_config', '', 1, 2, '2021-11-23 10:49:29', '2025-12-31 16:46:24', NULL);
INSERT INTO `sa_system_config_group` VALUES (2, '上传配置', 'upload_config', NULL, 1, 1, '2021-11-23 10:49:29', '2021-11-23 10:49:29', NULL);
INSERT INTO `sa_system_config_group` VALUES (3, '邮件服务', 'email_config', NULL, 1, 1, '2021-11-23 10:49:29', '2025-04-17 17:10:04', NULL);

-- ----------------------------
-- Table structure for sa_system_config
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_config`;
CREATE TABLE `sa_system_config`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `group_id` int(11) NULL DEFAULT NULL COMMENT '组id',
  `key` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '配置键名',
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '配置值',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '配置名称',
  `input_type` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '数据输入类型',
  `config_select_data` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '配置选项数据',
  `sort` smallint(5) UNSIGNED NULL DEFAULT 0 COMMENT '排序',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `created_by` int(11) NULL DEFAULT NULL COMMENT '创建人',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新人',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`, `key`) USING BTREE,
  INDEX `group_id`(`group_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 302 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '参数配置信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sa_system_config
-- ----------------------------
INSERT INTO `sa_system_config` VALUES (1, 1, 'site_copyright', 'Copyright © 2024 saithink', '版权信息', 'textarea', NULL, 96, '', NULL, 2, NULL, '2025-12-31 16:46:26', NULL);
INSERT INTO `sa_system_config` VALUES (2, 1, 'site_desc', '基于vue3 + webman 的极速开发框架', '网站描述', 'textarea', NULL, 97, NULL, NULL, 2, NULL, '2025-12-31 16:46:26', NULL);
INSERT INTO `sa_system_config` VALUES (3, 1, 'site_keywords', '后台管理系统', '网站关键字', 'input', NULL, 98, NULL, NULL, 2, NULL, '2025-12-31 16:46:26', NULL);
INSERT INTO `sa_system_config` VALUES (4, 1, 'site_name', 'SaiAdmin', '网站名称', 'input', NULL, 99, NULL, NULL, 2, NULL, '2025-12-31 16:46:26', NULL);
INSERT INTO `sa_system_config` VALUES (5, 1, 'site_record_number', '9527', '网站备案号', 'input', NULL, 95, NULL, NULL, 2, NULL, '2025-12-31 16:46:26', NULL);
INSERT INTO `sa_system_config` VALUES (6, 2, 'upload_allow_file', 'txt,doc,docx,xls,xlsx,ppt,pptx,rar,zip,7z,gz,pdf,wps,md,jpg,png,jpeg,mp4,pem,crt', '文件类型', 'input', NULL, 0, NULL, NULL, 1, NULL, '2026-01-07 00:32:06', NULL);
INSERT INTO `sa_system_config` VALUES (7, 2, 'upload_allow_image', 'jpg,jpeg,png,gif,svg,bmp', '图片类型', 'input', NULL, 0, NULL, NULL, 1, NULL, '2026-01-07 00:32:06', NULL);
INSERT INTO `sa_system_config` VALUES (8, 2, 'upload_mode', '1', '上传模式', 'select', '[{\"label\":\"本地上传\",\"value\":\"1\"},{\"label\":\"阿里云OSS\",\"value\":\"2\"},{\"label\":\"七牛云\",\"value\":\"3\"},{\"label\":\"腾讯云COS\",\"value\":\"4\"},{\"label\":\"亚马逊S3\",\"value\":\"5\"}]', 99, NULL, NULL, 1, NULL, '2026-01-07 00:32:06', NULL);
INSERT INTO `sa_system_config` VALUES (10, 2, 'upload_size', '52428800', '上传大小', 'input', NULL, 88, '单位Byte,1MB=1024*1024Byte', NULL, 1, NULL, '2026-01-07 00:32:06', NULL);
INSERT INTO `sa_system_config` VALUES (11, 2, 'local_root', 'public/storage/', '本地存储路径', 'input', NULL, 0, '本地存储文件路径', NULL, 1, NULL, '2026-01-07 00:32:06', NULL);
INSERT INTO `sa_system_config` VALUES (12, 2, 'local_domain', 'http://127.0.0.1:8888', '本地存储域名', 'input', NULL, 0, 'http://127.0.0.1:8787', NULL, 1, NULL, '2026-01-07 00:32:06', NULL);
INSERT INTO `sa_system_config` VALUES (13, 2, 'local_uri', '/storage/', '本地访问路径', 'input', NULL, 0, '访问是通过domain + uri', NULL, 1, NULL, '2026-01-07 00:32:06', NULL);
INSERT INTO `sa_system_config` VALUES (14, 2, 'qiniu_accessKey', '', '七牛key', 'input', NULL, 0, '七牛云存储secretId', NULL, 1, NULL, '2026-01-07 00:32:06', NULL);
INSERT INTO `sa_system_config` VALUES (15, 2, 'qiniu_secretKey', '', '七牛secret', 'input', NULL, 0, '七牛云存储secretKey', NULL, 1, NULL, '2026-01-07 00:32:06', NULL);
INSERT INTO `sa_system_config` VALUES (16, 2, 'qiniu_bucket', '', '七牛bucket', 'input', NULL, 0, '七牛云存储bucket', NULL, 1, NULL, '2026-01-07 00:32:06', NULL);
INSERT INTO `sa_system_config` VALUES (17, 2, 'qiniu_dirname', '', '七牛dirname', 'input', NULL, 0, '七牛云存储dirname', NULL, 1, NULL, '2026-01-07 00:32:06', NULL);
INSERT INTO `sa_system_config` VALUES (18, 2, 'qiniu_domain', '', '七牛domain', 'input', NULL, 0, '七牛云存储domain', NULL, 1, NULL, '2026-01-07 00:32:06', NULL);
INSERT INTO `sa_system_config` VALUES (19, 2, 'cos_secretId', '', '腾讯Id', 'input', NULL, 0, '腾讯云存储secretId', NULL, 1, NULL, '2026-01-07 00:32:06', NULL);
INSERT INTO `sa_system_config` VALUES (20, 2, 'cos_secretKey', '', '腾讯key', 'input', NULL, 0, '腾讯云secretKey', NULL, 1, NULL, '2026-01-07 00:32:06', NULL);
INSERT INTO `sa_system_config` VALUES (21, 2, 'cos_bucket', '', '腾讯bucket', 'input', NULL, 0, '腾讯云存储bucket', NULL, 1, NULL, '2026-01-07 00:32:06', NULL);
INSERT INTO `sa_system_config` VALUES (22, 2, 'cos_dirname', '', '腾讯dirname', 'input', NULL, 0, '腾讯云存储dirname', NULL, 1, NULL, '2026-01-07 00:32:06', NULL);
INSERT INTO `sa_system_config` VALUES (23, 2, 'cos_domain', '', '腾讯domain', 'input', NULL, 0, '腾讯云存储domain', NULL, 1, NULL, '2026-01-07 00:32:06', NULL);
INSERT INTO `sa_system_config` VALUES (24, 2, 'cos_region', '', '腾讯region', 'input', NULL, 0, '腾讯云存储region', NULL, 1, NULL, '2026-01-07 00:32:06', NULL);
INSERT INTO `sa_system_config` VALUES (25, 2, 'oss_accessKeyId', '', '阿里Id', 'input', NULL, 0, '阿里云存储accessKeyId', NULL, 1, NULL, '2026-01-07 00:32:06', NULL);
INSERT INTO `sa_system_config` VALUES (26, 2, 'oss_accessKeySecret', '', '阿里Secret', 'input', NULL, 0, '阿里云存储accessKeySecret', NULL, 1, NULL, '2026-01-07 00:32:06', NULL);
INSERT INTO `sa_system_config` VALUES (27, 2, 'oss_bucket', '', '阿里bucket', 'input', NULL, 0, '阿里云存储bucket', NULL, 1, NULL, '2026-01-07 00:32:06', NULL);
INSERT INTO `sa_system_config` VALUES (28, 2, 'oss_dirname', '', '阿里dirname', 'input', NULL, 0, '阿里云存储dirname', NULL, 1, NULL, '2026-01-07 00:32:06', NULL);
INSERT INTO `sa_system_config` VALUES (29, 2, 'oss_domain', '', '阿里domain', 'input', NULL, 0, '阿里云存储domain', NULL, 1, NULL, '2026-01-07 00:32:06', NULL);
INSERT INTO `sa_system_config` VALUES (30, 2, 'oss_endpoint', '', '阿里endpoint', 'input', NULL, 0, '阿里云存储endpoint', NULL, 1, NULL, '2026-01-07 00:32:06', NULL);
INSERT INTO `sa_system_config` VALUES (31, 3, 'Host', 'smtp.qq.com', 'SMTP服务器', 'input', '', 100, '', NULL, 2, NULL, '2025-12-31 16:41:04', NULL);
INSERT INTO `sa_system_config` VALUES (32, 3, 'Port', '465', 'SMTP端口', 'input', '', 100, '', NULL, 2, NULL, '2025-12-31 16:41:04', NULL);
INSERT INTO `sa_system_config` VALUES (33, 3, 'Username', '1430792918@qq.com', 'SMTP用户名', 'input', '', 100, '', NULL, 2, NULL, '2025-12-31 16:41:04', NULL);
INSERT INTO `sa_system_config` VALUES (34, 3, 'Password', 'fjrmooxjfuqaifja', 'SMTP密码', 'input', '', 100, '', NULL, 2, NULL, '2025-12-31 16:41:04', NULL);
INSERT INTO `sa_system_config` VALUES (35, 3, 'SMTPSecure', 'ssl', 'SMTP验证方式', 'radio', '[\r\n    {\"label\":\"ssl\",\"value\":\"ssl\"},\r\n    {\"label\":\"tsl\",\"value\":\"tsl\"}\r\n]', 100, '', NULL, 2, NULL, '2025-12-31 16:41:04', NULL);
INSERT INTO `sa_system_config` VALUES (36, 3, 'From', 'saisaas@qq.com', '默认发件人', 'input', '', 100, '默认发件的邮箱地址', NULL, 2, NULL, '2025-12-31 16:41:04', NULL);
INSERT INTO `sa_system_config` VALUES (37, 3, 'FromName', '账户注册', '默认发件名称', 'input', '', 100, '', NULL, 2, NULL, '2025-12-31 16:41:04', NULL);
INSERT INTO `sa_system_config` VALUES (38, 3, 'CharSet', 'UTF-8', '编码', 'input', '', 100, '', NULL, 2, NULL, '2025-12-31 16:41:04', NULL);
INSERT INTO `sa_system_config` VALUES (39, 3, 'SMTPDebug', '0', '调试模式', 'radio', '[\r\n    {\"label\":\"关闭\",\"value\":\"0\"},\r\n    {\"label\":\"client\",\"value\":\"1\"},\r\n    {\"label\":\"server\",\"value\":\"2\"}\r\n]', 100, '', NULL, 2, NULL, '2025-12-31 16:41:04', NULL);
INSERT INTO `sa_system_config` VALUES (40, 2, 's3_key', '', 'key', 'input', '', 0, '', NULL, 1, NULL, '2026-01-07 00:32:06', NULL);
INSERT INTO `sa_system_config` VALUES (41, 2, 's3_secret', '', 'secret', 'input', '', 0, '', NULL, 1, NULL, '2026-01-07 00:32:06', NULL);
INSERT INTO `sa_system_config` VALUES (42, 2, 's3_bucket', '', 'bucket', 'input', '', 0, '', NULL, 1, NULL, '2026-01-07 00:32:06', NULL);
INSERT INTO `sa_system_config` VALUES (43, 2, 's3_dirname', '', 'dirname', 'input', '', 0, '', NULL, 1, NULL, '2026-01-07 00:32:06', NULL);
INSERT INTO `sa_system_config` VALUES (44, 2, 's3_domain', '', 'domain', 'input', '', 0, '', NULL, 1, NULL, '2026-01-07 00:32:06', NULL);
INSERT INTO `sa_system_config` VALUES (45, 2, 's3_region', '', 'region', 'input', '', 0, '', NULL, 1, NULL, '2026-01-07 00:32:06', NULL);
INSERT INTO `sa_system_config` VALUES (46, 2, 's3_version', '', 'version', 'input', '', 0, '', NULL, 1, NULL, '2026-01-07 00:32:06', NULL);
INSERT INTO `sa_system_config` VALUES (47, 2, 's3_use_path_style_endpoint', '', 'path_style_endpoint', 'input', '', 0, '', NULL, 1, NULL, '2026-01-07 00:32:06', NULL);
INSERT INTO `sa_system_config` VALUES (48, 2, 's3_endpoint', '', 'endpoint', 'input', '', 0, '', NULL, 1, NULL, '2026-01-07 00:32:06', NULL);
INSERT INTO `sa_system_config` VALUES (49, 2, 's3_acl', '', 'acl', 'input', '', 0, '', NULL, 1, NULL, '2026-01-07 00:32:06', NULL);

-- ----------------------------
-- Table structure for sa_system_dict_type
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_dict_type`;
CREATE TABLE `sa_system_dict_type`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '字典名称',
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '字典标示',
  `status` smallint(6) NULL DEFAULT 1 COMMENT '状态 (1正常 2停用)',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_code`(`code`) USING BTREE,
  INDEX `idx_name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '字典类型表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sa_system_dict_type
-- ----------------------------
INSERT INTO `sa_system_dict_type` VALUES (2, '存储模式', 'upload_mode', 1, '上传文件存储模式', 1, 2, '2021-06-27 13:33:29', '2025-12-31 16:48:27', NULL);
INSERT INTO `sa_system_dict_type` VALUES (3, '数据状态', 'data_status', 1, '通用数据状态', 1, 1, '2021-06-27 13:33:29', '2025-03-29 20:39:25', NULL);
INSERT INTO `sa_system_dict_type` VALUES (4, '后台首页', 'dashboard', 1, NULL, 1, 1, '2021-06-27 13:33:29', '2023-11-16 11:28:17', NULL);
INSERT INTO `sa_system_dict_type` VALUES (5, '性别', 'gender', 1, '', 1, 1, '2021-06-27 13:33:29', '2025-04-04 23:05:52', NULL);
INSERT INTO `sa_system_dict_type` VALUES (12, '附件类型', 'attachment_type', 1, NULL, 1, 1, '2021-06-27 13:33:29', '2022-03-17 14:49:23', NULL);
INSERT INTO `sa_system_dict_type` VALUES (13, '菜单类型', 'menu_type', 1, '', 1, 1, '2024-07-31 10:33:37', '2024-07-31 10:33:37', NULL);
INSERT INTO `sa_system_dict_type` VALUES (14, '是否', 'yes_or_no', 1, '', 1, 1, '2024-07-31 10:35:07', '2024-07-31 10:35:07', NULL);
INSERT INTO `sa_system_dict_type` VALUES (20, '定时任务类型', 'crontab_task_type', 1, '', 1, 1, '2025-12-28 22:58:30', '2025-12-28 22:58:30', NULL);

-- ----------------------------
-- Table structure for sa_system_dict_data
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_dict_data`;
CREATE TABLE `sa_system_dict_data`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `type_id` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '字典类型ID',
  `label` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '字典标签',
  `value` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '字典值',
  `color` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '字典颜色',
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '字典标示',
  `sort` smallint(5) UNSIGNED NULL DEFAULT 0 COMMENT '排序',
  `status` smallint(6) NULL DEFAULT 1 COMMENT '状态 (1正常 2停用)',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE,
  INDEX `idx_code`(`code`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 50 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '字典数据表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sa_system_dict_data
-- ----------------------------
INSERT INTO `sa_system_dict_data` VALUES (2, 2, '本地存储', '1', '#5d87ff', 'upload_mode', 99, 1, '', 1, 2, '2021-06-27 13:33:43', '2025-12-31 16:48:27', NULL);
INSERT INTO `sa_system_dict_data` VALUES (3, 2, '阿里云OSS', '2', '#f9901f', 'upload_mode', 98, 1, '', 1, 2, '2021-06-27 13:33:55', '2025-12-31 16:48:27', NULL);
INSERT INTO `sa_system_dict_data` VALUES (4, 2, '七牛云', '3', '#00ced1', 'upload_mode', 97, 1, '', 1, 2, '2021-06-27 13:34:07', '2025-12-31 16:48:27', NULL);
INSERT INTO `sa_system_dict_data` VALUES (5, 2, '腾讯云COS', '4', '#1d84ff', 'upload_mode', 96, 1, '', 1, 2, '2021-06-27 13:34:19', '2025-12-31 16:48:27', NULL);
INSERT INTO `sa_system_dict_data` VALUES (6, 2, '亚马逊S3', '5', '#ff80c8', 'upload_mode', 95, 1, '', 1, 2, '2021-06-27 13:34:19', '2025-12-31 16:48:27', NULL);
INSERT INTO `sa_system_dict_data` VALUES (7, 3, '正常', '1', '#13deb9', 'data_status', 0, 1, '1为正常', 1, 1, '2021-06-27 13:36:51', '2025-12-19 15:09:00', NULL);
INSERT INTO `sa_system_dict_data` VALUES (8, 3, '停用', '2', '#ff4d4f', 'data_status', 0, 1, '2为停用', 1, 1, '2021-06-27 13:37:10', '2025-12-19 15:09:05', NULL);
INSERT INTO `sa_system_dict_data` VALUES (9, 4, '统计页面', 'statistics', '#00ced1', 'dashboard', 100, 1, '管理员用', 1, 1, '2021-08-09 12:53:53', '2025-12-19 15:16:15', NULL);
INSERT INTO `sa_system_dict_data` VALUES (10, 4, '工作台', 'work', '#ff8c00', 'dashboard', 50, 1, '员工使用', 1, 1, '2021-08-09 12:54:18', '2025-12-19 15:16:27', NULL);
INSERT INTO `sa_system_dict_data` VALUES (11, 5, '男', '1', '#5d87ff', 'gender', 0, 1, '', 1, 1, '2021-08-09 12:55:00', '2025-12-19 15:28:22', NULL);
INSERT INTO `sa_system_dict_data` VALUES (12, 5, '女', '2', '#ff4500', 'gender', 0, 1, '', 1, 1, '2021-08-09 12:55:08', '2025-12-19 15:28:28', NULL);
INSERT INTO `sa_system_dict_data` VALUES (13, 5, '未知', '3', '#b48df3', 'gender', 0, 1, '', 1, 1, '2021-08-09 12:55:16', '2025-12-19 15:29:06', NULL);
INSERT INTO `sa_system_dict_data` VALUES (16, 12, '图片', 'image', '#60c041', 'attachment_type', 10, 1, '', 1, 1, '2022-03-17 14:49:59', '2025-12-19 15:35:32', NULL);
INSERT INTO `sa_system_dict_data` VALUES (17, 12, '文档', 'text', '#1d84ff', 'attachment_type', 9, 1, '', 1, 1, '2022-03-17 14:50:20', '2025-12-19 15:35:40', NULL);
INSERT INTO `sa_system_dict_data` VALUES (18, 12, '音频', 'audio', '#00ced1', 'attachment_type', 8, 1, '', 1, 1, '2022-03-17 14:50:37', '2025-12-19 15:35:45', NULL);
INSERT INTO `sa_system_dict_data` VALUES (19, 12, '视频', 'video', '#ff4500', 'attachment_type', 7, 1, '', 1, 1, '2022-03-17 14:50:45', '2025-12-19 15:35:50', NULL);
INSERT INTO `sa_system_dict_data` VALUES (20, 12, '应用程序', 'application', '#ff8c00', 'attachment_type', 6, 1, '', 1, 1, '2022-03-17 14:50:52', '2025-12-19 15:35:55', NULL);
INSERT INTO `sa_system_dict_data` VALUES (21, 13, '目录', '1', '#909399', 'menu_type', 100, 1, '', 1, 1, '2024-07-31 10:34:12', '2025-12-19 15:34:00', NULL);
INSERT INTO `sa_system_dict_data` VALUES (22, 13, '菜单', '2', '#1e90ff', 'menu_type', 100, 1, '', 1, 1, '2024-07-31 10:34:20', '2025-12-19 15:34:44', NULL);
INSERT INTO `sa_system_dict_data` VALUES (23, 13, '按钮', '3', '#ff4500', 'menu_type', 100, 1, '', 1, 1, '2024-07-31 10:34:27', '2025-12-19 15:34:54', NULL);
INSERT INTO `sa_system_dict_data` VALUES (24, 13, '外链', '4', '#00ced1', 'menu_type', 100, 1, '', 1, 1, '2024-07-31 10:34:51', '2025-12-19 15:34:32', NULL);
INSERT INTO `sa_system_dict_data` VALUES (25, 14, '是', '1', '#60c041', 'yes_or_no', 100, 1, '', 1, 1, '2024-07-31 10:35:17', '2025-12-19 15:30:03', NULL);
INSERT INTO `sa_system_dict_data` VALUES (26, 14, '否', '2', '#ff4500', 'yes_or_no', 100, 1, '', 1, 1, '2024-07-31 10:35:22', '2025-12-19 15:30:08', NULL);
INSERT INTO `sa_system_dict_data` VALUES (47, 20, 'URL任务GET', '1', '#5d87ff', 'crontab_task_type', 100, 1, '', 1, 1, '2025-12-28 22:58:44', '2025-12-28 22:58:44', NULL);
INSERT INTO `sa_system_dict_data` VALUES (48, 20, 'URL任务POST', '2', '#00ced1', 'crontab_task_type', 100, 1, '', 1, 1, '2025-12-28 22:58:51', '2025-12-29 09:46:01', NULL);
INSERT INTO `sa_system_dict_data` VALUES (49, 20, '类任务', '3', '#ff8c00', 'crontab_task_type', 100, 1, '', 1, 1, '2025-12-28 22:58:58', '2025-12-29 09:46:06', NULL);

-- ----------------------------
-- Table structure for sa_system_login_log
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_login_log`;
CREATE TABLE `sa_system_login_log`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '用户名',
  `ip` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '登录IP地址',
  `ip_location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'IP所属地',
  `os` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '操作系统',
  `browser` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '浏览器',
  `status` smallint(6) NULL DEFAULT 1 COMMENT '登录状态 (1成功 2失败)',
  `message` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '提示消息',
  `login_time` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '登录时间',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '更新时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `username`(`username`) USING BTREE,
  INDEX `idx_create_time`(`create_time`) USING BTREE,
  INDEX `idx_login_time`(`login_time`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '登录日志表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sa_system_oper_log
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_oper_log`;
CREATE TABLE `sa_system_oper_log`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '用户名',
  `app` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '应用名称',
  `method` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '请求方式',
  `router` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '请求路由',
  `service_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '业务名称',
  `ip` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '请求IP地址',
  `ip_location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'IP所属地',
  `request_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '请求数据',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '更新时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `username`(`username`) USING BTREE,
  INDEX `idx_create_time`(`create_time`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '操作日志表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sa_system_mail
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_mail`;
CREATE TABLE `sa_system_mail`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `gateway` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '网关',
  `from` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '发送人',
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '接收人',
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '验证码',
  `content` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '邮箱内容',
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '发送状态',
  `response` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '返回结果',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_create_time`(`create_time`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '邮件记录' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sa_system_dept
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_dept`;
CREATE TABLE `sa_system_dept`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '父级ID，0为根节点',
  `name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '部门名称',
  `code` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '部门编码',
  `leader_id` bigint(20) UNSIGNED NULL DEFAULT NULL COMMENT '部门负责人ID',
  `level` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '祖级列表，格式: 0,1,5, (便于查询子孙节点)',
  `sort` int(11) NULL DEFAULT 0 COMMENT '排序，数字越小越靠前',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态: 1启用, 0禁用',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_parent_id`(`parent_id`) USING BTREE,
  INDEX `idx_path`(`level`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1114 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '部门表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sa_system_dept
-- ----------------------------
INSERT INTO `sa_system_dept` VALUES (1, 0, '腾讯集团', 'GROUP', 1, '0,', 100, 1, NULL, 1, 1, '2025-12-01 00:00:00', '2025-12-01 00:00:00', NULL);
INSERT INTO `sa_system_dept` VALUES (2, 1, '总办', 'GMO', 1, '0,1,', 100, 1, NULL, 1, 1, '2025-12-01 00:00:00', '2025-12-01 00:00:00', NULL);
INSERT INTO `sa_system_dept` VALUES (10, 1, '微信事业群', 'WXG', 3, '0,1,', 200, 1, '', 1, 1, '2025-12-01 00:00:00', '2025-12-08 16:11:33', NULL);
INSERT INTO `sa_system_dept` VALUES (11, 1, '互动娱乐事业群', 'IEG', 4, '0,1,', 300, 1, NULL, 1, 1, '2025-12-01 00:00:00', '2025-12-01 00:00:00', NULL);
INSERT INTO `sa_system_dept` VALUES (12, 1, '云与智慧产业事业群', 'CSIG', 5, '0,1,', 400, 1, NULL, 1, 1, '2025-12-01 00:00:00', '2025-12-01 00:00:00', NULL);
INSERT INTO `sa_system_dept` VALUES (101, 10, '微信基础产品部', 'WX_BASE', NULL, '0,1,10,', 100, 1, NULL, 1, 1, '2025-12-01 00:00:00', '2025-12-01 00:00:00', NULL);
INSERT INTO `sa_system_dept` VALUES (102, 10, '微信支付线', 'WX_PAY', NULL, '0,1,10,', 200, 1, NULL, 1, 1, '2025-12-01 00:00:00', '2025-12-01 00:00:00', NULL);
INSERT INTO `sa_system_dept` VALUES (111, 11, '天美工作室群', 'TIMI', NULL, '0,1,11,', 100, 1, NULL, 1, 1, '2025-12-01 00:00:00', '2025-12-01 00:00:00', NULL);
INSERT INTO `sa_system_dept` VALUES (112, 11, '光子工作室群', 'LIGHT', NULL, '0,1,11,', 200, 1, NULL, 1, 1, '2025-12-01 00:00:00', '2025-12-01 00:00:00', NULL);
INSERT INTO `sa_system_dept` VALUES (121, 12, '腾讯云事业部', 'CLOUD', NULL, '0,1,12,', 100, 1, '', 1, 1, '2025-12-01 00:00:00', '2025-12-08 16:09:25', NULL);
INSERT INTO `sa_system_dept` VALUES (1111, 111, '王者荣耀项目组', 'HOK', NULL, '0,1,11,111,', 100, 1, NULL, 1, 1, '2025-12-01 00:00:00', '2025-12-01 00:00:00', NULL);
INSERT INTO `sa_system_dept` VALUES (1112, 111, 'QQ飞车项目组', 'QQ_SPEED', NULL, '0,1,11,111,', 200, 1, NULL, 1, 1, '2025-12-01 00:00:00', '2025-12-01 00:00:00', NULL);

-- ----------------------------
-- Table structure for sa_system_role
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_role`;
CREATE TABLE `sa_system_role`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '角色名称',
  `code` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '角色标识(英文唯一)，如: hr_manager',
  `level` int(11) NULL DEFAULT 1 COMMENT '角色级别(1-100)：用于行政控制，不可操作级别>=自己的角色',
  `data_scope` tinyint(4) NULL DEFAULT 1 COMMENT '数据范围: 1全部, 2本部门及下属, 3本部门, 4仅本人, 5自定义',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `sort` int(11) NULL DEFAULT 100,
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态: 1启用, 0禁用',
  `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uk_slug`(`code`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '角色表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sa_system_role
-- ----------------------------
INSERT INTO `sa_system_role` VALUES (1, '超级管理员', 'super_admin', 100, 1, '系统维护者，拥有所有权限', 100, 1, 1, 1, '2025-12-01 00:00:00', '2025-12-13 10:31:30', NULL);
INSERT INTO `sa_system_role` VALUES (2, '集团总裁', 'ceo', 90, 1, '查看全集团数据', 100, 1, 1, 1, '2025-12-01 00:00:00', '2026-01-07 15:45:26', NULL);
INSERT INTO `sa_system_role` VALUES (3, 'BG总裁', 'bg_president', 80, 2, '', 100, 1, 1, 1, '2025-12-01 00:00:00', '2025-12-01 00:00:00', NULL);
INSERT INTO `sa_system_role` VALUES (4, '部门总经理', 'gm', 60, 2, '', 100, 1, 1, 1, '2025-12-01 00:00:00', '2025-12-13 10:29:48', NULL);
INSERT INTO `sa_system_role` VALUES (5, '组长', 'team_leader', 30, 3, '', 100, 1, 1, 1, '2025-12-01 00:00:00', '2025-12-01 00:00:00', NULL);
INSERT INTO `sa_system_role` VALUES (6, '普通员工', 'staff', 10, 4, '', 100, 1, 1, 1, '2025-12-01 00:00:00', '2025-12-01 00:00:00', NULL);

-- ----------------------------
-- Table structure for sa_system_post
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_post`;
CREATE TABLE `sa_system_post`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '岗位名称',
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '岗位代码',
  `sort` smallint(5) UNSIGNED NULL DEFAULT 0 COMMENT '排序',
  `status` smallint(6) NULL DEFAULT 1 COMMENT '状态 (1正常 2停用)',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 87 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '岗位信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sa_system_post
-- ----------------------------
INSERT INTO `sa_system_post` VALUES (1, '司机岗', 'driver', 100, 1, '', 1, 1, '2025-04-27 23:34:06', '2025-12-10 15:14:07', NULL);
INSERT INTO `sa_system_post` VALUES (2, '保安岗', 'security', 100, 1, '', 1, 1, '2025-04-27 23:34:06', '2025-12-10 15:14:04', NULL);

-- ----------------------------
-- Table structure for sa_system_role_dept
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_role_dept`;
CREATE TABLE `sa_system_role_dept`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `dept_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_role_id`(`role_id`) USING BTREE,
  INDEX `idx_dept_id`(`dept_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '角色-自定义数据权限关联' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sa_system_role_menu
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_role_menu`;
CREATE TABLE `sa_system_role_menu`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_menu_id`(`menu_id`) USING BTREE,
  INDEX `idx_role_id`(`role_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '角色权限关联' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sa_system_user_post
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_user_post`;
CREATE TABLE `sa_system_user_post`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT '用户主键',
  `post_id` bigint(20) UNSIGNED NOT NULL COMMENT '岗位主键',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_user_id`(`user_id`) USING BTREE,
  INDEX `idx_post_id`(`post_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户与岗位关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sa_system_user_role
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_user_role`;
CREATE TABLE `sa_system_user_role`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_role_id`(`role_id`) USING BTREE,
  INDEX `idx_user_id`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 55 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户角色关联' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sa_system_user_role
-- ----------------------------
INSERT INTO `sa_system_user_role` VALUES (1, 1, 1);

-- ----------------------------
-- Table structure for sa_system_user
-- ----------------------------
DROP TABLE IF EXISTS `sa_system_user`;
CREATE TABLE `sa_system_user`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '登录账号',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '加密密码',
  `realname` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '真实姓名',
  `gender` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '性别',
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '头像',
  `email` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '邮箱',
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '手机号',
  `signed` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '个性签名',
  `dashboard` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'work' COMMENT '工作台',
  `dept_id` bigint(20) UNSIGNED NULL DEFAULT NULL COMMENT '主归属部门',
  `is_super` tinyint(1) NULL DEFAULT 0 COMMENT '是否超级管理员: 1是(跳过权限检查), 0否',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态: 1启用, 0禁用',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `login_time` timestamp(0) NULL DEFAULT NULL COMMENT '最后登录时间',
  `login_ip` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '最后登录IP',
  `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uk_username`(`username`) USING BTREE,
  INDEX `idx_dept_id`(`dept_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 110 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sa_system_user
-- ----------------------------
INSERT INTO `sa_system_user` VALUES (1, 'admin', '$2y$10$wnixh48uDnaW/6D9EygDd.OHJK0vQY/4nHaTjMKBCVDBP2NiTatqS', '祭道之上', '2', 'http://127.0.0.1:8888/storage/20251223/7ece61225ffe6cc374a58add56f0e8e80b03fa09.jpg', 'saiadmin@admin.com', '15888888888', 'SaiAdmin是兼具设计美学与高效开发的后台系统!', 'statistics', 1, 1, 1, NULL, '2026-01-08 22:54:08', '127.0.0.1', 1, 1, '2025-12-01 00:00:00', '2026-01-08 22:54:08', NULL);
INSERT INTO `sa_system_user` VALUES (2, 'martin', '$2y$10$J3EkwRH8rNkveaanx1.j.ebRiBpnnVUGWa.i2MS3aNpb9ydAOolmm', '刘炽平', '2', 'http://127.0.0.1:8888/storage/20251223/7971881d7e10a122e0f51ea188571dbe29d82229.jpg', 'martin@163.com', '15888888888', NULL, 'work', 1, 0, 1, '', '2026-01-07 17:30:47', '127.0.0.1', 1, 1, '2025-12-01 00:00:00', '2026-01-07 17:30:48', NULL);
INSERT INTO `sa_system_user` VALUES (3, 'allen', '$2y$10$H8d7riOjOiwPSopguEQ1fuKZz.fA0A54OvuzTqgJlbG1N3uOxEwM.', '张小龙', '', 'https://image.saithink.top/saiadmin/avatar.jpg', '', '15888888888', NULL, 'work', 10, 0, 1, '', NULL, NULL, 1, 2, '2025-12-01 00:00:00', '2025-12-31 15:59:56', NULL);
INSERT INTO `sa_system_user` VALUES (4, 'mark', '$2y$10$sY/4StKVV.N/8Ock8J8kdeIOK4jS4tAUoYjkzvB8Tzy0fLh.wA2KS', '任宇昕', NULL, 'https://image.saithink.top/saiadmin/avatar.jpg', NULL, '15888888888', NULL, 'work', 11, 0, 1, NULL, '2026-01-07 14:51:55', '127.0.0.1', 1, 4, '2025-12-01 00:00:00', '2026-01-07 14:51:55', NULL);
INSERT INTO `sa_system_user` VALUES (5, 'dowson', '$2y$10$sY/4StKVV.N/8Ock8J8kdeIOK4jS4tAUoYjkzvB8Tzy0fLh.wA2KS', '汤道生', NULL, 'https://image.saithink.top/saiadmin/avatar.jpg', NULL, '15888888888', NULL, 'work', 12, 0, 1, NULL, NULL, NULL, 1, 1, '2025-12-01 00:00:00', '2025-12-01 00:00:00', NULL);
INSERT INTO `sa_system_user` VALUES (10, 'timi_boss', '$2y$10$sY/4StKVV.N/8Ock8J8kdeIOK4jS4tAUoYjkzvB8Tzy0fLh.wA2KS', '姚晓光', NULL, 'https://image.saithink.top/saiadmin/avatar.jpg', '', '15888888888', NULL, 'work', 111, 0, 1, '', NULL, NULL, 1, 4, '2025-12-01 00:00:00', '2025-12-20 20:52:53', NULL);
INSERT INTO `sa_system_user` VALUES (100, 'dev_wang', '$2y$10$sY/4StKVV.N/8Ock8J8kdeIOK4jS4tAUoYjkzvB8Tzy0fLh.wA2KS', '王程序员', NULL, 'https://image.saithink.top/saiadmin/avatar.jpg', NULL, '15888888888', NULL, 'work', 1111, 0, 1, NULL, NULL, NULL, 1, 1, '2025-12-01 00:00:00', '2025-12-01 00:00:00', NULL);
INSERT INTO `sa_system_user` VALUES (101, 'dev_li', '$2y$10$sY/4StKVV.N/8Ock8J8kdeIOK4jS4tAUoYjkzvB8Tzy0fLh.wA2KS', '李策划', NULL, 'https://image.saithink.top/saiadmin/avatar.jpg', NULL, '15888888888', NULL, 'work', 1111, 0, 1, NULL, NULL, NULL, 1, 1, '2025-12-01 00:00:00', '2025-12-01 00:00:00', NULL);

-- ----------------------------
-- Table structure for sa_tool_crontab
-- ----------------------------
DROP TABLE IF EXISTS `sa_tool_crontab`;
CREATE TABLE `sa_tool_crontab`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '任务名称',
  `type` smallint(6) NULL DEFAULT 4 COMMENT '任务类型',
  `target` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '调用任务字符串',
  `parameter` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '调用任务参数',
  `task_style` tinyint(1) NULL DEFAULT NULL COMMENT '执行类型',
  `rule` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '任务执行表达式',
  `singleton` smallint(6) NULL DEFAULT 1 COMMENT '是否单次执行 (1 是 2 不是)',
  `status` smallint(6) NULL DEFAULT 1 COMMENT '状态 (1正常 2停用)',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '定时任务信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sa_tool_crontab
-- ----------------------------
INSERT INTO `sa_tool_crontab` VALUES (1, '访问官网', 1, 'https://saithink.top', '', 1, '0 0 8 * * *', 2, 1, '', 1, 2, '2024-01-20 14:21:11', '2026-01-07 15:49:55', NULL);
INSERT INTO `sa_tool_crontab` VALUES (2, '登录gitee', 2, 'https://gitee.com/check_user_login', '{\"user_login\": \"saiadmin\"}', 1, '0 0 10 * * *', 2, 1, '', 1, 1, '2024-01-20 14:31:51', '2025-12-31 15:04:45', NULL);
INSERT INTO `sa_tool_crontab` VALUES (3, '定时执行任务', 3, '\\plugin\\saiadmin\\process\\Test', '{\"type\":\"1\"}', 5, '*/10 * * * * *', 2, 1, '', 1, 1, '2024-01-20 14:38:03', '2025-08-05 22:07:05', NULL);

-- ----------------------------
-- Table structure for sa_tool_crontab_log
-- ----------------------------
DROP TABLE IF EXISTS `sa_tool_crontab_log`;
CREATE TABLE `sa_tool_crontab_log`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `crontab_id` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '任务ID',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '任务名称',
  `target` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '任务调用目标字符串',
  `parameter` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '任务调用参数',
  `exception_info` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '异常信息',
  `status` smallint(6) NULL DEFAULT 1 COMMENT '执行状态 (1成功 2失败)',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '定时任务执行日志表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sa_tool_generate_columns
-- ----------------------------
DROP TABLE IF EXISTS `sa_tool_generate_columns`;
CREATE TABLE `sa_tool_generate_columns`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `table_id` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '所属表ID',
  `column_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '字段名称',
  `column_comment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '字段注释',
  `column_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '字段类型',
  `default_value` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '默认值',
  `is_pk` smallint(6) NULL DEFAULT 1 COMMENT '1 非主键 2 主键',
  `is_required` smallint(6) NULL DEFAULT 1 COMMENT '1 非必填 2 必填',
  `is_insert` smallint(6) NULL DEFAULT 1 COMMENT '1 非插入字段 2 插入字段',
  `is_edit` smallint(6) NULL DEFAULT 1 COMMENT '1 非编辑字段 2 编辑字段',
  `is_list` smallint(6) NULL DEFAULT 1 COMMENT '1 非列表显示字段 2 列表显示字段',
  `is_query` smallint(6) NULL DEFAULT 1 COMMENT '1 非查询字段 2 查询字段',
  `is_sort` smallint(6) NULL DEFAULT 1 COMMENT '1 非排序 2 排序',
  `query_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'eq' COMMENT '查询方式 eq 等于, neq 不等于, gt 大于, lt 小于, like 范围',
  `view_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'text' COMMENT '页面控件,text, textarea, password, select, checkbox, radio, date, upload, ma-upload(封装的上传控件)',
  `dict_type` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '字典类型',
  `allow_roles` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '允许查看该字段的角色',
  `options` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '字段其他设置',
  `sort` tinyint(3) UNSIGNED NULL DEFAULT 0 COMMENT '排序',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '代码生成业务字段表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sa_tool_generate_columns
-- ----------------------------

-- ----------------------------
-- Table structure for sa_tool_generate_tables
-- ----------------------------
DROP TABLE IF EXISTS `sa_tool_generate_tables`;
CREATE TABLE `sa_tool_generate_tables`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `table_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '表名称',
  `table_comment` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '表注释',
  `stub` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'stub类型',
  `template` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '模板名称',
  `namespace` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '命名空间',
  `package_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '控制器包名',
  `business_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '业务名称',
  `class_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '类名称',
  `menu_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '生成菜单名',
  `belong_menu_id` int(11) NULL DEFAULT NULL COMMENT '所属菜单',
  `tpl_category` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '生成类型,single 单表CRUD,tree 树表CRUD,parent_sub父子表CRUD',
  `generate_type` smallint(6) NULL DEFAULT 1 COMMENT '1 压缩包下载 2 生成到模块',
  `generate_path` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'saiadmin-artd' COMMENT '前端根目录',
  `generate_model` smallint(6) NULL DEFAULT 1 COMMENT '1 软删除 2 非软删除',
  `generate_menus` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '生成菜单列表',
  `build_menu` smallint(6) NULL DEFAULT 1 COMMENT '是否构建菜单',
  `component_type` smallint(6) NULL DEFAULT 1 COMMENT '组件显示方式',
  `options` varchar(1500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '其他业务选项',
  `form_width` int(11) NULL DEFAULT 800 COMMENT '表单宽度',
  `is_full` tinyint(1) NULL DEFAULT 1 COMMENT '是否全屏',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `source` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '数据源',
  `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '代码生成业务表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sa_article
-- ----------------------------
DROP TABLE IF EXISTS `sa_article`;
CREATE TABLE `sa_article`  (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `category_id` int(10) NOT NULL COMMENT '分类id',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '文章标题',
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '文章作者',
  `image` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '文章图片',
  `describe` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '文章简介',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '文章内容',
  `views` int(11) NULL DEFAULT 0 COMMENT '浏览次数',
  `sort` int(10) UNSIGNED NULL DEFAULT 100 COMMENT '排序',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '状态',
  `is_link` tinyint(1) NULL DEFAULT 2 COMMENT '是否外链',
  `link_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '链接地址',
  `is_hot` tinyint(1) UNSIGNED NULL DEFAULT 2 COMMENT '是否热门',
  `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_category_id`(`category_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '文章表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sa_article
-- ----------------------------
INSERT INTO `sa_article` VALUES (1, 1, '每天睡够8小时才健康？最完美睡眠时间其实是……', '央视网', 'https://p3.img.cctvpic.com/photoworkspace/2025/08/17/2025081714293938289.jpg', '“人一天到底睡多久最好？”这个问题可以说是睡眠话题里最高频的问题之一，很多人对此都很焦虑，生怕自己没睡够。那么，人一天到底睡多久最好？有标准答案吗？', '<p style=\"text-indent: 2em; text-align: start;\">“人一天到底睡多久最好？”这个问题可以说是睡眠话题里最高频的问题之一，很多人对此都很焦虑，生怕自己没睡够。那么，人一天到底睡多久最好？有标准答案吗？</p><p style=\"text-indent: 2em; text-align: start;\">先说答案：因人而异。</p><p style=\"text-indent: 2em; text-align: start;\"><strong>不同年龄，所需睡眠时间不同</strong></p><p style=\"text-indent: 2em; text-align: start;\">《美国睡眠医学会》为了回答“人类睡眠时间”的问题，曾经专门组织了一个睡眠专家小组。小组成员回顾了数百项关于睡眠时间和健康问题的研究，最终给不同年龄段所需睡眠时间划了一个范围。</p><p style=\"text-indent: 2em; text-align: start;\"><img src=\"http://demo.saithink.top/storage/20250818/a964816ba3cfa899c69513e6ed7a04f1ac267c79.png\" alt=\"\" data-href=\"\" style=\"\"></p><p style=\"text-indent: 2em; text-align: start;\">总体来看，婴幼儿所需的睡眠时间最多，随着年龄的增长，人类所需的睡眠时间有减少的趋势，一直到18岁以后，变化才慢慢趋于稳定。</p><p style=\"text-indent: 2em; text-align: start;\">注意，是趋于稳定，不是固定不变。所以，不同年龄段，睡眠需求可以变化。</p><p style=\"text-indent: 2em; text-align: start;\">为什么没有3个月以下宝宝的建议呢？原因是这个年龄组的睡眠需求差异非常大（少则11小时，多则19小时）。所以，家长们无需和其他孩子比睡觉时间然后回来折腾宝宝。</p><p style=\"text-indent: 2em; text-align: start;\"><strong>成年人每天睡眠时间要≥7小时吗？</strong></p><p style=\"text-indent: 2em; text-align: start;\">因人而异。但每天7小时以上的睡眠的确是多数成年人需要的，这里的多数是统计学上的一个“均数”。</p><p style=\"text-indent: 2em; text-align: start;\">如果你白天多数时候状态都不好，常常犯困，或者常常需要靠咖啡提神，这个时候需要考虑的问题就是：夜间睡眠不足。下一步就是重新调整作息，让自己多睡会儿。</p><p style=\"text-indent: 2em; text-align: start;\">但是要注意，“多数人”也好，“均数”也罢，都不等于标准答案。在睡眠时间统计图表上，除了中间的7小时外，还有部分数据是分布在两端的。最左端是“短睡眠者”，最右端是“长睡眠者”。</p><p style=\"text-indent: 2em; text-align: start;\">即存在少部分人（天生的），他们不需要睡那么多，睡6个小时或者5个小时就够了（即不影响白天状态）。也存在少部分人，天生需要睡很久，可能需要睡9小时甚至10小时以上才能保证白天的精神状态（对成年人来说）。从某种角度来说，长睡眠者是最容易“睡不够”的一群人，他们常常在白天打瞌睡，影响学习和工作效率。</p><p style=\"text-indent: 2em; text-align: start;\">从短睡眠者，到中间的“7～9小时均数”，再到长睡眠者，这些睡眠数据形成了一个正常的连续的“时间谱”。所谓的“成年人需要8小时睡眠”只是一个参考答案，作为个体，不能只根据一个单独的数字来给自己贴“睡眠不足”或“睡眠太多”的标签。</p><p style=\"text-indent: 2em; text-align: start;\">换句话说，你的睡眠时间，不要和过去比；你的睡眠时间，不要和别人比。</p><p style=\"text-indent: 2em; text-align: start;\"><strong>如何判断自己需要睡多久？</strong></p><p style=\"text-indent: 2em; text-align: start;\">看醒后的表现。如果你醒来后，在多数时间都能保持足够清醒和足够好的专注力，不影响工作和生活，那么就可以认为，睡得可以。</p><p style=\"text-indent: 2em; text-align: start;\">反之，如果醒后还容易嗜睡，注意力下降，那么就意味着你睡得不够好——或者是时间不够，或者是质量不佳，或者两者都有。</p><p style=\"text-indent: 2em; text-align: start;\">这个时候，你可以先参照一下成年人的“均数”——7小时。如果时间没有7小时，可以试着找一找“时间都去哪儿了”。如果时间有7小时，那就需要寻找下是否有其他“睡眠阻力”在干扰你的睡眠质量。</p><p style=\"text-indent: 2em; text-align: start;\"><strong>睡眠不足该怎么办？</strong></p><p style=\"text-indent: 2em; text-align: start;\">如果睡眠不足，可以参照以下3个步骤去改善：</p><p style=\"text-indent: 2em; text-align: start;\">1.梳理睡前活动</p><p style=\"text-indent: 2em; text-align: start;\">首先，把晚上睡前的活动进行梳理，计算各自大概占了多少时间。然后，挑出那些没那么重要的项目，试着把这些项目删掉或者时间压缩。</p><p style=\"text-indent: 2em; text-align: start;\">2.做一个睡前放松的仪式</p><p style=\"text-indent: 2em; text-align: start;\">制定一个能让自己放松的睡前仪式。这样做的好处是，可以让大脑更容易从紧张的白天工作以及互联网信息中解脱出来，有利于进入睡眠状态。</p><p style=\"text-indent: 2em; text-align: start;\">3.补觉</p><p style=\"text-indent: 2em; text-align: start;\">如果晚上实在是没睡够，可以采取补觉的方式让自己“回点血”。不过，补觉需要技巧，一次不能补太狠，否则容易影响当天晚上的睡眠，也容易打乱整体的睡眠节律。</p><p style=\"text-indent: 2em; text-align: start;\">最推荐的补觉方式是“分期付款”。比如，工作日晚上睡不够，那么在白天的中午时段，小睡20分钟。遇到节假日，中午可以再小睡20分钟，晚上早点安排自己睡觉。（科普中国）</p>', 3, 100, 1, 2, '', 2, 1, 1, '2024-06-02 22:55:25', '2024-07-31 16:31:42', NULL);
INSERT INTO `sa_article` VALUES (2, 2, '爱德华兹29+10+9 森林狼险胜独行侠大比分1-3', '新浪体育', 'https://picsum.photos/800/400?random=2', '北京时间5月29日，NBA季后赛西部决赛G4，森林狼105-100险胜独行侠，森林狼将大比分追至1-3。 森林狼（1-3）：爱德华兹29分10篮板9助攻、唐斯25分5篮板', '<p> &nbsp; &nbsp; &nbsp; &nbsp;最近，要问什么最火？不是女明星胜似女明星，说的就是汤姆猫的女朋友：</p><p><br></p><p style=\"text-align: center;\">　　《猫和老鼠》截图（豆瓣）</p><p>　　说是女朋友，不如说是汤姆的女神更为贴切。她身上有着娇俏、妩媚、精致的人类特质，又有着像猫咪一样的慵懒和傲娇，网红和明星都纷纷将她拟人化。</p><p><br></p><p style=\"text-align: center;\">　　《猫和老鼠》截图（豆瓣）</p><p>　　周也这波，在你心里是几分？</p><p><br></p><p><br></p><p>　　猫系女孩当然会具备像小猫一样的慵懒和傲娇，体现在面部特征上，大概率就是这样的类型：</p><p><br></p><p style=\"text-align: center;\">　　微博@喜欢傲娇迪</p><p>　　首先，面部和五官的排布占比中，五官的比重更大。同时，眼睛会是偏圆润的类型。</p><p><br></p><p>　　整体看上去面部的锐感是很微弱的，而钝感较强。比较明显的对比就是Jennie、宁艺卓这类长相与黄礼志是截然不同的两种风格：</p><p><br></p><p><br></p><p>　　在圆眼型的基础上，猫系女孩的眼睛是有上扬感的。面中饱满，鼻子占比大，下巴短而圆润，看上去十分可爱。</p><p><br></p><p style=\"text-align: center;\">　　微博@喜欢傲娇迪</p><p><br></p><p style=\"text-align: center;\">　　微博@妹妹你真吃藕</p><p>　　上面的特征听起来好像都不是什么特别的长相，怎么组合在一起就变成了危险又迷人的猫女了呢？</p><p>　　这大概要归功于钝感带来的眼缘。猫系长相中，面部软组织略厚是一个重要特点。这会给人一种可爱感和亲切感，看上去还会有一种慵懒和随意的气质。同时，这种面相在传统意义中，也代表着喜庆、福气和财富。因此，这也是长辈们特别钟爱的类型。</p><p><br></p><p>　　先来说说猫系女孩怎么妆发：</p><p>　　猫系女孩的妆容烦恼也源自于面部软组织的钝感。因为这种饱满，以及面部折叠度低的特点，特写时会有点显胖。</p><p>　　要想解决这个问题，我们可以把重点放在改善面部长宽比上。长宽比较小，又没有特别突出的面部棱角感，看上去会更衬托圆润感，还会突出没有起伏的“平”，因此我们可以通过侧面内推的修容和长发，去把露肤的脖子也拉进面部比例中：</p><p><br></p><p>　　第二，我们要强化面部的起伏，也就是画强调五官的妆容。</p><p>　　猫系女孩的钝感会导致很难塑造外轮廓，因此在这个部分只需要打造向内推的流畅感即可，把轮廓交给五官。通过眼窝、山根、眉骨的轮廓架起基调，弱化上半张脸的“平”感，再通过饱满的唇妆，强化轮廓的同时增加下庭存在感。</p><p><br></p><p>　　接下来，我们再说说猫系妆感要怎么塑造。</p><p>　　重点有三。</p><p>　　其一，是面部的小巧流畅感。</p><p>　　先找到自己面部最凹陷的一些部分——可以通过手机的手电筒，从下巴往上照，最阴影的地方就是需要调整的位置。三八线、嘴角这些部分要尤其注意，在底妆时就要用亮一色的遮瑕着重遮盖，再盖上散粉。在后续上妆时，避免使用大颗粒、强反光的彩妆产品，不需强调饱满度。使用弱反光、细颗粒及哑光的自然妆感产品，会给人一种原生皮光泽感，更能够凸显猫系的元气魅力。</p><p><br></p><p><br></p><p>　　其二，是眼妆的塑造。</p><p>　　重点是眼睑下至配合眼尾上扬走势，让眼睛呈现出慵懒和深邃的质感。</p><p><br></p><p>　　轮廓色扩大面积，强调色收缩在睫毛根部周围，让眼神更聚光，营造出猫咪圆眼大瞳孔状态下的可爱质感。</p><p><br></p><p><br></p><p>　　其三是腮红和唇妆带来的大面积氛围感。</p><p><br></p><p>　　精致圆润又饱满的唇妆是猫系妆感的重要特征。我们可以在这一步，利用口红颜色的遮盖度调整唇形和唇部对称情况，强调下庭比例，也会在视觉上优化面部五官排布：</p><p><br></p><p>　　同时，使用能够与唇色呼应的腮红色，以团式打法轻扫面中，提升面部平整度的同时，强化可爱氛围感：</p><p><br></p>', 0, 100, 1, 2, '', 2, 1, 2, '2024-06-02 22:56:47', '2026-01-07 15:33:49', NULL);
INSERT INTO `sa_article` VALUES (3, 3, '阿森纳理疗师里斯将前往曼联担任首席理疗师', '新浪体育', 'https://picsum.photos/800/400?random=3', 'The Athletic报道，阿森纳理疗师乔丹-里斯即将加盟曼联，成为红魔的首席理疗师。曼联首席理疗师罗宾-萨德勒已于今年一月离开俱乐部', '<p>荣耀正在筹备一大波新品 两款折叠屏＋X60＋ GT新机</p><p>　　【CNMO科技消息】5月31日，CNMO注意到，据知名爆料人士“数码闲聊站”透露，荣耀方面似乎正在筹备大量新品，接下来的6、7、8月基本都有活动。</p><p><br></p><p>　　据悉，荣耀有两款折叠屏手机正在筹备，分别为超大尺寸外屏的小折叠屏手机和超轻薄的大折叠屏手机。据悉，荣耀小折叠屏新机将会在下个月跟大家见面，新机依旧会沿用Magic系列命名，采用目前行业最大电池和最大外屏的小折叠屏手机，可折叠次数也比较猛，并且新机也会提供联名版本。荣耀的大折叠屏手机也同样值得期待，预计该机将在屏幕、续航、影像、厚度、重量等多方面进行改进。</p><p><br></p><p>　　近日，不久前荣耀X50的国内销量已经突破了1000万部，堪称“入门销量王”。而据爆料，荣耀X60将会采用高端设计语言，内置超大容量电池，抗摔能力进一步提升，同时普及等深四曲面屏幕。荣耀X60或许将会成为一款“披着旗舰手机皮的千元机”，销量有望延续前代产品辉煌。</p><p>　　荣耀GT系列新机暂未有消息流传，参考目前的荣耀GT产品，新机应该是一款侧重性能的高性价比机型。</p><p>　　此外，据透露，荣耀还有多款搭载高通骁龙8 Gen 3移动平台和高通骁龙8s Gen 3移动平台的新品正在筹备。</p>', 0, 100, 1, 2, '', 2, 1, 2, '2024-06-02 22:58:41', '2026-01-07 15:50:06', NULL);
INSERT INTO `sa_article` VALUES (4, 4, '半场-马莱莱斩获赛季第6球 申花1-0领先深圳新鹏城', '新浪体育', 'https://picsum.photos/800/400?random=4', '5月26日晚上18：00，中超第14轮，深圳新鹏城主场迎战上海申花，上半场马莱莱补射斩获赛季第6球，半场战罢，申花暂1-0新鹏城', '<p> &nbsp; &nbsp; &nbsp; &nbsp;5月26日晚上18：00，中超第14轮，深圳新鹏城主场迎战上海申花，上半场马莱莱补射斩获赛季第6球，半场战罢，申花暂1-0新鹏城。</p><p><br></p>', 0, 100, 1, 2, '', 2, 1, 1, '2024-06-02 22:59:41', '2024-07-31 16:31:32', NULL);
INSERT INTO `sa_article` VALUES (5, 1, '周也热巴带火猫塑女风 如何打造猫系女孩妆容', '新浪时尚', 'https://picsum.photos/800/400?random=5', '最近，要问什么最火？不是女明星胜似女明星，说的就是汤姆猫的女朋友', '<p> &nbsp; &nbsp; &nbsp; &nbsp;最近，要问什么最火？不是女明星胜似女明星，说的就是汤姆猫的女朋友：</p><p><br></p><p style=\"text-align: center;\">　　《猫和老鼠》截图（豆瓣）</p><p>　　说是女朋友，不如说是汤姆的女神更为贴切。她身上有着娇俏、妩媚、精致的人类特质，又有着像猫咪一样的慵懒和傲娇，网红和明星都纷纷将她拟人化。</p><p><br></p><p style=\"text-align: center;\">　　《猫和老鼠》截图（豆瓣）</p><p>　　周也这波，在你心里是几分？</p><p><br></p><p><br></p><p>　　猫系女孩当然会具备像小猫一样的慵懒和傲娇，体现在面部特征上，大概率就是这样的类型：</p><p><br></p><p style=\"text-align: center;\">　　微博@喜欢傲娇迪</p><p>　　首先，面部和五官的排布占比中，五官的比重更大。同时，眼睛会是偏圆润的类型。</p><p><br></p><p>　　整体看上去面部的锐感是很微弱的，而钝感较强。比较明显的对比就是Jennie、宁艺卓这类长相与黄礼志是截然不同的两种风格：</p><p><br></p><p><br></p><p>　　在圆眼型的基础上，猫系女孩的眼睛是有上扬感的。面中饱满，鼻子占比大，下巴短而圆润，看上去十分可爱。</p><p><br></p><p style=\"text-align: center;\">　　微博@喜欢傲娇迪</p><p><br></p><p style=\"text-align: center;\">　　微博@妹妹你真吃藕</p><p>　　上面的特征听起来好像都不是什么特别的长相，怎么组合在一起就变成了危险又迷人的猫女了呢？</p><p>　　这大概要归功于钝感带来的眼缘。猫系长相中，面部软组织略厚是一个重要特点。这会给人一种可爱感和亲切感，看上去还会有一种慵懒和随意的气质。同时，这种面相在传统意义中，也代表着喜庆、福气和财富。因此，这也是长辈们特别钟爱的类型。</p><p><br></p><p>　　先来说说猫系女孩怎么妆发：</p><p>　　猫系女孩的妆容烦恼也源自于面部软组织的钝感。因为这种饱满，以及面部折叠度低的特点，特写时会有点显胖。</p><p>　　要想解决这个问题，我们可以把重点放在改善面部长宽比上。长宽比较小，又没有特别突出的面部棱角感，看上去会更衬托圆润感，还会突出没有起伏的“平”，因此我们可以通过侧面内推的修容和长发，去把露肤的脖子也拉进面部比例中：</p><p><br></p><p>　　第二，我们要强化面部的起伏，也就是画强调五官的妆容。</p><p>　　猫系女孩的钝感会导致很难塑造外轮廓，因此在这个部分只需要打造向内推的流畅感即可，把轮廓交给五官。通过眼窝、山根、眉骨的轮廓架起基调，弱化上半张脸的“平”感，再通过饱满的唇妆，强化轮廓的同时增加下庭存在感。</p><p><br></p><p>　　接下来，我们再说说猫系妆感要怎么塑造。</p><p>　　重点有三。</p><p>　　其一，是面部的小巧流畅感。</p><p>　　先找到自己面部最凹陷的一些部分——可以通过手机的手电筒，从下巴往上照，最阴影的地方就是需要调整的位置。三八线、嘴角这些部分要尤其注意，在底妆时就要用亮一色的遮瑕着重遮盖，再盖上散粉。在后续上妆时，避免使用大颗粒、强反光的彩妆产品，不需强调饱满度。使用弱反光、细颗粒及哑光的自然妆感产品，会给人一种原生皮光泽感，更能够凸显猫系的元气魅力。</p><p><br></p><p><br></p><p>　　其二，是眼妆的塑造。</p><p>　　重点是眼睑下至配合眼尾上扬走势，让眼睛呈现出慵懒和深邃的质感。</p><p><br></p><p>　　轮廓色扩大面积，强调色收缩在睫毛根部周围，让眼神更聚光，营造出猫咪圆眼大瞳孔状态下的可爱质感。</p><p><br></p><p><br></p><p>　　其三是腮红和唇妆带来的大面积氛围感。</p><p><br></p><p>　　精致圆润又饱满的唇妆是猫系妆感的重要特征。我们可以在这一步，利用口红颜色的遮盖度调整唇形和唇部对称情况，强调下庭比例，也会在视觉上优化面部五官排布：</p><p><br></p><p>　　同时，使用能够与唇色呼应的腮红色，以团式打法轻扫面中，提升面部平整度的同时，强化可爱氛围感：</p><p><br></p>', 2, 100, 1, 2, '', 2, 1, 1, '2024-06-02 23:01:17', '2024-07-31 16:31:25', NULL);
INSERT INTO `sa_article` VALUES (6, 2, '深度 | 明星穿高定亮相红毯，为何遭客户投诉？', '新浪时尚', 'https://picsum.photos/800/400?random=6', '曾经神秘的高级定制正处于舆论漩涡。 国内高级定制客户lulu近日在社交媒体上发帖，控诉意大利奢侈品牌Giambattista Valli在未征求她意见的情况下.', '<p> &nbsp; &nbsp; &nbsp; &nbsp;曾经神秘的高级定制正处于舆论漩涡。</p><p>　　国内高级定制客户lulu近日在社交媒体上发帖，控诉意大利奢侈品牌Giambattista Valli在未征求她意见的情况下，将其已购买的一件高级定制作品的样衣，借予英国演员Anya Taylor-Joy以出席电影首映会，引发网友广泛讨论。</p><p>　　截至发稿，原帖的点赞数已超过1万，而相关讨论帖的平均热度也达上千。</p><p>　　事件焦点是一套来自Giambattista Valli 2024春夏高级定制系列中的立体玫瑰花朵连体衣。lulu称此前在今年年初的巴黎高级定制周中已支付该作品的定金，但目前已决定放弃20余万元的定金并选择退货。</p><p>　　在该名高级定制客户看来，Giambattista Valli过于商业化的做法违背了行业潜规则，也让她失去了收藏高级定制的意义，并称其是“没有底蕴的二线品牌”。</p><p>国内高级定制客户lulu控诉Giambattista Valli过于商业化的做法违背了行业潜规则</p><p>　　Giambattista Valli由意大利同名设计师于2005年成立，于2017年将少数股权出售给开云集团控股股东Pinault家族名下公司Artémis。去年9月，Giambattista Valli宣布上任仅三年的首席执行官Charlotte Werner离职，目前暂未任命继任者。</p><p>　　2011年，Giambattista Valli成为法国高级时装协会的正式成员，并发布其首个高级定制系列。凭借其标志性的梦幻色彩、纱质褶皱以及巨大裙摆，该品牌很快赢得包括蕾哈娜、杨幂、迪丽热巴等国内外明星的青睐，被称为红毯上的新一代“高定之王”。</p><p>　　从明星粉丝间近几年掀起的红毯高定攀比之风中不难看出，其希望从中获得背书的高级定制位于时装产业金字塔塔尖，这也就意味着高级定制拥有与普通奢侈品截然不同的运作逻辑。</p><p>　　作为精英的特供、权力的体现，高级定制无关乎季节性和功能性，也脱离了最基本的商业准则，它只需要展示极致的创意、繁复的工艺和令人咋舌的耗时。尽管高级定制并不是一门赚钱的生意，但它所营造的终极时装梦想养活了整个时尚产业。</p><p>　　某种程度上来说，相比于同属于一家时装屋的成衣系列，高级定制往往与高级珠宝或其他艺术收藏品有着更多相似之处，高昂的标价不仅涵盖作品本身的创意价值，还蕴藏着不可复制的唯一性。</p><p>Giambattista Valli被称为红毯上的新一代“高定之王”</p><p>　　在lulu本次以及此前的多条帖文中均曾提及，Valentino、Giorgio Armani Privé等传统时装屋的高级定制系列具有唯一性，即已经被客户购买的作品将不会以完全相同的外观再出现在其他场合。</p><p>　　如果品牌需要向明星借出该作品，往往会与客户进行沟通，并对其颜色、细节等进行部分改动，以示对高级定制买家的尊重。尽管这并不是明文规定，但却已经成为行业内众所周知的潜规则。</p><p>　　Giambattista Valli如今的做法无疑破坏了这一约定，而lulu自身的影响力更是让这一事件在社交媒体中被反复发酵，令该品牌陷入舆论危机。</p><p>　　不同于国内传统高级定制客户的低调，lulu早在多年前就凭借Valentino音符裙等高级定制作品，独特的收藏品味，以及与Giorgio Armani、Pierpaolo Piccioli等多位明星设计师的互动，而在社交媒体上拥有众多粉丝，其全平台的粉丝数目前已累计超过100万。去年，lulu还在上海开设了一个陈列其所有高级定制收藏的空间Maison Lulu。</p><p>图为lulu购买的Valentino高级定制作品，以及Lady Gaga所身着的改动版</p><p>　　有数据表明，全球高级定制客户仅两千人左右，这也就意味着任何一位客户都至关重要，更何况在舆论发酵后，Giambattista Valli将在中国损失相当大的市场份额，似乎已经成为事实。</p><p>　　尽管由于高级定制的特殊性，该事件几乎被公认为Giambattista Valli的工作失误，但在更广泛的奢侈品领域，明星与VIC客户之间的矛盾却愈演愈烈。</p><p>　　今年年初，LV代言人周冬雨在参加2024秋冬系列时装秀时，就因在合影环节的不配合举动而被VIC客户投诉，并引起社交媒体上广泛关注。据后者所述，品牌方在时装秀结束后安排了合影环节，但周冬雨却态度敷衍，令其感到不适。随后，另一位LV VIC客户也在社交媒体上发帖表示认同。</p><p>　　数据显示，相关微博话题的阅读量短时间内就已超6700万。</p><p>周冬雨出席LV 24秋冬女装秀却遭VIC客户投诉</p><p>　　明星与VIC客户之间的矛盾中，隐藏着话语权和资源的争夺。</p><p>　　在明星效应尚未被大范围应用的时代，VIC客户自然占据上风。</p><p>　　2001年，Chanel为打开年轻市场曾任命歌手李玟为代言人，但有消息指出，该任命被香港VIC客户强烈抵制，导致品牌最终撤掉了代言人。往后的十几年，奢侈品牌在中国市场仍然相对保守，极度爱惜羽毛，对品牌形象一丝不苟，VIC客户的稳定也让品牌鲜少启用明星扩大市场影响力。</p><p>　　然而随着中国社交媒体的迅速发展以及粉丝经济的兴起，流量明星能为品牌带来的短期价值陡然上升。在行业持续低迷的情况下，不少奢侈品牌开始尝试与他们合作。</p><p>　　2017年，Angelababy成为Dior中国区首位品牌大使，并建立了庞大的明星矩阵。借助粉丝经济的红利，在高密度的市场营销活动配合之下，Dior时装秀在社交媒体上的讨论热度逐季攀升，促进品牌的市场影响力在几年内获得指数级增长。</p><p>　　巨大的增幅令奢侈品行业在此后的约五年间激进地押注明星策略，激烈的市场竞争彻底改变了奢侈品牌的心态，使他们在高收益面前跃跃欲试。</p><p>　　LVMH首席财务官Jean-Jacques Guiony曾在当时坦言，“我们并不担心过度曝光，真正的风险是势头不够以致于不能在市场竞争中冲在前面。”</p><p>　　据CBNData与星数的《2020年上半年明星带货》报告显示，即使在疫情期间，仅半年明星引导消费金额就同比增长了52.3%。在奢侈品牌的社交账号上，与明星相关的推文的转评赞通常是常规推文几千倍甚至几万倍。</p><p>奢侈品行业在2017年后激进地押注明星策略</p><p>　　在此期间，即使面临边际效应递减，任命流量明星风险过高等挑战，奢侈品牌依然将其视为最有效的传播媒介。</p><p>　　如果只是有限的回报，奢侈品牌显然不会冒如此大的风险，这背后的关键在于明星在扩大市场影响力以及刺激市场消费的维度上，有着不可替代的作用，而这对于正处于扩张期的奢侈品牌而言至关重要。</p><p>　　笼络中产阶层消费者，是奢侈品牌过去几年的核心策略，他们为后者提供了巨大的市场增量，也为集团不断上涨的股价提供动力。代言人则正是吸引这部分群体最直接的手段之一，明星对奢侈品牌的重要性自然也水涨船高。</p><p>　　然而当经济持续承压，中产阶层消费者购买力因此显著下滑时，明星代言人所能完成的转化也随之降低，再叠加消费者对愈发频繁和同质化的代言人策略的疲劳，品牌增长动力链出现断裂。</p><p>　　奢侈品牌于是逐步意识到核心客群的重要性，并将销售重心重新从中产阶层向高净值人群偏移。面临不确定性增大的市场环境，他们往往拥有更好的抗风险能力。</p><p>　　贝恩报告曾经指出，仅2%的VIC客户贡献了全球奢侈品销售额的40%，而2009年仅为35%，中国市场的VIC集中度超过了全球平均水平。摩根士丹利的分析称在中国一些主要高端购物中心，不到1%的顾客就可以贡献高达40%的销售额。因此在继续稳固非核心消费者规模的同时，奢侈品牌正将如何继续提升VIC核心消费者忠诚度摆在战略地位上。</p><p>　　自2022年起，LV、Chanel和Dior等奢侈品牌接连在北京、上海、广州、深圳以及成都等多个主要奢侈品消费城市，开设VIC沙龙空间，将手伸至这些高净值人群口袋的更深处。上周，LV在其广州太古汇精品店的二层开设了全新沙龙空间，陈列男女成衣、晚礼服、皮具、高级珠宝腕表以及硬箱等产品。</p><p>　　在这一背景下，VIC客户在品牌的话语权也随之被放大，其与明星之间微妙的比较心理或许是二者矛盾的根源。</p><p>　　本质上，明星对应着中产阶层消费者，而奢侈品牌过去十多年间所做的就是在中产阶层和VIC客户之间建立动态平衡。</p><p>　　对于已经驶出高速发展期的奢侈品牌而言，如今的业绩增长更多依靠客户关系管理，通过提升VIC客户的忠诚度完成销售转化，而非过去五年间依靠明星代言人，扩大市场影响力以吸引潜在消费者购买的驱动模式。</p><p><br></p><p>　　这也是奢侈品牌如今在明星策略上逐渐保守的原因，相较于高风险高收益的流量偶像，它们或许更青睐作品口碑俱佳的成熟艺人，这些明星拥有经过时间检验的影响力，并在多个圈层乃至于全球市场拥有影响力。</p><p>　　2022年11月，Balenciaga任命奥斯卡影后杨紫琼为品牌大使。去年12月，周杰伦被Dior任命为全球品牌大使，成为首个拥有该头衔的中国明星，三个月后其成为箱包品牌Rimowa首位华人全球品牌代言人。</p><p>　　在奢侈品牌纷纷将天平向VIC客户倾斜时，一直以来在明星策略上颇为激进的Prada集团又因其代言人而深陷舆论危机。</p><p>　　Miu Miu品牌代言人张元英的所属韩国女子团体ive，此前就因其《HEYA》MV中的文化挪用现象而引发热议，近日又被指新歌《Accendio》MV中一镜头或涉及辱华。近日，有大量中国网友在品牌官方Instagram账号发言敦促品牌与明星解约，Miu Miu目前对此尚未置评。</p><p>　　面对明星背后的消费者，和品牌直面的消费者，奢侈品牌正在谨慎调节手中的天平。</p>', 2, 100, 1, 2, '', 2, 1, 1, '2024-06-02 23:02:40', '2024-07-31 16:31:19', NULL);
INSERT INTO `sa_article` VALUES (7, 3, '荣耀正在筹备一大波新品 两款折叠屏＋X60＋ GT新机', '新浪科技', 'https://picsum.photos/800/400?random=7', '荣耀正在筹备一大波新品 两款折叠屏＋X60＋ GT新机 【CNMO科技消息】5月31日，CNMO注意到，据知名爆料人士“数码闲聊站”透露，荣耀方面似乎正在筹备大量新品', '<p>荣耀正在筹备一大波新品 两款折叠屏＋X60＋ GT新机</p><p>　　【CNMO科技消息】5月31日，CNMO注意到，据知名爆料人士“数码闲聊站”透露，荣耀方面似乎正在筹备大量新品，接下来的6、7、8月基本都有活动。</p><p><br></p><p>　　据悉，荣耀有两款折叠屏手机正在筹备，分别为超大尺寸外屏的小折叠屏手机和超轻薄的大折叠屏手机。据悉，荣耀小折叠屏新机将会在下个月跟大家见面，新机依旧会沿用Magic系列命名，采用目前行业最大电池和最大外屏的小折叠屏手机，可折叠次数也比较猛，并且新机也会提供联名版本。荣耀的大折叠屏手机也同样值得期待，预计该机将在屏幕、续航、影像、厚度、重量等多方面进行改进。</p><p><br></p><p>　　近日，不久前荣耀X50的国内销量已经突破了1000万部，堪称“入门销量王”。而据爆料，荣耀X60将会采用高端设计语言，内置超大容量电池，抗摔能力进一步提升，同时普及等深四曲面屏幕。荣耀X60或许将会成为一款“披着旗舰手机皮的千元机”，销量有望延续前代产品辉煌。</p><p>　　荣耀GT系列新机暂未有消息流传，参考目前的荣耀GT产品，新机应该是一款侧重性能的高性价比机型。</p><p>　　此外，据透露，荣耀还有多款搭载高通骁龙8 Gen 3移动平台和高通骁龙8s Gen 3移动平台的新品正在筹备。</p>', 5, 100, 1, 2, '', 2, 1, 1, '2024-06-02 23:04:23', '2024-07-31 16:31:10', NULL);

-- ----------------------------
-- Table structure for sa_article_category
-- ----------------------------
DROP TABLE IF EXISTS `sa_article_category`;
CREATE TABLE `sa_article_category`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `parent_id` int(11) NOT NULL DEFAULT 0 COMMENT '父级ID',
  `category_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '分类标题',
  `describe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '分类简介',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '分类图片',
  `sort` int(10) UNSIGNED NULL DEFAULT 100 COMMENT '排序',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '状态',
  `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '文章分类表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sa_article_category
-- ----------------------------
INSERT INTO `sa_article_category` VALUES (1, 0, '资讯中心', '', NULL, 100, 1, 1, 1, '2024-06-02 22:50:51', '2026-01-06 18:03:07', NULL);
INSERT INTO `sa_article_category` VALUES (2, 0, '回收中心', '', NULL, 100, 1, 1, 1, '2024-06-02 22:50:56', '2026-01-06 18:01:44', NULL);
INSERT INTO `sa_article_category` VALUES (3, 0, '茅台行情', '', NULL, 100, 1, 1, 1, '2024-06-02 22:51:01', '2026-01-07 01:03:37', NULL);
INSERT INTO `sa_article_category` VALUES (4, 0, '茅台价格', '', NULL, 100, 1, 1, 1, '2024-06-02 22:51:16', '2026-01-06 18:03:14', NULL);
INSERT INTO `sa_article_category` VALUES (5, 1, '22222', '', '', 100, 1, 1, 1, '2026-01-06 18:04:53', '2026-01-06 18:04:58', '2026-01-06 18:04:58');
INSERT INTO `sa_article_category` VALUES (6, 1, '国内资讯', '1', '[\"http:\\/\\/127.0.0.1:8888\\/storage\\/20260107\\/7971881d7e10a122e0f51ea188571dbe29d82229.jpg\"]', 100, 1, 1, 1, '2026-01-07 10:18:37', '2026-01-07 11:34:25', NULL);
INSERT INTO `sa_article_category` VALUES (7, 0, '55', '1', 'http://127.0.0.1:8888/storage/20251203/6faae88b0c07c1fe787a2b2bfc62de0e49a99e57.png', 100, 1, 1, 1, '2026-01-07 11:40:11', '2026-01-07 11:57:04', NULL);

-- ----------------------------
-- Table structure for sa_article_banner
-- ----------------------------
DROP TABLE IF EXISTS `sa_article_banner`;
CREATE TABLE `sa_article_banner`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `banner_type` int(11) NULL DEFAULT NULL COMMENT '类型',
  `image` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '图片地址',
  `is_href` tinyint(1) NULL DEFAULT 1 COMMENT '是否链接',
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '链接地址',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '标题',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
  `sort` int(11) NULL DEFAULT 0 COMMENT '排序',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '描述',
  `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '文章轮播图' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sa_article_banner
-- ----------------------------
INSERT INTO `sa_article_banner` VALUES (1, 1, 'https://picsum.photos/id/490/640/360', 1, '/blog/1', '探索亚洲的烹饪奇迹', 1, 0, '深入理解 Vue 3 组合式 API 的使用方法和最佳实践', 1, 1, '2024-06-02 23:06:37', '2024-07-31 16:24:15', NULL);
INSERT INTO `sa_article_banner` VALUES (2, 1, 'https://picsum.photos/id/29/640/360', 1, '/blog/2', '探索雄伟的山峰', 1, 0, '从零开始学习 Nuxt 3 框架，构建现代化 SSR 应用', 1, 1, '2024-06-02 23:06:49', '2024-07-31 16:24:23', NULL);
INSERT INTO `sa_article_banner` VALUES (3, 1, 'https://picsum.photos/id/903/640/360', 1, '/blog/3', '揭秘奇迹', 1, 0, '掌握 TypeScript 中的高级类型系统和实用技巧', 1, 1, '2024-06-02 23:06:56', '2024-07-31 16:24:34', NULL);

SET FOREIGN_KEY_CHECKS = 1;
