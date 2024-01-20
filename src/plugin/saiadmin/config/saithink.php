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
    // 文件上传配置
    'upload' => [
        //上传文件大小
        'filesize' => 5242880,
        //上传文件后缀类型
        'fileExt' => ['jpg', 'jpeg', 'png', 'gif', 'mp3', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'zip', 'rar', 'mp4', 'pem', 'key'],
    ]
];
