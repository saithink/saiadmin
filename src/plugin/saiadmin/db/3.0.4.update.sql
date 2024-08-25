-- 1. eb_system_role 添加新列
ALTER TABLE `eb_system_role`
ADD COLUMN `parent_id` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '父ID' AFTER `id`,
ADD COLUMN `level` varchar(500) NULL DEFAULT NULL COMMENT '组级集合' AFTER `parent_id`;

-- 2. 数据权限字典配置
INSERT INTO `eb_system_dict_type` VALUES (NULL, '数据权限', 'data_scope', 1, '', 1, 1, '2024-07-31 10:35:07', '2024-07-31 10:35:07', NULL);
SET @id := LAST_INSERT_ID();
INSERT INTO `eb_system_dict_data` VALUES (NULL, @id, '全部数据权限', '1', 'data_scope', 100, 1, '', 1, 1, '2024-07-31 10:35:22', '2024-07-31 10:35:22', NULL);
INSERT INTO `eb_system_dict_data` VALUES (NULL, @id, '自定义数据权限', '2', 'data_scope', 100, 1, '', 1, 1, '2024-07-31 10:35:22', '2024-07-31 10:35:22', NULL);
INSERT INTO `eb_system_dict_data` VALUES (NULL, @id, '本部门数据权限', '3', 'data_scope', 100, 1, '', 1, 1, '2024-07-31 10:35:22', '2024-07-31 10:35:22', NULL);
INSERT INTO `eb_system_dict_data` VALUES (NULL, @id, '本部门及以下数据权限', '4', 'data_scope', 100, 1, '', 1, 1, '2024-07-31 10:35:22', '2024-07-31 10:35:22', NULL);
INSERT INTO `eb_system_dict_data` VALUES (NULL, @id, '本人数据权限', '5', 'data_scope', 100, 1, '', 1, 1, '2024-07-31 10:35:22', '2024-07-31 10:35:22', NULL);

-- 3. 添加邮件配置
INSERT INTO `eb_system_config_group` VALUES (NULL, '邮件服务', 'email_config', NULL, 1, 1, '2021-11-23 10:49:29', '2021-11-23 10:49:29', NULL);
SET @id := LAST_INSERT_ID();
INSERT INTO `eb_system_config` VALUES (NULL, @id, 'Host', 'smtp.qq.com', 'SMTP服务器', 'input', '', 100, '');
INSERT INTO `eb_system_config` VALUES (NULL, @id, 'Port', '465', 'SMTP端口', 'input', '', 100, '');
INSERT INTO `eb_system_config` VALUES (NULL, @id, 'Username', '', 'SMTP用户名', 'input', '', 100, '');
INSERT INTO `eb_system_config` VALUES (NULL, @id, 'Password', '', 'SMTP密码', 'input', '', 100, '');
INSERT INTO `eb_system_config` VALUES (NULL, @id, 'SMTPSecure', 'ssl', 'SMTP验证方式', 'radio', '[\r\n    {\"label\":\"ssl\",\"value\":\"ssl\"},\r\n    {\"label\":\"tsl\",\"value\":\"tsl\"}\r\n]', 100, '');
INSERT INTO `eb_system_config` VALUES (NULL, @id, 'From', '', '默认发件人', 'input', '', 100, '默认发件的邮箱地址');
INSERT INTO `eb_system_config` VALUES (NULL, @id, 'FromName', '', '默认发件名称', 'input', '', 100, '');
INSERT INTO `eb_system_config` VALUES (NULL, @id, 'CharSet', 'UTF-8', '编码', 'input', '', 100, '');
INSERT INTO `eb_system_config` VALUES (NULL, @id, 'SMTPDebug', '0', '调试模式', 'radio', '[\r\n    {\"label\":\"关闭\",\"value\":\"0\"},\r\n    {\"label\":\"client\",\"value\":\"1\"},\r\n    {\"label\":\"server\",\"value\":\"2\"}\r\n]', 100, '');

-- 3. 添加邮件记录表
CREATE TABLE `eb_system_mail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `gateway` varchar(50) DEFAULT NULL COMMENT '网关',
  `from` varchar(50) DEFAULT NULL COMMENT '发送人',
  `email` varchar(50) DEFAULT NULL COMMENT '接收人',
  `code` varchar(20) DEFAULT NULL COMMENT '验证码',
  `content` varchar(500) DEFAULT NULL COMMENT '邮箱内容',
  `status` varchar(20) DEFAULT NULL COMMENT '发送状态',
  `response` varchar(500) DEFAULT NULL COMMENT '返回结果',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 COMMENT='邮件记录' ROW_FORMAT = Dynamic;