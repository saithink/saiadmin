<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
declare(strict_types=1);

namespace plugin\saiadmin\app\cache;

use plugin\saiadmin\app\logic\system\SystemConfigLogic;
use support\think\Cache;

/**
 * 配置缓存
 */
class ConfigCache
{
    /**
     * 读取缓存配置
     * @return array
     */
    public static function cacheConfig(): array
    {
        return config('plugin.saiadmin.saithink.config_cache', [
            'expire' => 60 * 60 * 24 * 365,
            'prefix' => 'saiadmin:config_cache:config_',
            'tag' => 'saiadmin:config_cache'
        ]);
    }

    /**
     * 获取配置信息
     */
    public static function getConfig(string $code = ''): array
    {
        if (empty($code)) {
            return [];
        }
        $cache = static::cacheConfig();
        // 直接从缓存获取
        $config = Cache::get($cache['prefix'] . md5($code));
        if ($config) {
            return $config;
        }

        // 设置配置并获取
        $config = static::setConfig($code);
        if ($config) {
            return $config;
        }

        return [];
    }

    /**
     * 设置配置数据
     */
    public static function setConfig(string $code): array
    {
        $cache = static::cacheConfig();

        $data = (new SystemConfigLogic())->getData($code);
        if (empty($data)) {
            return [];
        }

        $tag = [];
        $tag[] = $cache['tag'];

        // 保存到缓存
        Cache::tag($tag)->set($cache['prefix'] . md5($code), $data, $cache['expire']);
        return $data;
    }

    /**
     * 清理单个配置缓存
     */
    public static function clearConfig(string $code): bool
    {
        $cache = static::cacheConfig();
        return Cache::delete($cache['prefix'] . md5($code));
    }

    /**
     * 清理全部配置缓存
     * @return bool
     */
    public static function clear(): bool
    {
        $cache = static::cacheConfig();
        return Cache::tag($cache['tag'])->clear();
    }
}
