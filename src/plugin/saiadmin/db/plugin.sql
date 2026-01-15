-- ----------------------------
-- Records of sa_system_menu
-- ----------------------------
INSERT INTO `sa_system_menu` SELECT NULL, 0, '插件市场', 'Plugin', '', 2, '/plugin', '/plugin/saipackage/install/index', NULL, 'ri:apps-2-ai-line', 100, '', 2, 2, 2, 2, 2, 0, NULL, 1, NULL, 1, 1, '2026-01-01 00:00:00', '2026-01-01 00:00:00', NULL FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `sa_system_menu` WHERE `code` = 'Plugin' AND `create_time` = '2026-01-01 00:00:00' AND ISNULL(`delete_time`));
