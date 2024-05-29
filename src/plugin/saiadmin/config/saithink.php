<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
return [
    // 跨域配置
    'cross' => [
        // token信息
        'token_name' => 'Authori-zation',
        // 过期时间 (小时)
        'token_expire' => 6,
    ],
    // 中间件白名单
    'white_list' => [
        '/core/captcha',
        '/core/login',
    ],
    // 是否开启后端接口权限认证
    'server_auth' => true,
    // 缓存配置
    'cache' => [
        // 开启缓存
        'enable' => true,
        // 驱动 redis或者file
        'type' =>'file',
        // 缓存前缀
        'prefix' =>'saithink_',
    ],
	// 验证码存储模式
    'captcha' => [
        // 验证码存储模式 session或者redis
        'mode' => 'session',
        // 验证码过期时间 (秒)
        'expire' => 300,
    ],
    // excel模板下载路径
    'template' => base_path(). '/plugin/saiadmin/public/template'
];
