<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\validate\system;

use plugin\saiadmin\basic\BaseValidate;
use plugin\saiadmin\app\model\system\SystemRole;

/**
 * 用户角色验证器
 */
class SystemRoleValidate extends BaseValidate
{
    /**
     * 定义验证规则
     */
    protected $rule = [
        'name' => 'require|max:16',
        'code' => 'require|alphaDash|unique:' . SystemRole::class,
        'status' => 'require',
    ];

    /**
     * 定义错误信息
     */
    protected $message = [
        'name.require' => '角色名称必须填写',
        'name.max' => '角色名称最多不能超过16个字符',
        'code.require' => '角色标识必须填写',
        'code.alphaDash' => '角色标识只能由英文字母组成',
        'code.unique' => '角色标识不能重复',
        'status' => '状态必须填写',
    ];

    /**
     * 定义场景
     */
    protected $scene = [
        'add' => [
            'name',
            'code',
            'status',
        ],
        'edit' => [
            'name',
            'code',
            'status',
        ],
    ];

}
