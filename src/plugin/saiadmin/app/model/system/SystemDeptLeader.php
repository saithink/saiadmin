<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\system;

use think\model\Pivot;

/**
 * 部门领导关联模型
 */
class SystemDeptLeader extends Pivot
{
    protected $table = 'sa_system_dept_leader';
}