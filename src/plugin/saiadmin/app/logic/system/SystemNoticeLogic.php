<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\system;

use plugin\saiadmin\app\model\system\SystemNotice;
use plugin\saiadmin\basic\BaseLogic;
use plugin\saiadmin\utils\Helper;

/**
 * 系统公告逻辑层
 */
class SystemNoticeLogic extends BaseLogic
{
    /**
     * @var bool 数据边界启用状态
     */
    protected $scope = true;

    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->model = new SystemNotice();
    }

}
