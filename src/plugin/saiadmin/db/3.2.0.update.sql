-- 增加 亚马逊云 S3 存储配置

UPDATE `eb_system_config` SET `config_select_data` = '[{\"label\":\"本地上传\",\"value\":\"1\"},{\"label\":\"阿里云OSS\",\"value\":\"2\"},{\"label\":\"七牛云\",\"value\":\"3\"},{\"label\":\"腾讯云COS\",\"value\":\"4\"},{\"label\":\"亚马逊S3\",\"value\":\"5\"}]' WHERE `eb_system_config`.`id` = 8;

INSERT INTO `eb_system_config` VALUES (NULL, 2, 's3_key', '', 'key', 'input', '', 0, '');
INSERT INTO `eb_system_config` VALUES (NULL, 2, 's3_secret', '', 'secret', 'input', '', 0, '');
INSERT INTO `eb_system_config` VALUES (NULL, 2, 's3_bucket', '', 'bucket', 'input', '', 0, '');
INSERT INTO `eb_system_config` VALUES (NULL, 2, 's3_dirname', '', 'dirname', 'input', '', 0, '');
INSERT INTO `eb_system_config` VALUES (NULL, 2, 's3_domain', '', 'domain', 'input', '', 0, '');
INSERT INTO `eb_system_config` VALUES (NULL, 2, 's3_region', '', 'region', 'input', '', 0, '');
INSERT INTO `eb_system_config` VALUES (NULL, 2, 's3_version', '', 'version', 'input', '', 0, '');
INSERT INTO `eb_system_config` VALUES (NULL, 2, 's3_use_path_style_endpoint', '', 'path_style_endpoint', 'input', '', 0, '');
INSERT INTO `eb_system_config` VALUES (NULL, 2, 's3_endpoint', '', 'endpoint', 'input', '', 0, '');
INSERT INTO `eb_system_config` VALUES (NULL, 2, 's3_acl', '', 'acl', 'input', '', 0, '');

INSERT INTO `eb_system_dict_data` VALUES (NULL, 2, '亚马逊S3', '2', 'upload_mode', 95, 1, NULL, 1, 1, now(), now(), NULL);
