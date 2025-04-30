<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\validate\system;

use think\Validate;

/**
 * 字典类型验证器
 */
class SystemCrontabValidate extends Validate
{
    /**
     * 定义验证规则
     */
    protected $rule =   [
        'name' => 'require',
        'type' => 'require',
        'rule' => 'require',
        'target' => 'require',
        'status' => 'require',
    ];

    /**
     * 定义错误信息
     */
    protected $message  =   [
        'name' => '任务名称必须填写',
        'type' => '任务类型必须填写',
        'rule' => '任务规则必须填写',
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
            'rule',
            'target',
            'status',
        ],
        'update' => [
            'name',
            'type',
            'rule',
            'target',
            'status',
        ],
    ];

}
