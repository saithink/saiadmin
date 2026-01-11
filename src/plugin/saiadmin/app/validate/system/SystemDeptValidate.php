<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\validate\system;

use plugin\saiadmin\basic\BaseValidate;

/**
 * 部门验证器
 */
class SystemDeptValidate extends BaseValidate
{
    /**
     * 定义验证规则
     */
    protected $rule = [
        'name' => 'require',
        'status' => 'require',
    ];

    /**
     * 定义错误信息
     */
    protected $message = [
        'name' => '部门名称必须填写',
        'status' => '状态必须填写',
    ];

    /**
     * 定义场景
     */
    protected $scene = [
        'add' => [
            'name',
            'status',
        ],
        'edit' => [
            'name',
            'status',
        ],
    ];

}
