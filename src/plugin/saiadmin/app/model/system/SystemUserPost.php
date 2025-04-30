<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\system;

use think\model\Pivot;

/**
 * 用户岗位关联模型
 */
class SystemUserPost extends Pivot
{
    protected $table = 'sa_system_user_post';
}