-- 1. eb_system_menu 添加is_layout字段
ALTER TABLE `eb_system_menu`
ADD COLUMN `is_layout` tinyint(1) UNSIGNED NULL DEFAULT '1' COMMENT '继承layout' AFTER `is_hidden`;

-- 2. eb_system_crontab 添加task_id字段
ALTER TABLE `eb_system_crontab`
ADD COLUMN `task_id` int(11) NULL DEFAULT 0 COMMENT 'crontab任务id' AFTER `status`;