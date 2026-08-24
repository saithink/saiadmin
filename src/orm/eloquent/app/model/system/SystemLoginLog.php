<?php

// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\system;

use plugin\saiadmin\basic\eloquent\BaseModel;

/**
 * 登录日志模型
 *
 * sa_system_login_log 登录日志表
 *
 * @property int $id 主键
 * @property string $username 用户名
 * @property string $ip 登录IP地址
 * @property string $ip_location IP所属地
 * @property string $os 操作系统
 * @property string $browser 浏览器
 * @property int $status 登录状态
 * @property string $message 提示消息
 * @property string $login_time 登录时间
 * @property string $remark 备注
 * @property int $created_by 创建者
 * @property int $updated_by 更新者
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 */
class SystemLoginLog extends BaseModel
{
    /**
     * 数据表主键
     * @var string
     */
    protected $primaryKey = 'id';

    protected $table = 'sa_system_login_log';

    /**
     * 时间范围搜索
     */
    public function searchLoginTimeAttr($query, $value)
    {
        // 不能用 whereTime()：Eloquent 的 whereTime 是把字段 CAST 成 time 再比较（PG 下直接报
        // time 与 timestamp 无法比较），think-orm 那套 whereTime(字段, 'between', 范围) 语义在这里不成立
        if (is_array($value)) {
            $query->whereBetween('login_time', $value);
        } else {
            $query->where('login_time', '=', $value);
        }
    }

}