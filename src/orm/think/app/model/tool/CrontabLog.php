<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\tool;

use plugin\saiadmin\basic\think\BaseModel;

/**
 * 定时任务日志模型
 *
 * sa_tool_crontab_log 定时任务执行日志表
 *
 * @property  $id 主键
 * @property  $crontab_id 任务ID
 * @property  $name 任务名称
 * @property  $target 任务调用目标字符串
 * @property  $parameter 任务调用参数
 * @property  $exception_info 异常信息
 * @property  $status 执行状态
 * @property  $create_time 创建时间
 * @property  $update_time 修改时间
 */
class CrontabLog extends BaseModel
{
    /**
     * 数据表主键
     * @var string
     */
    protected $pk = 'id';

    protected $table = 'sa_tool_crontab_log';

}