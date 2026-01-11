<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\validate\system;

use plugin\saiadmin\basic\BaseValidate;

/**
 * 字典数据验证器
 */
class SystemDictDataValidate extends BaseValidate
{
    /**
     * 定义验证规则
     */
    protected $rule = [
        'label' => 'require',
        'value' => 'require',
        'status' => 'require',
        'type_id' => 'require',
        'code' => 'require',
    ];

    /**
     * 定义错误信息
     */
    protected $message = [
        'label' => '字典标签必须填写',
        'value' => '字典键值必须填写',
        'status' => '状态必须填写',
        'type_id' => '字典类型必须填写',
        'code' => '字典标识必须填写',
    ];

    /**
     * 定义场景
     */
    protected $scene = [
        'save' => [
            'label',
            'value',
            'status',
            'type_id',
        ],
        'update' => [
            'label',
            'value',
            'status',
        ],
    ];

}
