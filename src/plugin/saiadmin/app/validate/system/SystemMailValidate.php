<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\validate\system;

use think\Validate;

/**
 * 邮件验证器
 */
class SystemMailValidate extends Validate
{
    /**
     * 定义验证规则
     */
    protected $rule =   [
        'gateway' => 'require',
        'from' => 'require',
        'email' => 'require',
    ];

    /**
     * 定义错误信息
     */
    protected $message  =   [
        'gateway' => '网关必须填写',
        'from' => '发件人必须填写',
        'email' => '接收人必须填写',
    ];

    /**
     * 定义场景
     */
    protected $scene = [
        'save' => [
            'gateway',
            'from',
            'email',
        ],
        'update' => [
            'gateway',
            'from',
            'email',
        ],
    ];

}
