<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
return [
    // 中间件白名单
    'white_list' => [
        '/core/captcha',
        '/core/login',
    ],
    // 是否开启后端接口权限认证
    'server_auth' => true,
	// 验证码存储模式
    'captcha' => [
        // 验证码存储模式 session或者redis
        'mode' => 'session',
        // 验证码过期时间 (秒)
        'expire' => 300,
    ],
    // excel模板下载路径
    'template' => base_path(). '/plugin/saiadmin/public/template',
    // 文件开启hash验证，开启后上传文件将会判断数据库中是否存在，如果存在直接获取
    'file_hash' => false,
];
