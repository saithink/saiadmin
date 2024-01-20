<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\system;

use plugin\saiadmin\basic\BaseModel;
/**
 * 部门模型
 * Class SystemDept
 * @package app\model
 */
class SystemDept extends BaseModel
{
    /**
     * 数据表主键
     * @var string
     */
    protected $pk = 'id';

    protected $table = 'eb_system_dept';

    public function leader()
    {
        return $this->belongsToMany(SystemUser::class, SystemDeptLeader::class, 'user_id', 'dept_id');
    }

}