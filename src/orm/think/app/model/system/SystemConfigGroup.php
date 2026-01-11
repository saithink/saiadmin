<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\system;

use plugin\saiadmin\basic\think\BaseModel;

/**
 * 参数配置分组模型
 * 
 * sa_system_config_group 参数配置分组表
 *
 * @property  $id 主键
 * @property  $name 字典名称
 * @property  $code 字典标示
 * @property  $remark 备注
 * @property  $created_by 创建人
 * @property  $updated_by 更新人
 * @property  $create_time 创建时间
 * @property  $update_time 修改时间
 */
class SystemConfigGroup extends BaseModel
{
    /**
     * 数据表主键
     * @var string
     */
    protected $pk = 'id';

    protected $table = 'sa_system_config_group';

    /**
     * 关联配置列表
     */
    public function configs()
    {
        return $this->hasMany(SystemConfig::class, 'group_id', 'id');
    }

    /**
     * 名称搜索
     */
    public function searchNameAttr($query, $value)
    {
        return $query->where('name', 'like', '%' . $value . '%');
    }

    /**
     * 编码搜索
     */
    public function searchCodeAttr($query, $value)
    {
        return $query->where('code', 'like', '%' . $value . '%');
    }

}