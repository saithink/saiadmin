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
];
