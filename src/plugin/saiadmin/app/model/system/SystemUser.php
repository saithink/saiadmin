<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\system;

use plugin\saiadmin\basic\BaseModel;

/**
 * 用户信息模型
 */
class SystemUser extends BaseModel
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
    protected $table  = 'sa_system_user';

    /**
     * 获取器
     */
    public function getBackendSettingAttr($value)
    {
        return json_decode($value ?? '', true);
    }

    /**
     * 修改器
     */
    public function setBackendSettingAttr($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 权限范围
     */
    public function scopeAuth($query, $value)
    {
        $id = $value['id'];
        $dept = $value['dept'];
        if ($id > 1) {
            $ids = SystemDept::whereRaw('FIND_IN_SET("'.$dept['id'].'", level) > 0')->column('id');
            $query->whereIn('dept_id', $ids);
        }
    }

    /**
     * 根据岗位id进行搜索
     */
    public function searchPostIdAttr($query, $value)
    {
        $query->join('sa_system_user_post post', 'sa_system_user.id = post.user_id')
            ->where('post.post_id', $value);
    }

    /**
     * 根据角色id进行搜索
     */
    public function searchRoleIdAttr($query, $value)
    {
        $query->whereRaw('id in (SELECT user_id FROM sa_system_user_role WHERE role_id =?)', [$value]);
    }

    /**
     * 通过中间表关联角色
     */
    public function roles()
    {
        return $this->belongsToMany(SystemRole::class, SystemUserRole::class, 'role_id', 'user_id');
    }

    /**
     * 通过中间表关联岗位
     */
    public function posts()
    {
        return $this->belongsToMany(SystemPost::class, SystemUserPost::class, 'post_id', 'user_id');
    }

    /**
     * 通过中间表关联部门
     */
    public function depts()
    {
        return $this->belongsTo(SystemDept::class, 'dept_id', 'id');
    }
}