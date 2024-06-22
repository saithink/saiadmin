<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\validate\system;

use think\Validate;

/**
 * 系统公告验证器
 */
class SystemNoticeValidate extends Validate
{
    /**
     * 定义验证规则
     */
    protected $rule =   [
        'title' => 'require|min:4',
        'content' => 'require',
        'type' => 'require',
    ];

    /**
     * 定义错误信息
     */
    protected $message  =   [
        'title.require' => '公告标题必须填写',
        'title.min'     => '公告标题必须大于4个字符',
        'content' => '公告内容必须填写',
        'type' => '公告类型必须填写',
    ];

    /**
     * 定义场景
     */
    protected $scene = [
        'save' => [
            'title',
            'content',
            'type',
        ],
        'update' => [
            'title',
            'content',
            'type',
        ],
    ];

}
