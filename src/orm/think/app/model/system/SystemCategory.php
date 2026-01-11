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
 * @property  $id 分类ID
 * @property  $parent_id 父id
 * @property  $level 组集关系
 * @property  $category_name 分类名称
 * @property  $sort 排序
 * @property  $status 状态
 * @property  $remark 备注
 * @property  $created_by 创建者
 * @property  $updated_by 更新者
 * @property  $create_time 创建时间
 * @property  $update_time 修改时间
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