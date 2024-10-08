<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\system;

use plugin\saiadmin\basic\BaseModel;
/**
 * 角色模型
 * Class SystemRole
 * @package app\model
 */
class SystemRole extends BaseModel
{
    /**
     * 数据表主键
     * @var string
     */
    protected $pk = 'id';

    protected $table = 'eb_system_role';

    /**
     * 权限范围
     */
    public function scopeAuth($query, $value)
    {
        $id = $value['id'];
        $roles = $value['roles'];
        if ($id > 1) {
            foreach ($roles as $item) {
                $level = $item['level'] . ',' . $item['id'];
                $query->where('id', $item['id'])->whereOr('level', $level)->whereOr('level', 'like', $level . ',%');
            }
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