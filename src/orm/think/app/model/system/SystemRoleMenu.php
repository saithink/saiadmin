<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\system;

use think\model\Pivot;

/**
 * 角色菜单关联模型
 *
 * system_role_menu 角色权限关联
 *
 * @property  $id 
 * @property  $role_id 
 * @property  $menu_id 
 */
class SystemRoleMenu extends Pivot
{
    protected $pk = 'id';

    protected $name = 'system_role_menu';
}