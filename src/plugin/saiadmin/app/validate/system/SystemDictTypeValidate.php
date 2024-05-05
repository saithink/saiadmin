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
class SystemDictTypeValidate extends Validate
{
    /**
     * 定义验证规则
     */
    protected $rule =   [
        'name' => 'require|max:16',
        'code' => 'require|alphaDash',
        'status' => 'require',
    ];

    /**
     * 定义错误信息
     */
    protected $message  =   [
        'name.require' => '字典名称必须填写',
        'name.max'     => '字典名称最多不能超过16个字符',
        'code.require' => '字典标识必须填写',
        'code.alphaDash' => '字典标识只能由英文字母组成',
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
