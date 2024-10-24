-- 1. eb_system_menu 添加is_layout字段
ALTER TABLE `eb_system_menu`
ADD COLUMN `is_layout` tinyint(1) UNSIGNED NULL DEFAULT '1' COMMENT '继承layout' AFTER `is_hidden`;
