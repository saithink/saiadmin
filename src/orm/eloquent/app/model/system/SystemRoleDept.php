<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\system;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * 角色部门关联模型
 *
 * sa_system_role_dept 角色-自定义数据权限关联
 *
 * @property  $id 
 * @property  $role_id 
 * @property  $dept_id 
 */
class SystemRoleDept extends Pivot
{
    protected $primaryKey = 'id';

    protected $table = 'sa_system_role_dept';
}