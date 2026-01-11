<?php

// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\system;

use plugin\saiadmin\basic\think\BaseModel;

/**
 * 登录日志模型
 *
 * sa_system_login_log 登录日志表
 *
 * @property  $id 主键
 * @property  $username 用户名
 * @property  $ip 登录IP地址
 * @property  $ip_location IP所属地
 * @property  $os 操作系统
 * @property  $browser 浏览器
 * @property  $status 登录状态
 * @property  $message 提示消息
 * @property  $login_time 登录时间
 * @property  $remark 备注
 * @property  $created_by 创建者
 * @property  $updated_by 更新者
 * @property  $create_time 创建时间
 * @property  $update_time 更新时间
 */
class SystemLoginLog extends BaseModel
{
    /**
     * 数据表主键
     * @var string
     */
    protected $pk = 'id';

    protected $table = 'sa_system_login_log';

    /**
     * 时间范围搜索
     */
    public function searchLoginTimeAttr($query, $value)
    {
        $query->whereTime('login_time', 'between', $value);
    }

}