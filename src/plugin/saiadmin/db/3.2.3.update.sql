-- 修改文件hash索引改为normal

ALTER TABLE `eb_system_uploadfile`
DROP INDEX `hash`,
ADD INDEX `hash`(`hash`) USING BTREE;
