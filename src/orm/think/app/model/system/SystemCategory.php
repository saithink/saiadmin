<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\system;

use plugin\saiadmin\basic\think\BaseModel;

/**
 * 附件分类模型
 *
 * sa_system_category 附件分类表
 *
 * @property int $id 分类ID
 * @property int $parent_id 父id
 * @property string $level 组集关系
 * @property string $category_name 分类名称
 * @property int $sort 排序
 * @property int $status 状态
 * @property string $remark 备注
 * @property int $created_by 创建者
 * @property int $updated_by 更新者
 * @property string $create_time 创建时间
 * @property string $update_time 修改时间
 */
class SystemCategory extends BaseModel
{
    /**
     * 数据表主键
     * @var string
     */
    protected $pk = 'id';

    protected $table = 'sa_system_category';

    /**
     * 分类名称搜索
     */
    public function searchCategoryNameAttr($query, $value)
    {
        $query->where('category_name', 'like', '%' . $value . '%');
    }

}