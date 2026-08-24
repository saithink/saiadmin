<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\system;

use plugin\saiadmin\basic\eloquent\BaseModel;

/**
 * 参数配置模型
 *
 * sa_system_config 参数配置信息表
 *
 * @property int  $id 编号
 * @property int  $group_id 组id
 * @property string  $key 配置键名
 * @property string  $value 配置值
 * @property string  $name 配置名称
 * @property string  $input_type 数据输入类型
 * @property string $config_select_data 配置选项数据
 * @property int  $sort 排序
 * @property string  $remark 备注
 * @property int  $created_by 创建人
 * @property int  $updated_by 更新人
 * @property string  $create_time 创建时间
 * @property string  $update_time 修改时间
 */
class SystemConfig extends BaseModel
{
    /**
     * 数据表主键
     * @var string
     */
    protected $primaryKey = 'id';

    protected $table = 'sa_system_config';

    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'config_select_data' => 'array',
        ]);
    }

}