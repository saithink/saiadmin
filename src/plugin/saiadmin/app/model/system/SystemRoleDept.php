<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\system;

use think\model\Pivot;

/**
 * 角色部门关联模型
 */
class SystemRoleDept extends Pivot
{
    protected $table = 'sa_system_role_dept';
}