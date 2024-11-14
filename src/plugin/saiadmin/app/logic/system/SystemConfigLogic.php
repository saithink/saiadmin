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
use plugin\saiadmin\app\model\system\SystemConfigGroup;
use support\Cache;
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
     * 获取单项配置
     */
    public function getConfig($config)
    {
        $prefix = 'config_';
        $data = Cache::get($prefix . $config);
        if (!is_null($data)) {
            return $data;
        }
        $info = $this->model->where('key', $config)->findOrEmpty();
        if ($info->isEmpty()) {
            throw new ApiException('配置项不存在');
        }
        Cache::set($prefix . $config, $info->toArray());
        return $info;
    }

    /**
     * 获取配置组
     */
    public function getGroup($config)
    {
        $prefix = 'cfg_';
        $data = Cache::get($prefix . $config);
        if (!is_null($data)) {
            return $data;
        }
        $group = SystemConfigGroup::where('code', $config)->findOrEmpty();
        if ($group->isEmpty()) {
            throw new ApiException('配置组不存在');
        }
        $info = $this->model->where('group_id', $group->id)->select();
        Cache::set($prefix . $config, $info->toArray());
        return $info;
    }
}
