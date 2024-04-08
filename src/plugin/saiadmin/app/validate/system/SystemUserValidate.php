<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\validate\system;

use think\Validate;

/**
 * 用户信息验证器
 */
class SystemUserValidate extends Validate
{
    /**
     * 定义验证规则
     */
    protected $rule =   [
        'username' => 'require|max:16',
        'password' => 'require|min:6|max:16',
        'role_ids' => 'require',
    ];

    /**
     * 定义错误信息
     */
    protected $message  =   [
        'username.require' => '用户名必须填写',
        'username.max'     => '用户名最多不能超过16个字符',
        'password.require' => '密码必须填写',
        'password.min' => '密码最少为6位',
        'password.max' => '密码长度不能超过16位',
        'role_ids' => '角色必须填写',
    ];

    /**
     * 定义场景
     */
    protected $scene = [
        'save' => [
            'username',
            'password',
            'role_ids',
        ],
        'update' => [
            'username',
            'role_ids',
        ],
    ];

}
