<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\system;

use plugin\saiadmin\basic\think\BaseModel;

/**
 * 字典类型模型
 *
 * sa_system_dict_type 字典类型表
 *
 * @property  $id 主键
 * @property  $name 字典名称
 * @property  $code 字典标示
 * @property  $status 状态
 * @property  $remark 备注
 * @property  $created_by 创建者
 * @property  $updated_by 更新者
 * @property  $create_time 创建时间
 * @property  $update_time 修改时间
 */
class SystemDictType extends BaseModel
{
    /**
     * 数据表主键
     * @var string
     */
    protected $pk = 'id';

    protected $table = 'sa_system_dict_type';

    /**
     * 关联字典数据
     */
    public function dicts()
    {
        return $this->hasMany(SystemDictData::class, 'type_id', 'id');
    }

}