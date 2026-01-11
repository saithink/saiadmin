<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\system;

use plugin\saiadmin\basic\think\BaseModel;

/**
 * 角色模型
 *
 * sa_system_role 角色表
 *
 * @property  $id 
 * @property  $name 角色名称
 * @property  $code 角色标识，如: hr_manager
 * @property  $level 角色级别：用于行政控制，不可操作级别大于自己的角色
 * @property  $data_scope 数据范围: 1全部, 2本部门及下属, 3本部门, 4仅本人, 5自定义
 * @property  $remark 备注
 * @property  $sort 
 * @property  $status 状态: 1启用, 0禁用
 * @property  $created_by 创建者
 * @property  $updated_by 更新者
 * @property  $create_time 创建时间
 * @property  $update_time 修改时间
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
                $temp = static::whereRaw('FIND_IN_SET("' . $item['id'] . '", level) > 0')->column('id');
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