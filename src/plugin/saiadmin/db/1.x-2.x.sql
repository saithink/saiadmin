# 在1.x的基础上升级，需要运行此SQL语句，如果直接装的2.x，则不需要运行此SQL语句
ALTER TABLE `eb_system_menu`
ADD COLUMN `generate_id` int(11) DEFAULT '0' COMMENT '生成id',
ADD COLUMN `generate_key` varchar(255) DEFAULT NULL COMMENT '生成key';

ALTER TABLE `eb_tool_generate_tables`
ADD COLUMN `stub` varchar(255) DEFAULT 'saiadmin' COMMENT 'stub类型',
ADD COLUMN `generate_path` varchar(255) DEFAULT 'saiadmin-vue' COMMENT '前端根目录';