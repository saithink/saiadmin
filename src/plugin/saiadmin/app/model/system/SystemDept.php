<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\system;

use plugin\saiadmin\basic\BaseModel;

/**
 * 部门模型
 */
class SystemDept extends BaseModel
{
    /**
     * 数据表主键
     * @var string
     */
    protected $pk = 'id';

    protected $table = 'sa_system_dept';

    /**
     * 权限范围
     */
    public function scopeAuth($query, $value)
    {
        if (!empty($value)) {
            $deptIds[] = $value['id'];
            $ids = static::whereRaw('FIND_IN_SET("'.$value['id'].'", level) > 0')->column('id');
            $deptIds = array_merge($deptIds, $ids);
            $query->whereIn('id', $deptIds);
        }
    }

    public function leader()
    {
        return $this->belongsToMany(SystemUser::class, SystemDeptLeader::class, 'user_id', 'dept_id');
    }

}