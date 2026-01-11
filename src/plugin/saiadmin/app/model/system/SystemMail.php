<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\system;

use plugin\saiadmin\basic\think\BaseModel;

/**
 * 邮件记录模型
 *
 * sa_system_mail 邮件记录
 *
 * @property  $id 编号
 * @property  $gateway 网关
 * @property  $from 发送人
 * @property  $email 接收人
 * @property  $code 验证码
 * @property  $content 邮箱内容
 * @property  $status 发送状态
 * @property  $response 返回结果
 * @property  $create_time 创建时间
 * @property  $update_time 修改时间
 */
class SystemMail extends BaseModel
{
    /**
     * 数据表主键
     * @var string
     */
    protected $pk = 'id';

    protected $table = 'sa_system_mail';

    /**
     * 发送人搜索
     */
    public function searchFromAttr($query, $value)
    {
        $query->where('from', 'like', '%' . $value . '%');
    }

    /**
     * 接收人搜索
     */
    public function searchEmailAttr($query, $value)
    {
        $query->where('email', 'like', '%' . $value . '%');
    }
}