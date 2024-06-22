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
class SystemConfigValidate extends Validate
{
    /**
     * 定义验证规则
     */
    protected $rule =   [
        'name' => 'require',
        'key' => 'require',
        'group_id' => 'require',
        'input_type' => 'require',
    ];

    /**
     * 定义错误信息
     */
    protected $message  =   [
        'name' => '配置标题必须填写',
        'key' => '配置标识必须填写',
        'group_id' => '所属组必须填写',
        'input_type' => '输入组件必须填写',
    ];

    /**
     * 定义场景
     */
    protected $scene = [
        'save' => [
            'name',
            'key',
            'group_id',
            'input_type',
        ],
        'update' => [
            'name',
            'key',
            'group_id',
            'input_type',
        ],
    ];

}
