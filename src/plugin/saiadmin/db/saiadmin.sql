/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : saiadmin

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 20/01/2024 16:06:49
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for eb_article
-- ----------------------------
DROP TABLE IF EXISTS `eb_article`;
CREATE TABLE `eb_article`  (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `category_id` int(10) NOT NULL COMMENT '分类id',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '文章标题',
  `author` varchar(255) NULL DEFAULT NULL COMMENT '文章作者',
  `image` varchar(1000) NULL DEFAULT '' COMMENT '文章图片',
  `describe` varchar(1000) NOT NULL COMMENT '文章简介',
  `content` text NOT NULL COMMENT '文章内容',
  `views` int(11) NULL DEFAULT 0 COMMENT '浏览次数',
  `sort` int(10) UNSIGNED NULL DEFAULT 100 COMMENT '排序',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '状态',
  `is_link` tinyint(1) NULL DEFAULT 2 COMMENT '是否外链',
  `link_url` varchar(255) NULL DEFAULT NULL COMMENT '链接地址',
  `is_hot` tinyint(1) UNSIGNED NULL DEFAULT 2 COMMENT '是否热门',
  `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_category_id`(`category_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 COMMENT = '文章表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_article
-- ----------------------------
INSERT INTO `eb_article` VALUES (1, 3, '全球气候峰会达成历史性协议，承诺减缓气候变化', 'chatgpt', 'http://localhost:8787/upload/image/20240120/65ab7b675f01.jpg', '', '<p>&mdash;&mdash; 在本周的联合国气候变化大会上，全球领导人达成了一项具有历史性意义的协议，致力于减缓气候变化的严重影响。这一协议标志着国际社会对气候行动的强烈承诺，将为创造更可持续的未来奠定基础。</p>\n<p>与会的国家首脑一致同意在未来十年内采取更为积极的行动，以降低温室气体排放并推动可再生能源的发展。协议还明确了全球范围内实现零碳排放的目标，并呼吁发达国家向发展中国家提供更多的气候援助。</p>\n<p>联合国秘书长表示，这一协议是对全球气候变化问题最强烈的回应之一，是对科学家们发出的气候紧急警告的直接回应。他强调，各国领导人的团结和决心是实现全球气候可持续未来的关键。</p>\n<p>该协议的一项重要承诺是在未来五年内定期审查并加强各国的减排目标，以确保全球采取的行动与气候变化的紧迫性相匹配。此外，协议还建立了一个国际合作框架，促进技术转让和知识共享，以帮助各国更好地适应气候变化的影响。</p>\n<p>全球气候峰会的成功举办表明了国际社会在面对共同挑战时的团结和决心。各国领导人强调，气候变化不仅是一个全球性问题，也是一个需要集体努力的问题。这一协议的达成为全球未来的可持续发展奠定了坚实的基础，为下一代创造了更为清洁、绿色的生态环境。</p>', 0, 100, 1, 2, NULL, 2, 1, 1, '2024-01-20 15:53:48', '2024-01-20 15:53:48', NULL);

-- ----------------------------
-- Table structure for eb_article_category
-- ----------------------------
DROP TABLE IF EXISTS `eb_article_category`;
CREATE TABLE `eb_article_category`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `parent_id` int(11) NOT NULL DEFAULT 0 COMMENT '父级ID',
  `category_name` varchar(255) NOT NULL COMMENT '分类标题',
  `describe` varchar(255) NULL DEFAULT NULL COMMENT '分类简介',
  `image` varchar(255) NULL DEFAULT NULL COMMENT '分类图片',
  `sort` int(10) UNSIGNED NULL DEFAULT 100 COMMENT '排序',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '状态',
  `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 COMMENT = '文章分类表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_article_category
-- ----------------------------
INSERT INTO `eb_article_category` VALUES (1, 0, '新闻中心', '新闻', 'http://localhost:8787/upload/image/20240120/65ab7abd841f.jpg', 100, 1, 1, 1, '2024-01-20 15:48:15', '2024-01-20 15:51:27', NULL);
INSERT INTO `eb_article_category` VALUES (2, 1, '国内新闻', '国内大事', 'http://localhost:8787/upload/image/20240120/65ab7b52bb76.jpg', 100, 1, 1, 1, '2024-01-20 15:49:55', '2024-01-20 15:51:18', NULL);
INSERT INTO `eb_article_category` VALUES (3, 1, '国际新闻', '国际大事', 'http://localhost:8787/upload/image/20240120/65ab7b675f01.jpg', 100, 1, 1, 1, '2024-01-20 15:51:11', '2024-01-20 15:51:11', NULL);

-- ----------------------------
-- Table structure for eb_system_config
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_config`;
CREATE TABLE `eb_system_config`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `group_id` int(11) NULL DEFAULT NULL COMMENT '组id',
  `key` varchar(32) NOT NULL COMMENT '配置键名',
  `value` varchar(1000) NULL DEFAULT NULL COMMENT '配置值',
  `name` varchar(255) NULL DEFAULT NULL COMMENT '配置名称',
  `input_type` varchar(32) NULL DEFAULT NULL COMMENT '数据输入类型',
  `config_select_data` varchar(500) NULL DEFAULT NULL COMMENT '配置选项数据',
  `sort` smallint(5) UNSIGNED NULL DEFAULT 0 COMMENT '排序',
  `remark` varchar(255) NULL DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`, `key`) USING BTREE,
  INDEX `group_id`(`group_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 COMMENT = '参数配置信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_config
-- ----------------------------
INSERT INTO `eb_system_config` VALUES (1, 1, 'site_copyright', 'Copyright © 2024 saithink', '版权信息', 'textarea', NULL, 96, '');
INSERT INTO `eb_system_config` VALUES (2, 1, 'site_desc', '基于vue3 + webman 的极速开发框架', '网站描述', 'textarea', NULL, 97, NULL);
INSERT INTO `eb_system_config` VALUES (3, 1, 'site_keywords', '后台管理系统', '网站关键字', 'input', NULL, 98, NULL);
INSERT INTO `eb_system_config` VALUES (4, 1, 'site_name', 'SaiAdmin', '网站名称', 'input', NULL, 99, NULL);
INSERT INTO `eb_system_config` VALUES (5, 1, 'site_record_number', '', '网站备案号', 'input', NULL, 95, NULL);
INSERT INTO `eb_system_config` VALUES (6, 2, 'upload_allow_file', 'txt,doc,docx,xls,xlsx,ppt,pptx,rar,zip,7z,gz,pdf,wps,md', '文件类型', 'input', NULL, 0, NULL);
INSERT INTO `eb_system_config` VALUES (7, 2, 'upload_allow_image', 'jpg,jpeg,png,gif,svg,bmp', '图片类型', 'input', NULL, 0, NULL);
INSERT INTO `eb_system_config` VALUES (8, 2, 'upload_mode', '1', '上传模式', 'select', '[{\"label\":\"本地上传\",\"value\":\"1\"},{\"label\":\"阿里云OSS\",\"value\":\"2\"},{\"label\":\"七牛云\",\"value\":\"3\"},{\"label\":\"腾讯云COS\",\"value\":\"4\"}]', 99, NULL);
INSERT INTO `eb_system_config` VALUES (10, 2, 'upload_size', '5242880', '上传大小', 'input', NULL, 88, '单位Byte,1MB=1024*1024Byte');

-- ----------------------------
-- Table structure for eb_system_config_group
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_config_group`;
CREATE TABLE `eb_system_config_group`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(50) NULL DEFAULT NULL COMMENT '字典名称',
  `code` varchar(100) NULL DEFAULT NULL COMMENT '字典标示',
  `remark` varchar(255) NULL DEFAULT NULL COMMENT '备注',
  `created_by` int(11) NULL DEFAULT NULL COMMENT '创建人',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新人',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 COMMENT = '参数配置分组表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_config_group
-- ----------------------------
INSERT INTO `eb_system_config_group` VALUES (1, '站点配置', 'site_config', NULL, 1, 1, '2021-11-23 10:49:29', '2021-11-23 10:49:29', NULL);
INSERT INTO `eb_system_config_group` VALUES (2, '上传配置', 'upload_config', NULL, 1, 1, '2021-11-23 10:49:29', '2021-11-23 10:49:29', NULL);

-- ----------------------------
-- Table structure for eb_system_crontab
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_crontab`;
CREATE TABLE `eb_system_crontab`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(100) NULL DEFAULT NULL COMMENT '任务名称',
  `type` smallint(6) NULL DEFAULT 4 COMMENT '任务类型 (1 command, 2 class, 3 url, 4 eval)',
  `target` varchar(500) NULL DEFAULT NULL COMMENT '调用任务字符串',
  `parameter` varchar(1000) NULL DEFAULT NULL COMMENT '调用任务参数',
  `rule` varchar(32) NULL DEFAULT NULL COMMENT '任务执行表达式',
  `singleton` smallint(6) NULL DEFAULT 1 COMMENT '是否单次执行 (1 是 2 不是)',
  `status` smallint(6) NULL DEFAULT 1 COMMENT '状态 (1正常 2停用)',
  `remark` varchar(255) NULL DEFAULT NULL COMMENT '备注',
  `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 COMMENT = '定时任务信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_crontab
-- ----------------------------
INSERT INTO `eb_system_crontab` VALUES (1, '访问官网', 1, 'https://saithink.top', NULL, '0 0 8 * * *', 2, 1, NULL, 1, 1, '2024-01-20 14:21:11', '2024-01-20 15:26:41', NULL);
INSERT INTO `eb_system_crontab` VALUES (2, '登录gitee', 2, 'https://gitee.com/check_user_login', '{\"user_login\": \"saiadmin\"}', '0 0 10 * * *', 2, 1, NULL, 1, 1, '2024-01-20 14:31:51', '2024-01-20 15:21:33', NULL);
INSERT INTO `eb_system_crontab` VALUES (3, '定时执行任务', 3, '\\plugin\\saiadmin\\process\\Task', '{\"type\":\"1\"}', '0 0 12 * * *', 2, 1, NULL, 1, 1, '2024-01-20 14:38:03', '2024-01-20 15:21:42', NULL);

-- ----------------------------
-- Table structure for eb_system_crontab_log
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_crontab_log`;
CREATE TABLE `eb_system_crontab_log`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `crontab_id` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '任务ID',
  `name` varchar(255) NULL DEFAULT NULL COMMENT '任务名称',
  `target` varchar(500) NULL DEFAULT NULL COMMENT '任务调用目标字符串',
  `parameter` varchar(1000) NULL DEFAULT NULL COMMENT '任务调用参数',
  `exception_info` varchar(2000) NULL DEFAULT NULL COMMENT '异常信息',
  `status` smallint(6) NULL DEFAULT 1 COMMENT '执行状态 (1成功 2失败)',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 COMMENT = '定时任务执行日志表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_crontab_log
-- ----------------------------

-- ----------------------------
-- Table structure for eb_system_dept
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_dept`;
CREATE TABLE `eb_system_dept`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `parent_id` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '父ID',
  `level` varchar(500) NULL DEFAULT NULL COMMENT '组级集合',
  `name` varchar(30) NULL DEFAULT NULL COMMENT '部门名称',
  `leader` varchar(20) NULL DEFAULT NULL COMMENT '负责人',
  `phone` varchar(11) NULL DEFAULT NULL COMMENT '联系电话',
  `status` smallint(6) NULL DEFAULT 1 COMMENT '状态 (1正常 2停用)',
  `sort` smallint(5) UNSIGNED NULL DEFAULT 0 COMMENT '排序',
  `remark` varchar(255) NULL DEFAULT NULL COMMENT '备注',
  `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `parent_id`(`parent_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 COMMENT = '部门信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_dept
-- ----------------------------
INSERT INTO `eb_system_dept` VALUES (1, 0, '0', '赛弟科技', '赛弟', '18888888888', 1, 1, NULL, 1, 1, '2023-10-24 12:00:00', '2023-10-24 12:00:00', NULL);
INSERT INTO `eb_system_dept` VALUES (2, 1, '0,1', '青岛分公司', NULL, NULL, 1, 1, NULL, 1, 1, '2023-10-24 12:00:00', '2023-10-24 12:00:00', NULL);
INSERT INTO `eb_system_dept` VALUES (3, 1, '0,1', '洛阳总公司', NULL, NULL, 1, 1, NULL, 1, 1, '2023-10-24 12:00:00', '2023-10-24 12:00:00', NULL);
INSERT INTO `eb_system_dept` VALUES (4, 2, '0,1,2', '市场部门', NULL, NULL, 1, 1, NULL, 1, 1, '2023-10-24 12:00:00', '2023-10-24 12:00:00', NULL);
INSERT INTO `eb_system_dept` VALUES (5, 2, '0,1,2', '财务部门', NULL, NULL, 1, 1, NULL, 1, 1, '2023-10-24 12:00:00', '2023-10-24 12:00:00', NULL);
INSERT INTO `eb_system_dept` VALUES (6, 3, '0,1,3', '研发部门', NULL, NULL, 1, 1, NULL, 1, 1, '2023-10-24 12:00:00', '2023-10-24 12:00:00', NULL);
INSERT INTO `eb_system_dept` VALUES (7, 3, '0,1,3', '市场部门', NULL, NULL, 1, 1, NULL, 1, 1, '2023-10-24 12:00:00', '2023-10-24 12:00:00', NULL);

-- ----------------------------
-- Table structure for eb_system_dept_leader
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_dept_leader`;
CREATE TABLE `eb_system_dept_leader`  (
  `dept_id` int(11) UNSIGNED NOT NULL COMMENT '部门主键',
  `user_id` int(11) UNSIGNED NOT NULL COMMENT '角色主键',
  PRIMARY KEY (`user_id`, `dept_id`) USING BTREE
) ENGINE = InnoDB COMMENT = '部门领导关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_dept_leader
-- ----------------------------

-- ----------------------------
-- Table structure for eb_system_dict_data
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_dict_data`;
CREATE TABLE `eb_system_dict_data`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `type_id` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '字典类型ID',
  `label` varchar(50) NULL DEFAULT NULL COMMENT '字典标签',
  `value` varchar(100) NULL DEFAULT NULL COMMENT '字典值',
  `code` varchar(100) NULL DEFAULT NULL COMMENT '字典标示',
  `sort` smallint(5) UNSIGNED NULL DEFAULT 0 COMMENT '排序',
  `status` smallint(6) NULL DEFAULT 1 COMMENT '状态 (1正常 2停用)',
  `remark` varchar(255) NULL DEFAULT NULL COMMENT '备注',
  `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `type_id`(`type_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 49 COMMENT = '字典数据表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_dict_data
-- ----------------------------
INSERT INTO `eb_system_dict_data` VALUES (1, 1, 'InnoDB', 'InnoDB', 'table_engine', 1, 1, NULL, 1, 1, '2021-06-27 00:37:11', '2023-12-06 21:54:25', NULL);
INSERT INTO `eb_system_dict_data` VALUES (2, 1, 'MyISAM', 'MyISAM', 'table_engine', 1, 1, NULL, 1, 1, '2021-06-27 00:37:21', '2023-11-16 11:51:35', NULL);
INSERT INTO `eb_system_dict_data` VALUES (3, 2, '本地存储', '1', 'upload_mode', 99, 1, NULL, 1, 1, '2021-06-27 13:33:43', '2021-06-27 13:33:43', NULL);
INSERT INTO `eb_system_dict_data` VALUES (4, 2, '阿里云OSS', '2', 'upload_mode', 98, 1, NULL, 1, 1, '2021-06-27 13:33:55', '2021-06-27 13:33:55', NULL);
INSERT INTO `eb_system_dict_data` VALUES (5, 2, '七牛云', '3', 'upload_mode', 97, 1, NULL, 1, 1, '2021-06-27 13:34:07', '2023-12-13 16:50:26', NULL);
INSERT INTO `eb_system_dict_data` VALUES (6, 2, '腾讯云COS', '4', 'upload_mode', 96, 1, NULL, 1, 1, '2021-06-27 13:34:19', '2023-12-13 16:47:34', NULL);
INSERT INTO `eb_system_dict_data` VALUES (7, 3, '正常', '1', 'data_status', 0, 1, '1为正常', 1, 1, '2021-06-27 13:36:51', '2021-06-27 13:37:01', NULL);
INSERT INTO `eb_system_dict_data` VALUES (8, 3, '停用', '2', 'data_status', 0, 1, '2为停用', 1, 1, '2021-06-27 13:37:10', '2021-06-27 13:37:10', NULL);
INSERT INTO `eb_system_dict_data` VALUES (9, 4, '统计页面', 'statistics', 'dashboard', 0, 1, '管理员用', 1, 1, '2021-08-09 12:53:53', '2023-11-16 11:39:17', NULL);
INSERT INTO `eb_system_dict_data` VALUES (10, 4, '工作台', 'work', 'dashboard', 0, 1, '员工使用', 1, 1, '2021-08-09 12:54:18', '2021-08-09 12:54:18', NULL);
INSERT INTO `eb_system_dict_data` VALUES (11, 5, '男', '1', 'sex', 0, 1, NULL, 1, 1, '2021-08-09 12:55:00', '2021-08-09 12:55:00', NULL);
INSERT INTO `eb_system_dict_data` VALUES (12, 5, '女', '2', 'sex', 0, 1, NULL, 1, 1, '2021-08-09 12:55:08', '2021-08-09 12:55:08', NULL);
INSERT INTO `eb_system_dict_data` VALUES (13, 5, '未知', '3', 'sex', 0, 1, NULL, 1, 1, '2021-08-09 12:55:16', '2021-08-09 12:55:16', NULL);
INSERT INTO `eb_system_dict_data` VALUES (22, 7, '通知', '1', 'backend_notice_type', 2, 1, NULL, 1, 1, '2021-11-11 17:29:27', '2021-11-11 17:30:51', NULL);
INSERT INTO `eb_system_dict_data` VALUES (23, 7, '公告', '2', 'backend_notice_type', 1, 1, NULL, 1, 1, '2021-11-11 17:31:42', '2021-11-11 17:31:42', NULL);
INSERT INTO `eb_system_dict_data` VALUES (24, 8, '所有', 'A', 'request_mode', 5, 1, NULL, 1, 1, '2021-11-14 17:23:25', '2023-12-13 17:21:28', NULL);
INSERT INTO `eb_system_dict_data` VALUES (25, 8, 'GET', 'G', 'request_mode', 4, 1, NULL, 1, 1, '2021-11-14 17:23:45', '2023-12-13 17:21:28', NULL);
INSERT INTO `eb_system_dict_data` VALUES (26, 8, 'POST', 'P', 'request_mode', 3, 1, NULL, 1, 1, '2021-11-14 17:23:38', '2023-12-13 17:21:28', NULL);
INSERT INTO `eb_system_dict_data` VALUES (27, 8, 'PUT', 'U', 'request_mode', 2, 1, NULL, 1, 1, '2021-11-14 17:23:45', '2023-12-13 17:21:28', NULL);
INSERT INTO `eb_system_dict_data` VALUES (28, 8, 'DELETE', 'D', 'request_mode', 1, 1, NULL, 1, 1, '2021-11-14 17:23:45', '2023-12-13 17:21:28', NULL);
INSERT INTO `eb_system_dict_data` VALUES (39, 6, '通知', 'notice', 'queue_msg_type', 1, 1, NULL, 1, 1, '2021-12-25 18:30:31', '2024-01-20 14:42:55', '2024-01-20 14:42:55');
INSERT INTO `eb_system_dict_data` VALUES (40, 6, '公告', 'announcement', 'queue_msg_type', 2, 1, NULL, 1, 1, '2021-12-25 18:31:00', '2024-01-20 14:42:57', '2024-01-20 14:42:57');
INSERT INTO `eb_system_dict_data` VALUES (41, 6, '待办', 'todo', 'queue_msg_type', 3, 1, NULL, 1, 1, '2021-12-25 18:31:26', '2024-01-20 14:42:59', '2024-01-20 14:42:59');
INSERT INTO `eb_system_dict_data` VALUES (42, 6, '抄送我的', 'carbon_copy_mine', 'queue_msg_type', 4, 1, NULL, 1, 1, '2021-12-25 18:31:26', '2024-01-20 14:42:59', '2024-01-20 14:42:59');
INSERT INTO `eb_system_dict_data` VALUES (43, 6, '私信', 'private_message', 'queue_msg_type', 5, 1, NULL, 1, 1, '2021-12-25 18:31:26', '2024-01-20 14:42:59', '2024-01-20 14:42:59');
INSERT INTO `eb_system_dict_data` VALUES (44, 12, '图片', 'image', 'attachment_type', 10, 1, NULL, 1, 1, '2022-03-17 14:49:59', '2022-03-17 14:49:59', NULL);
INSERT INTO `eb_system_dict_data` VALUES (45, 12, '文档', 'text', 'attachment_type', 9, 1, NULL, 1, 1, '2022-03-17 14:50:20', '2022-03-17 14:50:49', NULL);
INSERT INTO `eb_system_dict_data` VALUES (46, 12, '音频', 'audio', 'attachment_type', 8, 1, NULL, 1, 1, '2022-03-17 14:50:37', '2022-03-17 14:50:52', NULL);
INSERT INTO `eb_system_dict_data` VALUES (47, 12, '视频', 'video', 'attachment_type', 7, 1, NULL, 1, 1, '2022-03-17 14:50:45', '2022-03-17 14:50:57', NULL);
INSERT INTO `eb_system_dict_data` VALUES (48, 12, '应用程序', 'application', 'attachment_type', 6, 1, NULL, 1, 1, '2022-03-17 14:50:52', '2022-03-17 14:50:59', NULL);

-- ----------------------------
-- Table structure for eb_system_dict_type
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_dict_type`;
CREATE TABLE `eb_system_dict_type`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(50) NULL DEFAULT NULL COMMENT '字典名称',
  `code` varchar(100) NULL DEFAULT NULL COMMENT '字典标示',
  `status` smallint(6) NULL DEFAULT 1 COMMENT '状态 (1正常 2停用)',
  `remark` varchar(255) NULL DEFAULT NULL COMMENT '备注',
  `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 COMMENT = '字典类型表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_dict_type
-- ----------------------------
INSERT INTO `eb_system_dict_type` VALUES (1, '数据表引擎', 'table_engine', 1, '数据表引擎字典', 1, 1, '2021-06-27 13:33:29', '2024-01-18 14:19:44', NULL);
INSERT INTO `eb_system_dict_type` VALUES (2, '存储模式', 'upload_mode', 1, '上传文件存储模式', 1, 1, '2021-06-27 13:33:29', '2021-06-27 13:33:11', NULL);
INSERT INTO `eb_system_dict_type` VALUES (3, '数据状态', 'data_status', 1, '通用数据状态', 1, 1, '2021-06-27 13:33:29', '2021-06-27 13:36:34', NULL);
INSERT INTO `eb_system_dict_type` VALUES (4, '后台首页', 'dashboard', 1, NULL, 1, 1, '2021-06-27 13:33:29', '2023-11-16 11:28:17', NULL);
INSERT INTO `eb_system_dict_type` VALUES (5, '性别', 'sex', 1, NULL, 1, 1, '2021-06-27 13:33:29', '2023-11-16 11:39:12', NULL);
INSERT INTO `eb_system_dict_type` VALUES (6, '消息类型', 'queue_msg_type', 1, NULL, 1, 1, '2021-06-27 13:33:29', '2024-01-20 14:43:06', '2024-01-20 14:43:06');
INSERT INTO `eb_system_dict_type` VALUES (7, '后台公告类型', 'backend_notice_type', 1, NULL, 1, 1, '2021-06-27 13:33:29', '2021-11-11 17:29:14', NULL);
INSERT INTO `eb_system_dict_type` VALUES (8, '请求方式', 'request_mode', 1, NULL, 1, 1, '2021-06-27 13:33:29', '2023-12-13 17:21:28', NULL);
INSERT INTO `eb_system_dict_type` VALUES (12, '附件类型', 'attachment_type', 1, NULL, 1, 1, '2021-06-27 13:33:29', '2022-03-17 14:49:23', NULL);

-- ----------------------------
-- Table structure for eb_system_login_log
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_login_log`;
CREATE TABLE `eb_system_login_log`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `username` varchar(20) NULL DEFAULT NULL COMMENT '用户名',
  `ip` varchar(45) NULL DEFAULT NULL COMMENT '登录IP地址',
  `ip_location` varchar(255) NULL DEFAULT NULL COMMENT 'IP所属地',
  `os` varchar(50) NULL DEFAULT NULL COMMENT '操作系统',
  `browser` varchar(50) NULL DEFAULT NULL COMMENT '浏览器',
  `status` smallint(6) NULL DEFAULT 1 COMMENT '登录状态 (1成功 2失败)',
  `message` varchar(50) NULL DEFAULT NULL COMMENT '提示消息',
  `login_time` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '登录时间',
  `remark` varchar(255) NULL DEFAULT NULL COMMENT '备注',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '更新时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `username`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 COMMENT = '登录日志表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_login_log
-- ----------------------------

-- ----------------------------
-- Table structure for eb_system_menu
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_menu`;
CREATE TABLE `eb_system_menu`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `parent_id` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '父ID',
  `level` varchar(500) NULL DEFAULT NULL COMMENT '组级集合',
  `name` varchar(50) NULL DEFAULT NULL COMMENT '菜单名称',
  `code` varchar(100) NULL DEFAULT NULL COMMENT '菜单标识代码',
  `icon` varchar(50) NULL DEFAULT NULL COMMENT '菜单图标',
  `route` varchar(200) NULL DEFAULT NULL COMMENT '路由地址',
  `component` varchar(255) NULL DEFAULT NULL COMMENT '组件路径',
  `redirect` varchar(255) NULL DEFAULT NULL COMMENT '跳转地址',
  `is_hidden` smallint(6) NULL DEFAULT 1 COMMENT '是否隐藏 (1是 2否)',
  `type` char(1) NULL DEFAULT '' COMMENT '菜单类型, (M菜单 B按钮 L链接 I iframe)',
  `status` smallint(6) NULL DEFAULT 1 COMMENT '状态 (1正常 2停用)',
  `sort` smallint(5) UNSIGNED NULL DEFAULT 0 COMMENT '排序',
  `remark` varchar(255) NULL DEFAULT NULL COMMENT '备注',
  `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4620 COMMENT = '菜单信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_menu
-- ----------------------------
INSERT INTO `eb_system_menu` VALUES (1000, 0, '0', '权限', 'permission', 'ma-icon-permission', 'permission', '', NULL, 2, 'M', 1, 99, NULL, 1, 1, '2021-07-25 18:48:47', '2023-11-14 23:13:42', NULL);
INSERT INTO `eb_system_menu` VALUES (1100, 1000, '0,1000', '用户管理', '/core/user', 'ma-icon-user', 'user', 'system/user/index', NULL, 2, 'M', 1, 99, NULL, 1, 1, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL);
INSERT INTO `eb_system_menu` VALUES (1101, 1100, '0,1000,1100', '用户列表', '/core/user/index', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL);
INSERT INTO `eb_system_menu` VALUES (1102, 1100, '0,1000,1100', '用户回收站列表', '/core/user/recycle', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL);
INSERT INTO `eb_system_menu` VALUES (1103, 1100, '0,1000,1100', '用户保存', '/core/user/save', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL);
INSERT INTO `eb_system_menu` VALUES (1104, 1100, '0,1000,1100', '用户更新', '/core/user/update', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL);
INSERT INTO `eb_system_menu` VALUES (1105, 1100, '0,1000,1100', '用户删除', '/core/user/destroy', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL);
INSERT INTO `eb_system_menu` VALUES (1106, 1100, '0,1000,1100', '用户读取', '/core/user/read', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL);
INSERT INTO `eb_system_menu` VALUES (1107, 1100, '0,1000,1100', '用户恢复', '/core/user/recovery', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL);
INSERT INTO `eb_system_menu` VALUES (1111, 1100, '0,1000,1100', '用户状态改变', '/core/user/changeStatus', '', NULL, '', NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 18:53:02', '2021-07-25 18:53:02', NULL);
INSERT INTO `eb_system_menu` VALUES (1112, 1100, '0,1000,1100', '用户初始化密码', '/core/user/initUserPassword', '', NULL, '', NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 18:55:55', '2021-07-25 18:55:55', NULL);
INSERT INTO `eb_system_menu` VALUES (1113, 1100, '0,1000,1100', '更新用户缓存', '/core/user/cache', '', NULL, '', NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-08-08 18:30:57', '2021-08-08 18:30:57', NULL);
INSERT INTO `eb_system_menu` VALUES (1114, 1100, '0,1000,1100', '设置用户首页', '/core/user/setHomePage', '', NULL, '', NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-08-08 18:34:30', '2021-08-08 18:34:30', NULL);
INSERT INTO `eb_system_menu` VALUES (1200, 1000, '0,1000', '菜单管理', '/core/menu', 'icon-menu', 'menu', 'system/menu/index', NULL, 2, 'M', 1, 96, NULL, 1, 1, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL);
INSERT INTO `eb_system_menu` VALUES (1201, 1200, '0,1000,1200', '菜单列表', '/core/menu/index', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL);
INSERT INTO `eb_system_menu` VALUES (1202, 1200, '0,1000,1200', '菜单回收站', '/core/menu/recycle', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL);
INSERT INTO `eb_system_menu` VALUES (1203, 1200, '0,1000,1200', '菜单保存', '/core/menu/save', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL);
INSERT INTO `eb_system_menu` VALUES (1204, 1200, '0,1000,1200', '菜单更新', '/core/menu/update', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL);
INSERT INTO `eb_system_menu` VALUES (1205, 1200, '0,1000,1200', '菜单删除', '/core/menu/destroy', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL);
INSERT INTO `eb_system_menu` VALUES (1206, 1200, '0,1000,1200', '菜单读取', '/core/menu/read', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL);
INSERT INTO `eb_system_menu` VALUES (1207, 1200, '0,1000,1200', '菜单恢复', '/core/menu/recovery', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL);
INSERT INTO `eb_system_menu` VALUES (1300, 1000, '0,1000', '部门管理', '/core/dept', 'ma-icon-dept', 'dept', 'system/dept/index', NULL, 2, 'M', 1, 97, NULL, 1, 1, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL);
INSERT INTO `eb_system_menu` VALUES (1301, 1300, '0,1000,1300', '部门列表', '/core/dept/index', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL);
INSERT INTO `eb_system_menu` VALUES (1302, 1300, '0,1000,1300', '部门回收站', '/core/dept/recycle', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL);
INSERT INTO `eb_system_menu` VALUES (1303, 1300, '0,1000,1300', '部门保存', '/core/dept/save', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL);
INSERT INTO `eb_system_menu` VALUES (1304, 1300, '0,1000,1300', '部门更新', '/core/dept/update', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL);
INSERT INTO `eb_system_menu` VALUES (1305, 1300, '0,1000,1300', '部门删除', '/core/dept/destroy', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL);
INSERT INTO `eb_system_menu` VALUES (1306, 1300, '0,1000,1300', '部门读取', '/core/dept/read', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL);
INSERT INTO `eb_system_menu` VALUES (1307, 1300, '0,1000,1300', '部门恢复', '/core/dept/recovery', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL);
INSERT INTO `eb_system_menu` VALUES (1311, 1300, '0,1000,1300', '部门状态改变', '/core/dept/changeStatus', '', NULL, '', NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-11-09 18:26:15', '2021-11-09 18:26:15', NULL);
INSERT INTO `eb_system_menu` VALUES (1400, 1000, '0,1000', '角色管理', '/core/role', 'ma-icon-role', 'role', 'system/role/index', NULL, 2, 'M', 1, 98, NULL, 1, 1, '2021-07-25 19:17:37', '2021-07-25 19:17:37', NULL);
INSERT INTO `eb_system_menu` VALUES (1401, 1400, '0,1000,1400', '角色列表', '/core/role/index', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 19:17:37', '2021-07-25 19:17:37', NULL);
INSERT INTO `eb_system_menu` VALUES (1402, 1400, '0,1000,1400', '角色回收站', '/core/role/recycle', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 19:17:38', '2021-07-25 19:17:38', NULL);
INSERT INTO `eb_system_menu` VALUES (1403, 1400, '0,1000,1400', '角色保存', '/core/role/save', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 19:17:38', '2021-07-25 19:17:38', NULL);
INSERT INTO `eb_system_menu` VALUES (1404, 1400, '0,1000,1400', '角色更新', '/core/role/update', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 19:17:38', '2021-07-25 19:17:38', NULL);
INSERT INTO `eb_system_menu` VALUES (1405, 1400, '0,1000,1400', '角色删除', '/core/role/destroy', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 19:17:38', '2021-07-25 19:17:38', NULL);
INSERT INTO `eb_system_menu` VALUES (1406, 1400, '0,1000,1400', '角色读取', '/core/role/read', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 19:17:38', '2021-07-25 19:17:38', NULL);
INSERT INTO `eb_system_menu` VALUES (1407, 1400, '0,1000,1400', '角色恢复', '/core/role/recovery', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 19:17:38', '2021-07-25 19:17:38', NULL);
INSERT INTO `eb_system_menu` VALUES (1411, 1400, '0,1000,1400', '角色状态改变', '/core/role/changeStatus', '', NULL, '', NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-30 11:21:24', '2021-07-30 11:21:24', NULL);
INSERT INTO `eb_system_menu` VALUES (1412, 1400, '0,1000,1400', '更新菜单权限', '/core/role/menuPermission', '', NULL, '', NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-08-09 11:52:33', '2021-08-09 11:52:33', NULL);
INSERT INTO `eb_system_menu` VALUES (1413, 1400, '0,1000,1400', '更新数据权限', '/core/role/dataPermission', '', NULL, '', NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-08-09 11:52:52', '2021-08-09 11:52:52', NULL);
INSERT INTO `eb_system_menu` VALUES (1500, 1000, '0,1000', '岗位管理', '/core/post', 'ma-icon-post', 'post', 'system/post/index', NULL, 2, 'M', 1, 0, NULL, 1, 1, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL);
INSERT INTO `eb_system_menu` VALUES (1501, 1500, '0,1000,1500', '岗位列表', '/core/post/index', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL);
INSERT INTO `eb_system_menu` VALUES (1502, 1500, '0,1000,1500', '岗位回收站', '/core/post/recycle', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL);
INSERT INTO `eb_system_menu` VALUES (1503, 1500, '0,1000,1500', '岗位保存', '/core/post/save', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL);
INSERT INTO `eb_system_menu` VALUES (1504, 1500, '0,1000,1500', '岗位更新', '/core/post/update', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL);
INSERT INTO `eb_system_menu` VALUES (1505, 1500, '0,1000,1500', '岗位删除', '/core/post/destroy', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL);
INSERT INTO `eb_system_menu` VALUES (1506, 1500, '0,1000,1500', '岗位读取', '/core/post/read', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL);
INSERT INTO `eb_system_menu` VALUES (1507, 1500, '0,1000,1500', '岗位恢复', '/core/post/recovery', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL);
INSERT INTO `eb_system_menu` VALUES (1511, 1500, '0,1000,1500', '岗位状态改变', '/core/post/changeStatus', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-11-09 18:26:15', '2021-11-09 18:26:15', NULL);
INSERT INTO `eb_system_menu` VALUES (1512, 1500, '0,1000,1500', '岗位导入', '/core/post/import', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-31 17:17:03', '2021-07-31 17:17:03', NULL);
INSERT INTO `eb_system_menu` VALUES (1513, 1500, '0,1000,1500', '岗位导出', '/core/post/export', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-31 17:17:03', '2021-07-31 17:17:03', NULL);
INSERT INTO `eb_system_menu` VALUES (2000, 0, '0', '数据', 'dataCenter', 'icon-storage', 'dataCenter', '', NULL, 2, 'M', 1, 98, NULL, 1, 1, '2021-07-31 17:17:03', '2021-07-31 17:17:03', NULL);
INSERT INTO `eb_system_menu` VALUES (2100, 2000, '0,2000', '数据字典', '/core/dictType', 'ma-icon-dict', 'dict', 'system/dict/index', NULL, 2, 'M', 1, 99, NULL, 1, 1, '2021-07-31 18:33:45', '2021-07-31 18:33:45', NULL);
INSERT INTO `eb_system_menu` VALUES (2101, 2100, '0,2000,2100', '数据字典列表', '/core/dictType/index', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-31 18:33:45', '2021-07-31 18:33:45', NULL);
INSERT INTO `eb_system_menu` VALUES (2102, 2100, '0,2000,2100', '数据字典回收站', '/core/dictType/recycle', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-31 18:33:45', '2021-07-31 18:33:45', NULL);
INSERT INTO `eb_system_menu` VALUES (2103, 2100, '0,2000,2100', '数据字典保存', '/core/dictType/save', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-31 18:33:45', '2021-07-31 18:33:45', NULL);
INSERT INTO `eb_system_menu` VALUES (2104, 2100, '0,2000,2100', '数据字典更新', '/core/dictType/update', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-31 18:33:45', '2021-07-31 18:33:45', NULL);
INSERT INTO `eb_system_menu` VALUES (2105, 2100, '0,2000,2100', '数据字典删除', '/core/dictType/destroy', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-31 18:33:45', '2021-07-31 18:33:45', NULL);
INSERT INTO `eb_system_menu` VALUES (2106, 2100, '0,2000,2100', '数据字典读取', '/core/dictType/read', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-31 18:33:46', '2021-07-31 18:33:46', NULL);
INSERT INTO `eb_system_menu` VALUES (2107, 2100, '0,2000,2100', '数据字典恢复', '/core/dictType/recovery', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-31 18:33:46', '2021-07-31 18:33:46', NULL);
INSERT INTO `eb_system_menu` VALUES (2112, 2100, '0,2000,2100', '字典状态改变', '/core/dictType/changeStatus', '', NULL, '', NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-11-09 18:26:15', '2021-11-09 18:26:15', NULL);
INSERT INTO `eb_system_menu` VALUES (2200, 2000, '0,2000', '附件管理', '/core/attachment', 'ma-icon-attach', 'attachment', 'system/attachment/index', NULL, 2, 'M', 1, 98, NULL, 1, 1, '2021-07-31 18:36:34', '2021-07-31 18:36:34', NULL);
INSERT INTO `eb_system_menu` VALUES (2201, 2300, '0,2000,2200', '附件删除', '/core/attachment/destroy', '', NULL, '', NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-31 18:37:20', '2021-07-31 18:37:20', NULL);
INSERT INTO `eb_system_menu` VALUES (2202, 2200, '0,2000,2200', '附件列表', '/core/attachment/index', '', NULL, '', NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-31 18:38:05', '2021-07-31 18:38:05', NULL);
INSERT INTO `eb_system_menu` VALUES (2203, 2200, '0,2000,2200', '附件回收站', '/core/attachment/recycle', '', NULL, '', NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-31 18:38:57', '2021-07-31 18:38:57', NULL);
INSERT INTO `eb_system_menu` VALUES (2204, 2200, '0,2000,2200', '附件恢复', '/core/attachment/recovery', '', NULL, '', NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-31 18:40:44', '2021-07-31 18:40:44', NULL);
INSERT INTO `eb_system_menu` VALUES (2300, 2000, '0,2000', '数据表维护', '/core/dataMaintain', 'ma-icon-db', 'dataMaintain', 'system/dataMaintain/index', NULL, 2, 'M', 1, 95, NULL, 1, 1, '2021-07-31 18:43:20', '2021-07-31 18:43:20', NULL);
INSERT INTO `eb_system_menu` VALUES (2301, 2300, '0,2000,2300', '数据表列表', '/core/dataMaintain/index', '', NULL, '', NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-31 18:44:03', '2021-07-31 18:44:03', NULL);
INSERT INTO `eb_system_menu` VALUES (2302, 2300, '0,2000,2300', '数据表详细', '/core/dataMaintain/detailed', '', NULL, '', NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-31 18:45:17', '2021-07-31 18:45:17', NULL);
INSERT INTO `eb_system_menu` VALUES (2303, 2300, '0,2000,2300', '数据表清理碎片', '/core/dataMaintain/fragment', '', NULL, '', NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-31 18:46:04', '2021-07-31 18:46:04', NULL);
INSERT INTO `eb_system_menu` VALUES (2304, 2300, '0,2000,2300', '数据表优化', '/core/dataMaintain/optimize', '', NULL, '', NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-31 18:46:31', '2021-07-31 18:46:31', NULL);
INSERT INTO `eb_system_menu` VALUES (2700, 2000, '0,2000', '系统公告', '/core/notice', 'icon-bulb', 'notice', 'system/notice/index', NULL, 2, 'M', 1, 94, NULL, 1, 1, '2021-12-25 18:10:20', '2021-12-25 18:10:20', NULL);
INSERT INTO `eb_system_menu` VALUES (2701, 2700, '0,2000,2700', '系统公告列表', '/core/notice/index', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-12-25 18:10:20', '2021-12-25 18:10:20', NULL);
INSERT INTO `eb_system_menu` VALUES (2702, 2700, '0,2000,2700', '系统公告回收站', '/core/notice/recycle', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-12-25 18:10:20', '2021-12-25 18:10:20', NULL);
INSERT INTO `eb_system_menu` VALUES (2703, 2700, '0,2000,2700', '系统公告保存', '/core/notice/save', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-12-25 18:10:20', '2021-12-25 18:10:20', NULL);
INSERT INTO `eb_system_menu` VALUES (2704, 2700, '0,2000,2700', '系统公告更新', '/core/notice/update', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-12-25 18:10:20', '2021-12-25 18:10:20', NULL);
INSERT INTO `eb_system_menu` VALUES (2705, 2700, '0,2000,2700', '系统公告删除', '/core/notice/destroy', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-12-25 18:10:20', '2021-12-25 18:10:20', NULL);
INSERT INTO `eb_system_menu` VALUES (2706, 2700, '0,2000,2700', '系统公告读取', '/core/notice/read', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-12-25 18:10:20', '2021-12-25 18:10:20', NULL);
INSERT INTO `eb_system_menu` VALUES (2707, 2700, '0,2000,2700', '系统公告恢复', '/core/notice/recovery', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-12-25 18:10:20', '2021-12-25 18:10:20', NULL);
INSERT INTO `eb_system_menu` VALUES (3000, 0, '0', '监控', 'monitor', 'icon-desktop', 'monitor', '', NULL, 2, 'M', 1, 97, NULL, 1, 1, '2021-07-31 18:49:24', '2021-07-31 18:49:24', NULL);
INSERT INTO `eb_system_menu` VALUES (3200, 3000, '0,3000', '服务监控', '/core/system/monitor', 'icon-thunderbolt', 'server', 'system/monitor/server/index', NULL, 2, 'M', 1, 99, NULL, 1, 1, '2021-07-31 18:52:46', '2021-07-31 18:52:46', NULL);
INSERT INTO `eb_system_menu` VALUES (3300, 3000, '0,3000', '日志监控', 'logs', 'icon-book', 'logs', '', NULL, 2, 'M', 1, 95, NULL, 1, 1, '2021-07-31 18:54:01', '2021-07-31 18:54:01', NULL);
INSERT INTO `eb_system_menu` VALUES (3400, 3300, '0,3000,3200', '登录日志', '/core/logs/getOperLogPageList', 'icon-idcard', 'loginLog', 'system/logs/loginLog', NULL, 2, 'M', 1, 0, NULL, 1, 1, '2021-07-31 18:54:55', '2021-07-31 18:54:55', NULL);
INSERT INTO `eb_system_menu` VALUES (3401, 3400, '0,3000,3200,3300', '登录日志删除', '/core/logs/deleteOperLog', '', NULL, '', NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-31 18:56:43', '2021-07-31 18:56:43', NULL);
INSERT INTO `eb_system_menu` VALUES (3500, 3300, '0,3000,3200', '操作日志', '/core/logs/getOperLogPageList', 'icon-robot', 'operLog', 'system/logs/operLog', NULL, 2, 'M', 1, 0, NULL, 1, 1, '2021-07-31 18:55:40', '2021-07-31 18:55:40', NULL);
INSERT INTO `eb_system_menu` VALUES (3501, 3500, '0,3000,3200,3400', '操作日志删除', '/core/logs/deleteOperLog', '', NULL, '', NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-31 18:56:19', '2021-07-31 18:56:19', NULL);
INSERT INTO `eb_system_menu` VALUES (4000, 0, '0', '工具', 'devTools', 'ma-icon-tool', 'devTools', '', NULL, 2, 'M', 1, 95, NULL, 1, 1, '2021-07-31 19:03:32', '2021-07-31 19:03:32', NULL);
INSERT INTO `eb_system_menu` VALUES (4200, 4000, '0,4000', '代码生成器', '/tool/code', 'ma-icon-code', 'code', 'setting/code/index', NULL, 2, 'M', 1, 98, NULL, 1, 1, '2021-07-31 19:36:17', '2021-07-31 19:36:17', NULL);
INSERT INTO `eb_system_menu` VALUES (4400, 4000, '0,4000', '定时任务', '/core/crontab', 'icon-schedule', 'crontab', 'setting/crontab/index', '', 2, 'M', 1, 0, NULL, 1, 1, '2021-07-31 19:47:49', '2021-07-31 19:47:49', NULL);
INSERT INTO `eb_system_menu` VALUES (4401, 4400, '0,4000,4400', '定时任务列表', '/core/crontab/index', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-31 19:47:49', '2021-07-31 19:47:49', NULL);
INSERT INTO `eb_system_menu` VALUES (4402, 4400, '0,4000,4400', '定时任务保存', '/core/crontab/save', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-31 19:47:49', '2021-07-31 19:47:49', NULL);
INSERT INTO `eb_system_menu` VALUES (4403, 4400, '0,4000,4400', '定时任务更新', '/core/crontab/update', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-31 19:47:49', '2021-07-31 19:47:49', NULL);
INSERT INTO `eb_system_menu` VALUES (4404, 4400, '0,4000,4400', '定时任务删除', '/core/crontab/destroy', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-31 19:47:49', '2021-07-31 19:47:49', NULL);
INSERT INTO `eb_system_menu` VALUES (4405, 4400, '0,4000,4400', '定时任务读取', '/core/crontab/read', NULL, NULL, NULL, NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-07-31 19:47:49', '2021-07-31 19:47:49', NULL);
INSERT INTO `eb_system_menu` VALUES (4408, 4400, '0,4000,4400', '定时任务执行', '/core/crontab/run', '', NULL, '', NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-08-07 23:44:06', '2021-08-07 23:44:06', NULL);
INSERT INTO `eb_system_menu` VALUES (4409, 4400, '0,4000,4400', '定时任务日志删除', '/core/crontab/deleteLog', '', NULL, '', NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-12-06 22:06:12', '2021-12-06 22:06:12', NULL);
INSERT INTO `eb_system_menu` VALUES (4500, 0, '0', '系统设置', '/core/config', 'icon-settings', 'system', 'setting/config/index', '', 2, 'M', 1, 0, NULL, 1, 1, '2021-07-31 19:58:57', '2023-12-13 14:49:47', NULL);
INSERT INTO `eb_system_menu` VALUES (4502, 4500, '0,4500', '配置列表', '/core/config/index', '', NULL, '', NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-08-10 13:09:18', '2021-08-10 13:09:18', NULL);
INSERT INTO `eb_system_menu` VALUES (4504, 4500, '0,4500', '新增配置 ', '/core/config/save', '', NULL, '', NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-08-10 13:11:56', '2021-08-10 13:11:56', NULL);
INSERT INTO `eb_system_menu` VALUES (4505, 4500, '0,4500', '更新配置', '/core/config/update', '', NULL, '', NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-08-10 13:12:25', '2021-08-10 13:12:25', NULL);
INSERT INTO `eb_system_menu` VALUES (4506, 4500, '0,4500', '删除配置', '/core/config/destroy', '', NULL, '', NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-08-10 13:13:33', '2021-08-10 13:13:33', NULL);
INSERT INTO `eb_system_menu` VALUES (4507, 4500, '0,4500', '清除配置缓存', '/core/config/clearCache', '', NULL, '', NULL, 1, 'B', 1, 0, NULL, 1, 1, '2021-08-10 13:13:59', '2021-08-10 13:13:59', NULL);
INSERT INTO `eb_system_menu` VALUES (4602, 0, '0', '信息管理', 'cms', 'IconApps', 'cms', NULL, NULL, 2, 'M', 1, 1, NULL, 1, 1, '2023-11-29 17:36:37', '2023-11-29 17:36:37', NULL);
INSERT INTO `eb_system_menu` VALUES (4604, 4602, '0,4602', '文章管理', '/news/article', 'icon-home', 'article', 'news/article/index', NULL, 2, 'M', 1, 0, NULL, 1, 1, '2023-11-30 23:08:38', '2023-11-30 23:08:38', NULL);
INSERT INTO `eb_system_menu` VALUES (4605, 4604, '0,4602,4604', '文章管理列表', '/news/article/index', NULL, NULL, NULL, NULL, 2, 'B', 1, 0, NULL, 1, 1, '2023-11-30 23:08:38', '2023-11-30 23:08:38', NULL);
INSERT INTO `eb_system_menu` VALUES (4606, 4604, '0,4602,4604', '文章管理保存', '/news/article/save', NULL, NULL, NULL, NULL, 2, 'B', 1, 0, NULL, 1, 1, '2023-11-30 23:08:38', '2023-11-30 23:08:38', NULL);
INSERT INTO `eb_system_menu` VALUES (4607, 4604, '0,4602,4604', '文章管理更新', '/news/article/update', NULL, NULL, NULL, NULL, 2, 'B', 1, 0, NULL, 1, 1, '2023-11-30 23:08:38', '2023-11-30 23:08:38', NULL);
INSERT INTO `eb_system_menu` VALUES (4608, 4604, '0,4602,4604', '文章管理读取', '/news/article/read', NULL, NULL, NULL, NULL, 2, 'B', 1, 0, NULL, 1, 1, '2023-11-30 23:08:38', '2023-11-30 23:08:38', NULL);
INSERT INTO `eb_system_menu` VALUES (4609, 4604, '0,4602,4604', '文章管理删除', '/news/article/destroy', NULL, NULL, NULL, NULL, 2, 'B', 1, 0, NULL, 1, 1, '2023-11-30 23:08:38', '2023-11-30 23:08:38', NULL);
INSERT INTO `eb_system_menu` VALUES (4610, 4604, '0,4602,4604', '文章管理回收', '/news/article/recycle', NULL, NULL, NULL, NULL, 2, 'B', 1, 0, NULL, 1, 1, '2023-11-30 23:08:38', '2023-11-30 23:08:38', NULL);
INSERT INTO `eb_system_menu` VALUES (4611, 4604, '0,4602,4604', '文章管理恢复', '/news/article/recovery', NULL, NULL, NULL, NULL, 2, 'B', 1, 0, NULL, 1, 1, '2023-11-30 23:08:38', '2023-11-30 23:08:38', NULL);
INSERT INTO `eb_system_menu` VALUES (4612, 4602, '0,4602', '文章分类', '/news/category', 'icon-home', 'category', 'news/category/index', NULL, 2, 'M', 1, 0, NULL, 1, 1, '2023-11-30 23:27:03', '2023-11-30 23:27:03', NULL);
INSERT INTO `eb_system_menu` VALUES (4613, 4612, '0,4602,4612', '文章分类列表', '/news/category/index', NULL, NULL, NULL, NULL, 2, 'B', 1, 0, NULL, 1, 1, '2023-11-30 23:27:03', '2023-11-30 23:27:03', NULL);
INSERT INTO `eb_system_menu` VALUES (4614, 4612, '0,4602,4612', '文章分类保存', '/news/category/save', NULL, NULL, NULL, NULL, 2, 'B', 1, 0, NULL, 1, 1, '2023-11-30 23:27:03', '2023-11-30 23:27:03', NULL);
INSERT INTO `eb_system_menu` VALUES (4615, 4612, '0,4602,4612', '文章分类更新', '/news/category/update', NULL, NULL, NULL, NULL, 2, 'B', 1, 0, NULL, 1, 1, '2023-11-30 23:27:04', '2023-11-30 23:27:04', NULL);
INSERT INTO `eb_system_menu` VALUES (4616, 4612, '0,4602,4612', '文章分类读取', '/news/category/read', NULL, NULL, NULL, NULL, 2, 'B', 1, 0, NULL, 1, 1, '2023-11-30 23:27:04', '2023-11-30 23:27:04', NULL);
INSERT INTO `eb_system_menu` VALUES (4617, 4612, '0,4602,4612', '文章分类删除', '/news/category/destroy', NULL, NULL, NULL, NULL, 2, 'B', 1, 0, NULL, 1, 1, '2023-11-30 23:27:04', '2023-11-30 23:27:04', NULL);
INSERT INTO `eb_system_menu` VALUES (4618, 4612, '0,4602,4612', '文章分类回收', '/news/category/recycle', NULL, NULL, NULL, NULL, 2, 'B', 1, 0, NULL, 1, 1, '2023-11-30 23:27:04', '2023-11-30 23:27:04', NULL);
INSERT INTO `eb_system_menu` VALUES (4619, 4612, '0,4602,4612', '文章分类恢复', '/news/category/recovery', NULL, NULL, NULL, NULL, 2, 'B', 1, 0, NULL, 1, 1, '2023-11-30 23:27:04', '2023-11-30 23:27:04', NULL);

-- ----------------------------
-- Table structure for eb_system_notice
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_notice`;
CREATE TABLE `eb_system_notice`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `message_id` int(11) NULL DEFAULT NULL COMMENT '消息ID',
  `title` varchar(255) NULL DEFAULT NULL COMMENT '标题',
  `type` smallint(6) NULL DEFAULT NULL COMMENT '公告类型(1通知 2公告)',
  `content` text NULL COMMENT '公告内容',
  `click_num` int(11) NULL DEFAULT 0 COMMENT '浏览次数',
  `remark` varchar(255) NULL DEFAULT NULL COMMENT '备注',
  `created_by` int(11) NULL DEFAULT NULL COMMENT '创建人',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新人',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `message_id`(`message_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 COMMENT = '系统公告表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_notice
-- ----------------------------
INSERT INTO `eb_system_notice` VALUES (1, NULL, '欢迎使用SaiAdmin', 1, '<p>saiadmin是一款基于vue3 + webman 的极速开发框架，前端开发采用JavaScript，后端采用PHP</p>', 0, NULL, 1, 1, '2024-01-20 15:55:36', '2024-01-20 15:55:36', NULL);

-- ----------------------------
-- Table structure for eb_system_oper_log
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_oper_log`;
CREATE TABLE `eb_system_oper_log`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `username` varchar(20) NULL DEFAULT NULL COMMENT '用户名',
  `app` varchar(50) NULL DEFAULT NULL COMMENT '应用名称',
  `method` varchar(20) NULL DEFAULT NULL COMMENT '请求方式',
  `router` varchar(500) NULL DEFAULT NULL COMMENT '请求路由',
  `service_name` varchar(30) NULL DEFAULT NULL COMMENT '业务名称',
  `ip` varchar(45) NULL DEFAULT NULL COMMENT '请求IP地址',
  `ip_location` varchar(255) NULL DEFAULT NULL COMMENT 'IP所属地',
  `request_data` text NULL COMMENT '请求数据',
  `remark` varchar(255) NULL DEFAULT NULL COMMENT '备注',
  `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '更新时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `username`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 COMMENT = '操作日志表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_oper_log
-- ----------------------------

-- ----------------------------
-- Table structure for eb_system_post
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_post`;
CREATE TABLE `eb_system_post`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(50) NULL DEFAULT NULL COMMENT '岗位名称',
  `code` varchar(100) NULL DEFAULT NULL COMMENT '岗位代码',
  `sort` smallint(5) UNSIGNED NULL DEFAULT 0 COMMENT '排序',
  `status` smallint(6) NULL DEFAULT 1 COMMENT '状态 (1正常 2停用)',
  `remark` varchar(255) NULL DEFAULT NULL COMMENT '备注',
  `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 COMMENT = '岗位信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_post
-- ----------------------------
INSERT INTO `eb_system_post` VALUES (1, '总经理', 'zongjingli', 1, 1, NULL, 1, 1, '2023-10-24 12:00:00', '2023-12-04 18:02:32', NULL);
INSERT INTO `eb_system_post` VALUES (2, '技术经理', 'jishujingli', 10, 1, NULL, 1, 1, '2023-10-24 12:00:00', '2023-11-15 10:29:47', NULL);
INSERT INTO `eb_system_post` VALUES (3, '销售经理', 'xiaoshoujingli', 5, 1, NULL, 1, 1, '2023-10-24 12:00:00', '2023-11-15 11:54:50', NULL);
INSERT INTO `eb_system_post` VALUES (4, '员工', 'yuangong', 1, 1, 'xxxxx', 1, 1, '2023-10-24 12:00:00', '2023-11-15 09:51:12', NULL);
INSERT INTO `eb_system_post` VALUES (5, '测试岗位', 'test', 15, 1, NULL, 1, 1, '2023-11-15 09:42:08', '2023-12-06 21:40:46', NULL);
INSERT INTO `eb_system_post` VALUES (6, '技术部', 'jishu', 100, 1, NULL, 1, 1, '2023-12-12 16:19:33', '2023-12-12 16:28:24', NULL);

-- ----------------------------
-- Table structure for eb_system_role
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_role`;
CREATE TABLE `eb_system_role`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(30) NULL DEFAULT NULL COMMENT '角色名称',
  `code` varchar(100) NULL DEFAULT NULL COMMENT '角色代码',
  `data_scope` smallint(6) NULL DEFAULT 1 COMMENT '数据范围(1:全部数据权限 2:自定义数据权限 3:本部门数据权限 4:本部门及以下数据权限 5:本人数据权限)',
  `status` smallint(6) NULL DEFAULT 1 COMMENT '状态 (1正常 2停用)',
  `sort` smallint(5) UNSIGNED NULL DEFAULT 0 COMMENT '排序',
  `remark` varchar(255) NULL DEFAULT NULL COMMENT '备注',
  `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 COMMENT = '角色信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_role
-- ----------------------------
INSERT INTO `eb_system_role` VALUES (1, '超级管理员（创始人）', 'superAdmin', 1, 1, 0, '系统内置角色，不可删除', 1, 1, '2023-10-24 12:00:00', '2023-10-24 12:00:00', NULL);
INSERT INTO `eb_system_role` VALUES (2, '总管理员', 'maxAdmin', 5, 1, 1, NULL, 1, 1, '2023-10-24 12:00:00', '2023-11-22 23:06:36', NULL);
INSERT INTO `eb_system_role` VALUES (3, '区域管理员', 'areaAdmin', 2, 1, 1, '', 1, 1, '2023-10-24 12:00:00', '2023-10-24 12:00:00', NULL);
INSERT INTO `eb_system_role` VALUES (4, '部门领导', 'deptLeader', 3, 1, 1, NULL, 1, 1, '2023-10-24 12:00:00', '2023-10-24 12:00:00', NULL);
INSERT INTO `eb_system_role` VALUES (5, '机构管理员', 'companyAdmin', 4, 1, 1, NULL, 1, 1, '2023-10-24 12:00:00', '2023-10-24 12:00:00', NULL);
INSERT INTO `eb_system_role` VALUES (6, '员工', 'staff', 5, 1, 1, NULL, 1, 1, '2023-10-24 12:00:00', '2023-12-12 16:11:12', '2023-12-12 16:11:12');

-- ----------------------------
-- Table structure for eb_system_role_dept
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_role_dept`;
CREATE TABLE `eb_system_role_dept`  (
  `role_id` int(11) UNSIGNED NOT NULL COMMENT '用户主键',
  `dept_id` int(11) UNSIGNED NOT NULL COMMENT '角色主键',
  PRIMARY KEY (`role_id`, `dept_id`) USING BTREE
) ENGINE = InnoDB COMMENT = '角色与部门关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_role_dept
-- ----------------------------
INSERT INTO `eb_system_role_dept` VALUES (2, 2);
INSERT INTO `eb_system_role_dept` VALUES (2, 4);
INSERT INTO `eb_system_role_dept` VALUES (2, 5);

-- ----------------------------
-- Table structure for eb_system_role_menu
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_role_menu`;
CREATE TABLE `eb_system_role_menu`  (
  `role_id` int(11) UNSIGNED NOT NULL COMMENT '角色主键',
  `menu_id` int(11) UNSIGNED NOT NULL COMMENT '菜单主键',
  PRIMARY KEY (`role_id`, `menu_id`) USING BTREE
) ENGINE = InnoDB COMMENT = '角色与菜单关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_role_menu
-- ----------------------------
INSERT INTO `eb_system_role_menu` VALUES (2, 1000);
INSERT INTO `eb_system_role_menu` VALUES (2, 1100);
INSERT INTO `eb_system_role_menu` VALUES (2, 1101);
INSERT INTO `eb_system_role_menu` VALUES (2, 1102);
INSERT INTO `eb_system_role_menu` VALUES (2, 1103);
INSERT INTO `eb_system_role_menu` VALUES (2, 1104);
INSERT INTO `eb_system_role_menu` VALUES (2, 1105);
INSERT INTO `eb_system_role_menu` VALUES (2, 1106);
INSERT INTO `eb_system_role_menu` VALUES (2, 1107);
INSERT INTO `eb_system_role_menu` VALUES (2, 1111);
INSERT INTO `eb_system_role_menu` VALUES (2, 1112);
INSERT INTO `eb_system_role_menu` VALUES (2, 1113);
INSERT INTO `eb_system_role_menu` VALUES (2, 1114);
INSERT INTO `eb_system_role_menu` VALUES (2, 1200);
INSERT INTO `eb_system_role_menu` VALUES (2, 1201);
INSERT INTO `eb_system_role_menu` VALUES (2, 1202);
INSERT INTO `eb_system_role_menu` VALUES (2, 1203);
INSERT INTO `eb_system_role_menu` VALUES (2, 1204);
INSERT INTO `eb_system_role_menu` VALUES (2, 1205);
INSERT INTO `eb_system_role_menu` VALUES (2, 1206);
INSERT INTO `eb_system_role_menu` VALUES (2, 1207);
INSERT INTO `eb_system_role_menu` VALUES (2, 1300);
INSERT INTO `eb_system_role_menu` VALUES (2, 1301);
INSERT INTO `eb_system_role_menu` VALUES (2, 1302);
INSERT INTO `eb_system_role_menu` VALUES (2, 1303);
INSERT INTO `eb_system_role_menu` VALUES (2, 1304);
INSERT INTO `eb_system_role_menu` VALUES (2, 1305);
INSERT INTO `eb_system_role_menu` VALUES (2, 1306);
INSERT INTO `eb_system_role_menu` VALUES (2, 1307);
INSERT INTO `eb_system_role_menu` VALUES (2, 1311);
INSERT INTO `eb_system_role_menu` VALUES (2, 1400);
INSERT INTO `eb_system_role_menu` VALUES (2, 1401);
INSERT INTO `eb_system_role_menu` VALUES (2, 1402);
INSERT INTO `eb_system_role_menu` VALUES (2, 1403);
INSERT INTO `eb_system_role_menu` VALUES (2, 1404);
INSERT INTO `eb_system_role_menu` VALUES (2, 1405);
INSERT INTO `eb_system_role_menu` VALUES (2, 1406);
INSERT INTO `eb_system_role_menu` VALUES (2, 1407);
INSERT INTO `eb_system_role_menu` VALUES (2, 1411);
INSERT INTO `eb_system_role_menu` VALUES (2, 1412);
INSERT INTO `eb_system_role_menu` VALUES (2, 1413);
INSERT INTO `eb_system_role_menu` VALUES (2, 1500);
INSERT INTO `eb_system_role_menu` VALUES (2, 1501);
INSERT INTO `eb_system_role_menu` VALUES (2, 1502);
INSERT INTO `eb_system_role_menu` VALUES (2, 1503);
INSERT INTO `eb_system_role_menu` VALUES (2, 1504);
INSERT INTO `eb_system_role_menu` VALUES (2, 1505);
INSERT INTO `eb_system_role_menu` VALUES (2, 1506);
INSERT INTO `eb_system_role_menu` VALUES (2, 1507);
INSERT INTO `eb_system_role_menu` VALUES (2, 1511);
INSERT INTO `eb_system_role_menu` VALUES (2, 1512);
INSERT INTO `eb_system_role_menu` VALUES (2, 1513);
INSERT INTO `eb_system_role_menu` VALUES (2, 2000);
INSERT INTO `eb_system_role_menu` VALUES (2, 2100);
INSERT INTO `eb_system_role_menu` VALUES (2, 2101);
INSERT INTO `eb_system_role_menu` VALUES (2, 2102);
INSERT INTO `eb_system_role_menu` VALUES (2, 2103);
INSERT INTO `eb_system_role_menu` VALUES (2, 2104);
INSERT INTO `eb_system_role_menu` VALUES (2, 2105);
INSERT INTO `eb_system_role_menu` VALUES (2, 2106);
INSERT INTO `eb_system_role_menu` VALUES (2, 2107);
INSERT INTO `eb_system_role_menu` VALUES (2, 2112);
INSERT INTO `eb_system_role_menu` VALUES (2, 2200);
INSERT INTO `eb_system_role_menu` VALUES (2, 2201);
INSERT INTO `eb_system_role_menu` VALUES (2, 2202);
INSERT INTO `eb_system_role_menu` VALUES (2, 2203);
INSERT INTO `eb_system_role_menu` VALUES (2, 2204);
INSERT INTO `eb_system_role_menu` VALUES (2, 2300);
INSERT INTO `eb_system_role_menu` VALUES (2, 2301);
INSERT INTO `eb_system_role_menu` VALUES (2, 2302);
INSERT INTO `eb_system_role_menu` VALUES (2, 2303);
INSERT INTO `eb_system_role_menu` VALUES (2, 2304);
INSERT INTO `eb_system_role_menu` VALUES (2, 2700);
INSERT INTO `eb_system_role_menu` VALUES (2, 2701);
INSERT INTO `eb_system_role_menu` VALUES (2, 2702);
INSERT INTO `eb_system_role_menu` VALUES (2, 2703);
INSERT INTO `eb_system_role_menu` VALUES (2, 2704);
INSERT INTO `eb_system_role_menu` VALUES (2, 2705);
INSERT INTO `eb_system_role_menu` VALUES (2, 2706);
INSERT INTO `eb_system_role_menu` VALUES (2, 2707);
INSERT INTO `eb_system_role_menu` VALUES (2, 3000);
INSERT INTO `eb_system_role_menu` VALUES (2, 3200);
INSERT INTO `eb_system_role_menu` VALUES (2, 3300);
INSERT INTO `eb_system_role_menu` VALUES (2, 3400);
INSERT INTO `eb_system_role_menu` VALUES (2, 3401);
INSERT INTO `eb_system_role_menu` VALUES (2, 3500);
INSERT INTO `eb_system_role_menu` VALUES (2, 3501);
INSERT INTO `eb_system_role_menu` VALUES (2, 4000);
INSERT INTO `eb_system_role_menu` VALUES (2, 4200);
INSERT INTO `eb_system_role_menu` VALUES (2, 4400);
INSERT INTO `eb_system_role_menu` VALUES (2, 4401);
INSERT INTO `eb_system_role_menu` VALUES (2, 4402);
INSERT INTO `eb_system_role_menu` VALUES (2, 4403);
INSERT INTO `eb_system_role_menu` VALUES (2, 4404);
INSERT INTO `eb_system_role_menu` VALUES (2, 4405);
INSERT INTO `eb_system_role_menu` VALUES (2, 4408);
INSERT INTO `eb_system_role_menu` VALUES (2, 4409);
INSERT INTO `eb_system_role_menu` VALUES (2, 4500);
INSERT INTO `eb_system_role_menu` VALUES (2, 4502);
INSERT INTO `eb_system_role_menu` VALUES (2, 4504);
INSERT INTO `eb_system_role_menu` VALUES (2, 4505);
INSERT INTO `eb_system_role_menu` VALUES (2, 4506);
INSERT INTO `eb_system_role_menu` VALUES (2, 4507);
INSERT INTO `eb_system_role_menu` VALUES (2, 4602);
INSERT INTO `eb_system_role_menu` VALUES (2, 4604);
INSERT INTO `eb_system_role_menu` VALUES (2, 4605);
INSERT INTO `eb_system_role_menu` VALUES (2, 4612);
INSERT INTO `eb_system_role_menu` VALUES (2, 4613);
INSERT INTO `eb_system_role_menu` VALUES (2, 4614);
INSERT INTO `eb_system_role_menu` VALUES (2, 4615);

-- ----------------------------
-- Table structure for eb_system_uploadfile
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_uploadfile`;
CREATE TABLE `eb_system_uploadfile`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `storage_mode` smallint(6) NULL DEFAULT 1 COMMENT '存储模式 (1 本地 2 阿里云 3 七牛云 4 腾讯云)',
  `origin_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '原文件名',
  `object_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '新文件名',
  `hash` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '文件hash',
  `mime_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '资源类型',
  `storage_path` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '存储目录',
  `suffix` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '文件后缀',
  `size_byte` bigint(20) NULL DEFAULT NULL COMMENT '字节数',
  `size_info` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '文件大小',
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'url地址',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '备注',
  `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `hash`(`hash`) USING BTREE,
  INDEX `storage_path`(`storage_path`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '上传文件信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_uploadfile
-- ----------------------------

-- ----------------------------
-- Table structure for eb_system_user
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_user`;
CREATE TABLE `eb_system_user`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户ID,主键',
  `username` varchar(20) NOT NULL COMMENT '用户名',
  `password` varchar(100) NOT NULL COMMENT '密码',
  `user_type` varchar(3) NULL DEFAULT '100' COMMENT '用户类型:(100系统用户)',
  `nickname` varchar(30) NULL DEFAULT NULL COMMENT '用户昵称',
  `phone` varchar(11) NULL DEFAULT NULL COMMENT '手机',
  `email` varchar(50) NULL DEFAULT NULL COMMENT '用户邮箱',
  `avatar` varchar(255) NULL DEFAULT NULL COMMENT '用户头像',
  `signed` varchar(255) NULL DEFAULT NULL COMMENT '个人签名',
  `dashboard` varchar(100) NULL DEFAULT NULL COMMENT '后台首页类型',
  `dept_id` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '部门ID',
  `status` smallint(6) NULL DEFAULT 1 COMMENT '状态 (1正常 2停用)',
  `login_ip` varchar(45) NULL DEFAULT NULL COMMENT '最后登陆IP',
  `login_time` datetime(0) NULL DEFAULT NULL COMMENT '最后登陆时间',
  `backend_setting` varchar(500) NULL DEFAULT NULL COMMENT '后台设置数据',
  `remark` varchar(255) NULL DEFAULT NULL COMMENT '备注',
  `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username`) USING BTREE,
  INDEX `dept_id`(`dept_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 COMMENT = '用户信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_user
-- ----------------------------
INSERT INTO `eb_system_user` VALUES (1, 'admin', '$2y$10$Q70WC9RBqMSS72DmppsbIuQtyAydXSmeD.Ae6W8YhmE/w15uLLpiy', '100', '祭道之上', '13888888888', 'admin@admin.com', 'http://localhost:8787/upload/image/20240120/65ab6c56850a.jpg', 'Today is very good！', 'statistics', NULL, 1, '127.0.0.1', '2024-01-20 16:02:22', '{\"mode\":\"light\",\"tag\":true,\"menuCollapse\":false,\"menuWidth\":230,\"layout\":\"classic\",\"skin\":\"mine\",\"i18n\":true,\"language\":\"zh_CN\",\"animation\":\"ma-slide-down\",\"color\":\"#165DFF\"}', NULL, 1, 1, NULL, '2024-01-20 16:02:23', NULL);
INSERT INTO `eb_system_user` VALUES (2, 'test1', '$2y$10$Q70WC9RBqMSS72DmppsbIuQtyAydXSmeD.Ae6W8YhmE/w15uLLpiy', '100', '小小测试员', '15822222222', 'test@saadmin.com', 'http://localhost:8787/app/manage/upload/image/20231116/655565cb38b4.jpg', NULL, 'work', NULL, 1, '127.0.0.1', '2024-01-20 15:59:17', 'null', NULL, 1, 1, '2023-11-15 14:30:14', '2024-01-20 15:59:18', NULL);
INSERT INTO `eb_system_user` VALUES (3, 'test2', '', '100', '酱油党', '13977777777', 'zhang@saadmin.com', 'http://localhost:8787/upload/image/20231222/65854211f2a6.jpg', NULL, 'statistics', NULL, 1, '127.0.0.1', '2023-11-22 22:47:26', 'null', '5566', 1, 1, '2023-11-15 16:27:27', '2023-12-22 16:00:24', NULL);

-- ----------------------------
-- Table structure for eb_system_user_post
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_user_post`;
CREATE TABLE `eb_system_user_post`  (
  `user_id` int(11) UNSIGNED NOT NULL COMMENT '用户主键',
  `post_id` int(11) UNSIGNED NOT NULL COMMENT '岗位主键',
  PRIMARY KEY (`user_id`, `post_id`) USING BTREE
) ENGINE = InnoDB COMMENT = '用户与岗位关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_user_post
-- ----------------------------
INSERT INTO `eb_system_user_post` VALUES (2, 3);
INSERT INTO `eb_system_user_post` VALUES (3, 3);

-- ----------------------------
-- Table structure for eb_system_user_role
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_user_role`;
CREATE TABLE `eb_system_user_role`  (
  `user_id` int(11) UNSIGNED NOT NULL COMMENT '用户主键',
  `role_id` int(11) UNSIGNED NOT NULL COMMENT '角色主键',
  PRIMARY KEY (`user_id`, `role_id`) USING BTREE
) ENGINE = InnoDB COMMENT = '用户与角色关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_user_role
-- ----------------------------
INSERT INTO `eb_system_user_role` VALUES (1, 1);
INSERT INTO `eb_system_user_role` VALUES (2, 2);
INSERT INTO `eb_system_user_role` VALUES (3, 2);

-- ----------------------------
-- Table structure for eb_tool_generate_columns
-- ----------------------------
DROP TABLE IF EXISTS `eb_tool_generate_columns`;
CREATE TABLE `eb_tool_generate_columns`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `table_id` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '所属表ID',
  `column_name` varchar(200) NULL DEFAULT NULL COMMENT '字段名称',
  `column_comment` varchar(255) NULL DEFAULT NULL COMMENT '字段注释',
  `column_type` varchar(50) NULL DEFAULT NULL COMMENT '字段类型',
  `default_value` varchar(50) NULL DEFAULT NULL COMMENT '默认值',
  `is_pk` smallint(6) NULL DEFAULT 1 COMMENT '1 非主键 2 主键',
  `is_required` smallint(6) NULL DEFAULT 1 COMMENT '1 非必填 2 必填',
  `is_insert` smallint(6) NULL DEFAULT 1 COMMENT '1 非插入字段 2 插入字段',
  `is_edit` smallint(6) NULL DEFAULT 1 COMMENT '1 非编辑字段 2 编辑字段',
  `is_list` smallint(6) NULL DEFAULT 1 COMMENT '1 非列表显示字段 2 列表显示字段',
  `is_query` smallint(6) NULL DEFAULT 1 COMMENT '1 非查询字段 2 查询字段',
  `query_type` varchar(100) NULL DEFAULT 'eq' COMMENT '查询方式 eq 等于, neq 不等于, gt 大于, lt 小于, like 范围',
  `view_type` varchar(100) NULL DEFAULT 'text' COMMENT '页面控件,text, textarea, password, select, checkbox, radio, date, upload, ma-upload(封装的上传控件)',
  `dict_type` varchar(200) NULL DEFAULT NULL COMMENT '字典类型',
  `allow_roles` varchar(255) NULL DEFAULT NULL COMMENT '允许查看该字段的角色',
  `options` varchar(1000) NULL DEFAULT NULL COMMENT '字段其他设置',
  `sort` tinyint(3) UNSIGNED NULL DEFAULT 0 COMMENT '排序',
  `remark` varchar(255) NULL DEFAULT NULL COMMENT '备注',
  `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 102 COMMENT = '代码生成业务字段表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_tool_generate_columns
-- ----------------------------
INSERT INTO `eb_tool_generate_columns` VALUES (57, 4, 'id', '编号', 'int', NULL, 2, 2, 1, 1, 1, 1, 'eq', 'input', NULL, NULL, NULL, 12, NULL, 1, 1, '2023-12-01 14:03:04', '2024-01-20 15:40:16', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (58, 4, 'parent_id', '父级ID', 'int', NULL, 1, 2, 2, 2, 1, 1, 'eq', 'treeSelect', NULL, NULL, NULL, 11, NULL, 1, 1, '2023-12-01 14:03:04', '2024-01-20 15:40:16', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (59, 4, 'category_name', '分类标题', 'varchar', NULL, 1, 2, 2, 2, 2, 2, 'like', 'input', NULL, NULL, NULL, 10, NULL, 1, 1, '2023-12-01 14:03:04', '2024-01-20 15:40:16', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (60, 4, 'describe', '分类简介', 'varchar', NULL, 1, 1, 2, 2, 2, 1, 'eq', 'textarea', NULL, NULL, NULL, 9, NULL, 1, 1, '2023-12-01 14:03:04', '2024-01-20 15:40:16', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (61, 4, 'image', '分类图片', 'varchar', NULL, 1, 1, 2, 2, 2, 1, 'eq', 'upload', NULL, NULL, '{\"type\":\"image\",\"returnType\":\"url\",\"multiple\":false}', 8, NULL, 1, 1, '2023-12-01 14:03:04', '2024-01-20 15:40:16', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (62, 4, 'sort', '排序', 'int', '100', 1, 1, 2, 2, 2, 1, 'eq', 'inputNumber', NULL, NULL, NULL, 7, NULL, 1, 1, '2023-12-01 14:03:04', '2024-01-20 15:40:16', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (63, 4, 'status', '状态', 'tinyint', '1', 1, 1, 2, 2, 2, 1, 'eq', 'radio', 'data_status', NULL, NULL, 6, NULL, 1, 1, '2023-12-01 14:03:04', '2024-01-20 15:40:16', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (64, 4, 'created_by', '创建者', 'int', NULL, 1, 1, 1, 1, 1, 1, 'eq', 'input', NULL, NULL, NULL, 5, NULL, 1, 1, '2023-12-01 14:03:04', '2024-01-20 15:40:16', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (65, 4, 'updated_by', '更新者', 'int', NULL, 1, 1, 1, 1, 1, 1, 'eq', 'input', NULL, NULL, NULL, 4, NULL, 1, 1, '2023-12-01 14:03:04', '2024-01-20 15:40:16', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (66, 4, 'create_time', '创建时间', 'datetime', NULL, 1, 1, 1, 1, 2, 2, 'between', 'date', NULL, NULL, '{\"mode\":\"date\",\"showTime\":true,\"range\":true}', 3, NULL, 1, 1, '2023-12-01 14:03:04', '2024-01-20 15:40:16', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (67, 4, 'update_time', '修改时间', 'datetime', NULL, 1, 1, 1, 1, 1, 1, 'between', 'date', NULL, NULL, '{\"mode\":\"date\",\"showTime\":true,\"range\":true}', 2, NULL, 1, 1, '2023-12-01 14:03:04', '2024-01-20 15:40:16', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (68, 3, 'id', '编号', 'int', NULL, 2, 2, 1, 1, 1, 1, 'eq', 'input', NULL, NULL, NULL, 18, NULL, 1, 1, '2023-12-01 14:03:06', '2024-01-20 15:41:16', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (69, 3, 'category_id', '文章分类', 'int', '0', 1, 2, 2, 2, 1, 2, 'eq', 'treeSelect', NULL, NULL, NULL, 17, NULL, 1, 1, '2023-12-01 14:03:06', '2024-01-20 15:41:16', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (70, 3, 'title', '文章标题', 'varchar', NULL, 1, 2, 2, 2, 2, 2, 'like', 'input', NULL, NULL, NULL, 16, NULL, 1, 1, '2023-12-01 14:03:06', '2024-01-20 15:41:16', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (71, 3, 'author', '文章作者', 'varchar', NULL, 1, 1, 2, 2, 2, 1, 'eq', 'input', NULL, NULL, NULL, 15, NULL, 1, 1, '2023-12-01 14:03:06', '2024-01-20 15:41:16', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (72, 3, 'image', '文章图片', 'varchar', NULL, 1, 1, 2, 2, 2, 1, 'eq', 'upload', NULL, NULL, '{\"type\":\"image\",\"returnType\":\"url\",\"multiple\":false}', 14, NULL, 1, 1, '2023-12-01 14:03:06', '2024-01-20 15:41:16', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (73, 3, 'describe', '文章简介', 'varchar', NULL, 1, 1, 2, 2, 2, 1, 'eq', 'textarea', NULL, NULL, '{\"collection\":[],\"onlyId\":true}', 13, NULL, 1, 1, '2023-12-01 14:03:06', '2024-01-20 15:41:16', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (74, 3, 'content', '文章内容', 'text', NULL, 1, 2, 2, 2, 1, 1, 'eq', 'editor', NULL, NULL, NULL, 12, NULL, 1, 1, '2023-12-01 14:03:06', '2024-01-20 15:41:16', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (75, 3, 'views', '浏览次数', 'int', '0', 1, 1, 2, 2, 2, 1, 'eq', 'inputNumber', NULL, NULL, NULL, 11, NULL, 1, 1, '2023-12-01 14:03:06', '2024-01-20 15:41:16', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (76, 3, 'sort', '排序', 'int', '100', 1, 1, 2, 2, 2, 1, 'eq', 'inputNumber', NULL, NULL, NULL, 10, NULL, 1, 1, '2023-12-01 14:03:06', '2024-01-20 15:41:16', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (77, 3, 'status', '状态', 'tinyint', '1', 1, 1, 2, 2, 2, 1, 'eq', 'switch', 'data_status', NULL, '{\"collection\":[],\"checkedValue\":1,\"uncheckedValue\":2}', 9, NULL, 1, 1, '2023-12-01 14:03:06', '2024-01-20 15:41:16', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (78, 3, 'is_link', '是否外链', 'tinyint', '2', 1, 1, 2, 2, 2, 1, 'eq', 'radio', NULL, NULL, '{\"collection\":[{\"label\":\"\\u662f\",\"value\":1},{\"label\":\"\\u5426\",\"value\":2}]}', 8, NULL, 1, 1, '2023-12-01 14:03:06', '2024-01-20 15:41:16', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (79, 3, 'link_url', '链接地址', 'varchar', NULL, 1, 1, 2, 2, 2, 1, 'eq', 'input', NULL, NULL, NULL, 7, NULL, 1, 1, '2023-12-01 14:03:06', '2024-01-20 15:41:16', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (80, 3, 'is_hot', '是否热门', 'tinyint', '2', 1, 1, 2, 2, 2, 1, 'eq', 'radio', NULL, NULL, '{\"collection\":[{\"label\":\"\\u662f\",\"value\":1},{\"label\":\"\\u5426\",\"value\":2}]}', 6, NULL, 1, 1, '2023-12-01 14:03:06', '2024-01-20 15:41:16', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (81, 3, 'created_by', '创建者', 'int', NULL, 1, 1, 1, 1, 1, 1, 'eq', 'input', NULL, NULL, NULL, 5, NULL, 1, 1, '2023-12-01 14:03:06', '2024-01-20 15:41:16', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (82, 3, 'updated_by', '更新者', 'int', NULL, 1, 1, 1, 1, 1, 1, 'eq', 'input', NULL, NULL, NULL, 4, NULL, 1, 1, '2023-12-01 14:03:06', '2024-01-20 15:41:16', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (83, 3, 'create_time', '创建时间', 'datetime', NULL, 1, 1, 1, 1, 2, 2, 'between', 'date', NULL, NULL, '{\"mode\":\"date\",\"showTime\":true,\"range\":true}', 3, NULL, 1, 1, '2023-12-01 14:03:06', '2024-01-20 15:41:16', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (84, 3, 'update_time', '修改时间', 'datetime', NULL, 1, 1, 1, 1, 1, 1, 'between', 'date', NULL, NULL, '{\"mode\":\"date\",\"showTime\":true,\"range\":true}', 2, NULL, 1, 1, '2023-12-01 14:03:06', '2024-01-20 15:41:16', NULL);

-- ----------------------------
-- Table structure for eb_tool_generate_tables
-- ----------------------------
DROP TABLE IF EXISTS `eb_tool_generate_tables`;
CREATE TABLE `eb_tool_generate_tables`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `table_name` varchar(200) NULL DEFAULT NULL COMMENT '表名称',
  `table_comment` varchar(500) NULL DEFAULT NULL COMMENT '表注释',
  `template` varchar(50) NULL DEFAULT NULL COMMENT '模板名称',
  `namespace` varchar(255) NULL DEFAULT NULL COMMENT '命名空间',
  `package_name` varchar(100) NULL DEFAULT NULL COMMENT '控制器包名',
  `business_name` varchar(50) NULL DEFAULT NULL COMMENT '业务名称',
  `class_name` varchar(50) NULL DEFAULT NULL COMMENT '类名称',
  `menu_name` varchar(100) NULL DEFAULT NULL COMMENT '生成菜单名',
  `belong_menu_id` int(11) NULL DEFAULT NULL COMMENT '所属菜单',
  `tpl_category` varchar(100) NULL DEFAULT NULL COMMENT '生成类型,single 单表CRUD,tree 树表CRUD,parent_sub父子表CRUD',
  `generate_type` smallint(6) NULL DEFAULT 1 COMMENT '1 压缩包下载 2 生成到模块',
  `generate_menus` varchar(255) NULL DEFAULT NULL COMMENT '生成菜单列表',
  `build_menu` smallint(6) NULL DEFAULT 1 COMMENT '是否构建菜单',
  `component_type` smallint(6) NULL DEFAULT 1 COMMENT '组件显示方式',
  `options` varchar(1500) NULL DEFAULT NULL COMMENT '其他业务选项',
  `remark` varchar(255) NULL DEFAULT NULL COMMENT '备注',
  `source` varchar(255) DEFAULT NULL COMMENT '数据源',
  `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
  `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 COMMENT = '代码生成业务表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_tool_generate_tables
-- ----------------------------
INSERT INTO `eb_tool_generate_tables` VALUES (3, 'eb_article', '文章表', 'app', 'cms', 'news', 'article', 'Article', '文章管理', 4602, 'single', 1, 'save,update,read,delete,recycle,recovery,changeStatus', 1, 1, '{\"relations\":[{\"name\":\"category\",\"type\":\"belongsTo\",\"model\":\"ArticleCategory\",\"foreignKey\":\"id\",\"localKey\":\"category_id\",\"table\":\"\"}],\"tree_id\":\"id\",\"tree_name\":\"category_name\",\"tree_parent_id\":\"parent_id\",\"tag_id\":\"10086\",\"tag_name\":\"文章管理\",\"tag_view_name\":\"id\"}', NULL, '', 1, 1, '2023-11-30 22:23:17', '2024-01-20 15:41:16', NULL);
INSERT INTO `eb_tool_generate_tables` VALUES (4, 'eb_article_category', '文章分类表', 'app', 'cms', 'news', 'category', 'ArticleCategory', '文章分类', 4602, 'tree', 1, 'save,update,read,delete,recycle,recovery,changeStatus', 1, 1, '{\"relations\":[],\"tree_id\":\"id\",\"tree_name\":\"category_name\",\"tree_parent_id\":\"parent_id\"}', NULL, '', 1, 1, '2023-11-30 22:23:17', '2024-01-20 15:40:16', NULL);

SET FOREIGN_KEY_CHECKS = 1;
