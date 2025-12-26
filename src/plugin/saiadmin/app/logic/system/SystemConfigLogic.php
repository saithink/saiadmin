<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\system;

use plugin\saiadmin\basic\BaseLogic;
use plugin\saiadmin\exception\ApiException;
use plugin\saiadmin\app\model\system\SystemConfig;
use plugin\saiadmin\app\cache\ConfigCache;
use plugin\saiadmin\utils\Helper;

/**
 * 参数配置逻辑层
 */
class SystemConfigLogic extends BaseLogic
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->model = new SystemConfig();
    }

    /**
     * 获取配置组
     */
    public function getGroup($config)
    {
        return ConfigCache::getConfig($config);
    }

}
