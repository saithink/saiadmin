<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\system;

use plugin\saiadmin\basic\BaseLogic;
use plugin\saiadmin\exception\ApiException;
use plugin\saiadmin\app\model\system\SystemConfig;
use plugin\saiadmin\utils\Cache;
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
     * 获取配置
     */
    public function getConfig($config)
    {
        $prefix = 'config_';
        $data = Cache::get($prefix . $config);
        if ($data) {
            return $data;
        }
        $info = $this->model->where('key', $config)->find();
        Cache::set($prefix . $config, $info);
        return $info;
    }
}
