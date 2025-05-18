<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\system;

use plugin\saiadmin\basic\BaseModel;

/**
 * 角色模型
 */
class SystemRole extends BaseModel
{

    /**
     * 数据表主键
     * @var string
     */
    protected $pk = 'id';

    /**
     * 数据表完整名称
     * @var string
     */
    protected $table = 'sa_system_role';

    /**
     * 权限范围
     */
    public function scopeAuth($query, $value)
    {
        $id = $value['id'];
        $roles = $value['roles'];
        if ($id > 1) {
            $ids = [];
            foreach ($roles as $item) {
                $ids[] = $item['id'];
                $temp = static::whereRaw('FIND_IN_SET("'.$item['id'].'", level) > 0')->column('id');
                $ids = array_merge($ids, $temp);
            }
            $query->where('id', 'in', array_unique($ids));
        }
    }

    /**
     * 通过中间表获取菜单
     */
    public function menus()
    {
        return $this->belongsToMany(SystemMenu::class, SystemRoleMenu::class, 'menu_id', 'role_id');
    }

    /**
     * 通过中间表获取部门
     */
    public function depts()
    {
        return $this->belongsToMany(SystemDept::class, SystemRoleDept::class, 'dept_id', 'role_id');
    }

}