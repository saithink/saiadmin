<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\validate\system;

use plugin\saiadmin\basic\BaseValidate;

/**
 * 用户角色验证器
 */
class SystemPostValidate extends BaseValidate
{
    /**
     * 定义验证规则
     */
    protected $rule = [
        'name' => 'require',
        'code' => 'require',
        'status' => 'require',
    ];

    /**
     * 定义错误信息
     */
    protected $message = [
        'name' => '岗位名称必须填写',
        'code' => '岗位标识必须填写',
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
