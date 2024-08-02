<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\validate\system;

use think\Validate;

/**
 * 菜单验证器
 */
class SystemMenuValidate extends Validate
{
    /**
     * 定义验证规则
     */
    protected $rule =   [
        'name' => 'require|max:16',
        'code' => 'require',
        'status' => 'require',
    ];

    /**
     * 定义错误信息
     */
    protected $message  =   [
        'name.require' => '菜单名称必须填写',
        'name.max'     => '菜单名称最多不能超过16个字符',
        'code' => '菜单标识必须填写',
        'status' => '状态必须填写',
    ];

    /**
     * 定义场景
     */
    protected $scene = [
        'save' => [
            'name',
            'code',
            'status',
        ],
        'update' => [
            'name',
            'code',
            'status',
        ],
    ];

}
