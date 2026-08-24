<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\system;

use plugin\saiadmin\basic\eloquent\BaseModel;

/**
 * 角色模型
 *
 * sa_system_role 角色表
 *
 * @property int $id 
 * @property string $name 角色名称
 * @property string $code 角色标识，如: hr_manager
 * @property int $level 角色级别：用于行政控制，不可操作级别大于自己的角色
 * @property int $data_scope 数据范围: 1全部, 2本部门及下属, 3本部门, 4仅本人, 5自定义
 * @property string $remark 备注
 * @property int $sort 
 * @property int $status 状态: 1启用, 0禁用
 * @property int $created_by 创建者
 * @property int $updated_by 更新者
 * @property string $create_time 创建时间
 * @property string $update_time 修改时间
 */
class SystemRole extends BaseModel
{

    /**
     * 数据表主键
     * @var string
     */
    protected $primaryKey = 'id';

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
                // FIND_IN_SET 是 MySQL 专有函数，改用两种数据库通用的 CONCAT + LIKE 判断
                // level 这一列存的是逗号分隔的祖先 id，前后各补一个逗号避免匹配到 12 这类前缀
                $temp = static::whereRaw("CONCAT(',', level, ',') LIKE ?", ['%,' . $item['id'] . ',%'])
                    ->pluck('id')
                    ->toArray();
                $ids = array_merge($ids, $temp);
            }
            $query->whereIn('id', array_unique($ids));
        }
    }

    /**
     * 通过中间表获取菜单
     */
    public function menus()
    {
        return $this->belongsToMany(SystemMenu::class, SystemRoleMenu::class, 'role_id', 'menu_id');
    }

    /**
     * 通过中间表获取部门
     */
    public function depts()
    {
        return $this->belongsToMany(SystemDept::class, SystemRoleDept::class, 'role_id', 'dept_id');
    }

}