-- 1. 删除现有的主键约束
ALTER TABLE `eb_system_dept_leader`
DROP PRIMARY KEY;
-- 2. 添加新列 `leader_id`
ALTER TABLE `eb_system_dept_leader`
ADD COLUMN `leader_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号' PRIMARY KEY FIRST;
-- 3. 添加索引
ALTER TABLE `eb_system_dept_leader`
ADD KEY `idx_dept_id` (`dept_id`) USING BTREE,
ADD KEY `idx_user_id` (`user_id`) USING BTREE;


-- 1. 删除现有的主键约束
ALTER TABLE `eb_system_role_dept`
DROP PRIMARY KEY;
-- 2. 添加新列 `id`
ALTER TABLE `eb_system_role_dept`
ADD COLUMN `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号' PRIMARY KEY FIRST;
-- 3. 添加索引
ALTER TABLE `eb_system_role_dept`
ADD KEY `idx_role_id` (`role_id`) USING BTREE,
ADD KEY `idx_dept_id` (`dept_id`) USING BTREE;


-- 1. 删除现有的主键约束
ALTER TABLE `eb_system_role_menu`
DROP PRIMARY KEY;
-- 2. 添加新列 `id`
ALTER TABLE `eb_system_role_menu`
ADD COLUMN `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号' PRIMARY KEY FIRST;
-- 3. 添加索引
ALTER TABLE `eb_system_role_menu`
ADD KEY `idx_role_id` (`role_id`) USING BTREE,
ADD KEY `idx_menu_id` (`menu_id`) USING BTREE;


-- 1. 删除现有的主键约束
ALTER TABLE `eb_system_user_post`
DROP PRIMARY KEY;
-- 2. 添加新列 `id`
ALTER TABLE `eb_system_user_post`
ADD COLUMN `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号' PRIMARY KEY FIRST;
-- 3. 添加索引
ALTER TABLE `eb_system_user_post`
ADD KEY `idx_user_id` (`user_id`) USING BTREE,
ADD KEY `idx_post_id` (`post_id`) USING BTREE;


-- 1. 删除现有的主键约束
ALTER TABLE `eb_system_user_role`
DROP PRIMARY KEY;
-- 2. 添加新列 `id`
ALTER TABLE `eb_system_user_role`
ADD COLUMN `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号' PRIMARY KEY FIRST;
-- 3. 添加索引
ALTER TABLE `eb_system_user_role`
ADD KEY `idx_user_id` (`user_id`) USING BTREE,
ADD KEY `idx_role_id` (`role_id`) USING BTREE;