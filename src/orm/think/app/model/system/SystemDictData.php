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
 * @property  $id 主键
 * @property  $type_id 字典类型ID
 * @property  $label 字典标签
 * @property  $value 字典值
 * @property  $color 字典颜色
 * @property  $code 字典标示
 * @property  $sort 排序
 * @property  $status 状态
 * @property  $remark 备注
 * @property  $created_by 创建者
 * @property  $updated_by 更新者
 * @property  $create_time 创建时间
 * @property  $update_time 修改时间
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