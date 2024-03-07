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
class SystemConfigGroupValidate extends Validate
{
    /**
     * 定义验证规则
     */
    protected $rule =   [
        'name' => 'require|max:16|chs',
        'code' => 'require|alpha',
    ];

    /**
     * 定义错误信息
     */
    protected $message  =   [
        'name.require' => '组名称必须填写',
        'name.max'     => '组名称最多不能超过16个字符',
        'name.chs'     => '组名称必须是中文',
        'code.require' => '组标识必须填写',
        'code.alpha' => '组标识只能由英文字母组成',
    ];

    /**
     * 定义场景
     */
    protected $scene = [
        'save' => [
            'name',
            'code',
        ],
        'update' => [
            'name',
            'code',
        ],
    ];

}
