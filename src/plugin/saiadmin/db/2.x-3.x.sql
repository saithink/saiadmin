# 在2.x的基础上升级，需要运行此SQL语句，如果直接装的3.x，则不需要运行此SQL语句
ALTER TABLE `eb_tool_generate_columns`
ADD COLUMN `is_sort` smallint(6) DEFAULT '1' COMMENT '1 非排序 2 排序';

ALTER TABLE `eb_tool_generate_tables`
ADD COLUMN `generate_model` smallint(6) DEFAULT '1' COMMENT '1 软删除 2 非软删除',
ADD COLUMN `form_width` int(11) DEFAULT '600' COMMENT '表单宽度',
ADD COLUMN `is_full` tinyint(1) DEFAULT '1' COMMENT '是否全屏';