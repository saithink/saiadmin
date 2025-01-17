-- 调整部门表字段

ALTER TABLE `eb_system_dept` 
DROP COLUMN `leader`,
DROP COLUMN `phone`;

-- 用户日志适配数据权限功能

ALTER TABLE `eb_system_login_log`
ADD COLUMN `created_by` int(11) NULL COMMENT '创建者' AFTER `remark`;
ADD COLUMN `updated_by` int(11) NULL COMMENT '更新者' AFTER `created_by`;