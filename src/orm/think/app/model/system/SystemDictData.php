<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\system;

use plugin\saiadmin\basic\think\BaseModel;

/**
 * 字典数据模型
 *
 * sa_system_dict_data 字典数据表
 *
 * @property int $id 主键
 * @property int $type_id 字典类型ID
 * @property string $label 字典标签
 * @property string $value 字典值
 * @property string $color 字典颜色
 * @property string $code 字典标示
 * @property int $sort 排序
 * @property int $status 状态
 * @property string $remark 备注
 * @property int $created_by 创建者
 * @property int $updated_by 更新者
 * @property string $create_time 创建时间
 * @property string $update_time 修改时间
 */
class SystemDictData extends BaseModel
{
    /**
     * 数据表主键
     * @var string
     */
    protected $pk = 'id';

    protected $table = 'sa_system_dict_data';

    /**
     * 关键字搜索
     */
    public function searchKeywordsAttr($query, $value)
    {
        $query->where('label|code', 'LIKE', "%$value%");
    }
}