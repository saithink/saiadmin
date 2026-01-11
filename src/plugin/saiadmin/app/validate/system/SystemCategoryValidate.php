<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\validate\system;

use plugin\saiadmin\basic\BaseValidate;

/**
 * 附件分类验证器
 */
class SystemCategoryValidate extends BaseValidate
{
    /**
     * 定义验证规则
     */
    protected $rule = [
        'category_name' => 'require',
    ];

    /**
     * 定义错误信息
     */
    protected $message = [
        'category_name' => '分类名称必须填写',
    ];

    /**
     * 定义场景
     */
    protected $scene = [
        'add' => [
            'category_name',
        ],
        'edit' => [
            'category_name',
        ],
    ];

}
