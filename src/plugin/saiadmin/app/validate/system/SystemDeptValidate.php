<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\validate\system;

use think\Validate;

/**
 * 部门验证器
 */
class SystemDeptValidate extends Validate
{
    /**
     * 定义验证规则
     */
    protected $rule =   [
        'name' => 'require|max:16',
        'parent_id' => 'require',
        'status' => 'require',
    ];

    /**
     * 定义错误信息
     */
    protected $message  =   [
        'name.require' => '部门名称必须填写',
        'name.max'     => '部门名称最多不能超过16个字符',
        'parent_id' => '上级部门必须填写',
        'status' => '状态必须填写',
    ];

    /**
     * 定义场景
     */
    protected $scene = [
        'save' => [
            'name',
            'parent_id',
            'status',
        ],
        'update' => [
            'name',
            'parent_id',
            'status',
        ],
    ];

}
