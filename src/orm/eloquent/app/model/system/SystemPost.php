<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\system;

use plugin\saiadmin\basic\eloquent\BaseModel;

/**
 * 岗位模型
 *
 * sa_system_post 岗位信息表
 *
 * @property int $id 主键
 * @property string $name 岗位名称
 * @property string $code 岗位代码
 * @property int $sort 排序
 * @property int $status 状态
 * @property string $remark 备注
 * @property int $created_by 创建者
 * @property int $updated_by 更新者
 * @property string $create_time 创建时间
 * @property string $update_time 修改时间
 */
class SystemPost extends BaseModel
{
    /**
     * 数据表主键
     * @var string
     */
    protected $primaryKey = 'id';

    protected $table = 'sa_system_post';

}