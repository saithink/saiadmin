<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
return [
	// 验证码存储模式
    'captcha' => [
        // 验证码存储模式 session或者cache
        'mode' => getenv('CAPTCHA_MODE'),
        // 验证码过期时间 (秒)
        'expire' => 300,
    ],

    // excel模板下载路径
    'template' => base_path(). '/plugin/saiadmin/public/template',

    // excel导出文件路径
    'export_path' => base_path() . '/plugin/saiadmin/public/export/',

    // 文件开启hash验证，开启后上传文件将会判断数据库中是否存在，如果存在直接获取
    'file_hash' => false,

    // 路由替换 同一个接口功能有可能有多个路由的，在此处配置，避免相同功能设置多个接口功能
    'route_replace' => [
        '/core/configGroup/index' => '/core/config/index',
        '/core/configGroup/save' => '/core/config/save',
        '/core/configGroup/update' => '/core/config/update',
        '/core/configGroup/destroy' => '/core/config/destroy',
        '/core/configGroup/read' => '/core/config/read',

        '/core/dictData/index' => '/core/dictType/index',
        '/core/dictData/save' => '/core/dictType/save',
        '/core/dictData/update' => '/core/dictType/update',
        '/core/dictData/destroy' => '/core/dictType/destroy',
        '/core/dictData/changeStatus' => '/core/dictType/changeStatus',

        '/core/dept/addLeader' => '/core/dept/leaders',
        '/core/dept/delLeader' => '/core/dept/leaders',

        '/tool/code/destroy' => '/tool/code/access',
        '/tool/code/save' => '/tool/code/access',
        '/tool/code/update' => '/tool/code/access',
        '/tool/code/read' => '/tool/code/access',
        '/tool/code/loadTable' => '/tool/code/access',
        '/tool/code/getTableColumns' => '/tool/code/access',
        '/tool/code/preview' => '/tool/code/access',
        '/tool/code/generate' => '/tool/code/access',
        '/tool/code/generateFile' => '/tool/code/access',
        '/tool/code/sync' => '/tool/code/access',

        '/tool/crontab/logPageList' => '/tool/crontab/index',
    ],

    // 用户信息缓存
    'user_cache' => [
        'prefix' => 'saiadmin:user_cache:info_',
        'expire' => 60 * 60 * 4,
        'dept' => 'saiadmin:user_cache:dept_',
        'role' => 'saiadmin:user_cache:role_',
        'post' => 'saiadmin:user_cache:post_',
    ],

    // 用户权限缓存
    'button_cache' => [
        'prefix' => 'saiadmin:button_cache:user_',
        'expire' => 60 * 60 * 2,
        'all' => 'saiadmin:button_cache:all',
        'role' => 'saiadmin:button_cache:role_',
        'tag' => 'saiadmin:button_cache',
    ],

    // 用户菜单缓存
    'menu_cache' => [
        'prefix' => 'saiadmin:menu_cache:user_',
        'expire' => 60 * 60 * 24 * 7,
        'tag' => 'saiadmin:menu_cache',
    ],

    // 字典缓存
    'dict_cache' => [
        'expire' => 60 * 60 * 24 * 365,
        'tag' => 'saiadmin:dict_cache',
    ],

    // 配置数据缓存
    'config_cache' => [
        'expire' => 60 * 60 * 24 * 365,
        'prefix' => 'saiadmin:config_cache:config_',
        'tag' => 'saiadmin:config_cache'
    ],
];
