<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\system;

use plugin\saiadmin\app\model\system\SystemOperLog;
use plugin\saiadmin\basic\think\BaseLogic;
use plugin\saiadmin\utils\Helper;

/**
 * 操作日志逻辑层
 */
class SystemOperLogLogic extends BaseLogic
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->model = new SystemOperLog();
    }

    /**
     * 获取自己的操作日志
     * @param mixed $where
     * @return array
     */
    public function getOwnOperLogList($where): array
    {
        $query = $this->search($where);
        $query->field('id, username, method, router, service_name, ip, ip_location, create_time');
        return $this->getList($query);
    }

}
