<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\validate\tool;

use think\Validate;

/**
 * 用户角色验证器
 */
class GenerateTablesValidate extends Validate
{
    /**
     * 定义验证规则
     */
    protected $rule =   [
        'table_name' => 'require',
        'table_comment' => 'require',
        'class_name' => 'require|alpha',
        'business_name' => 'require|alpha',
        'template' => 'require',
        'namespace' => 'require',
        'menu_name' => 'require',
    ];

    /**
     * 定义错误信息
     */
    protected $message  =   [
        'table_name' => '表名称必须填写',
        'table_comment' => '表描述必须填写',
        'class_name.require' => '实体类必须填写',
        'class_name.alpha' => '实体类必须是英文',
        'business_name.require' => '实体别名必须填写',
        'business_name.alpha' => '实体别名必须是英文',
        'template' => '模板必须填写',
        'namespace' => '命名空间必须填写',
        'menu_name' => '菜单名称必须填写',
    ];

    /**
     * 定义场景
     */
    protected $scene = [
        'save' => [
            'table_name',
            'table_comment',
            'class_name',
            'business_name',
            'template',
            'namespace',
            'menu_name',
        ],
        'update' => [
            'table_name',
            'table_comment',
            'class_name',
            'business_name',
            'template',
            'namespace',
            'menu_name',
        ]
    ];

}
