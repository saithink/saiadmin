<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
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
    // 完整数据库表名称
    protected $table  = 'eb_system_user';
    // 主键
    protected $pk = 'id';

    public function getBackendSettingAttr($value)
    {
        return json_decode($value ?? '', true);
    }

    public function setBackendSettingAttr($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 根据岗位id进行搜索
     */
    public function searchPostIdAttr($query, $value)
    {
        $query->join('eb_system_user_post post', 'eb_system_user.id = post.user_id')
            ->where('post.post_id', $value);
    }

    /**
     * 根据角色id进行搜索
     */
    public function searchRoleIdAttr($query, $value)
    {
        $query->whereRaw('id in (SELECT user_id FROM eb_system_user_role WHERE role_id =?)', [$value]);
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