<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\tool;

use plugin\saiadmin\basic\think\BaseModel;

/**
 * 定时任务模型
 *
 * sa_tool_crontab 定时任务信息表
 *
 * @property int $id 主键
 * @property string $name 任务名称
 * @property string $type 任务类型
 * @property string $target 调用任务字符串
 * @property string $parameter 调用任务参数
 * @property string $task_style 执行类型
 * @property string $rule 任务执行表达式
 * @property int $status 状态
 * @property string $remark 备注
 * @property int $created_by 创建者
 * @property int $updated_by 更新者
 * @property string $create_time 创建时间
 * @property string $update_time 修改时间
 */
class Crontab extends BaseModel
{
    /**
     * 数据表主键
     * @var string
     */
    protected $pk = 'id';

    protected $table = 'sa_tool_crontab';

}