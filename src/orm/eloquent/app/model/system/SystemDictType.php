<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\system;

use plugin\saiadmin\basic\eloquent\BaseModel;

/**
 * 字典类型模型
 *
 * sa_system_dict_type 字典类型表
 *
 * @property int $id 主键
 * @property string $name 字典名称
 * @property string $code 字典标示
 * @property int $status 状态
 * @property string $remark 备注
 * @property int $created_by 创建者
 * @property int $updated_by 更新者
 * @property string $create_time 创建时间
 * @property string $update_time 修改时间
 */
class SystemDictType extends BaseModel
{
    /**
     * 数据表主键
     * @var string
     */
    protected $primaryKey = 'id';

    protected $table = 'sa_system_dict_type';

    /**
     * 关联字典数据
     */
    public function dicts()
    {
        return $this->hasMany(SystemDictData::class, 'type_id', 'id');
    }

    /**
     * 名称搜索
     */
    public function searchNameAttr($query, $value)
    {
        return $query->whereLike('name', '%' . $value . '%');
    }

    /**
     * 编码搜索
     */
    public function searchCodeAttr($query, $value)
    {
        return $query->whereLike('code', '%' . $value . '%');
    }

}