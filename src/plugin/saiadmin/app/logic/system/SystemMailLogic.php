<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\system;

use plugin\saiadmin\app\model\system\SystemMail;
use plugin\saiadmin\basic\BaseLogic;
use plugin\saiadmin\utils\Helper;

/**
 * 邮件模型逻辑层
 */
class SystemMailLogic extends BaseLogic
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->model = new SystemMail();
    }

}
