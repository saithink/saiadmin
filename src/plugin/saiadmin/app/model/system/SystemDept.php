<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\system;

use plugin\saiadmin\basic\think\BaseModel;

/**
 * 部门模型
 *
 * sa_system_dept 部门表
 *
 * @property  $id 编号
 * @property  $parent_id 父级ID，0为根节点
 * @property  $name 部门名称
 * @property  $code 部门编码
 * @property  $leader_id 部门负责人ID
 * @property  $level 祖级列表，格式: 0,1,5,
 * @property  $sort 排序，数字越小越靠前
 * @property  $status 状态: 1启用, 0禁用
 * @property  $remark 备注
 * @property  $created_by 创建者
 * @property  $updated_by 更新者
 * @property  $create_time 创建时间
 * @property  $update_time 修改时间
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
            $deptIds = [$value['id']];
            $deptLevel = $value['level'] . $value['id'] . ',';
            $ids = static::whereLike('level', $deptLevel . '%')->column('id');
            $deptIds = array_merge($deptIds, $ids);
            $query->whereIn('id', $deptIds);
        }
    }

    /**
     * 部门领导
     */
    public function leader()
    {
        return $this->hasOne(SystemUser::class, 'id', 'leader_id');
    }

}