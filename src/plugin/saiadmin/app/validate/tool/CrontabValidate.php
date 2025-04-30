<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\validate\tool;

use think\Validate;

/**
 * 字典类型验证器
 */
class CrontabValidate extends Validate
{
    /**
     * 定义验证规则
     */
    protected $rule =   [
        'name' => 'require',
        'type' => 'require',
        'target' => 'require',
        'status' => 'require',
    ];

    /**
     * 定义错误信息
     */
    protected $message  =   [
        'name' => '任务名称必须填写',
        'type' => '任务类型必须填写',
        'target' => '调用目标必须填写',
        'status' => '状态必须填写',
    ];

    /**
     * 定义场景
     */
    protected $scene = [
        'save' => [
            'name',
            'type',
            'target',
            'status',
        ],
        'update' => [
            'name',
            'type',
            'target',
            'status',
        ],
    ];

}
