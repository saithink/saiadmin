<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
declare(strict_types=1);

namespace plugin\saiadmin\app\cache;

use ReflectionClass;
use ReflectionMethod;
use plugin\saiadmin\service\Permission;
use support\think\Cache;

/**
 * 反射文件缓存
 */
class ReflectionCache
{
    /**
     * 读取缓存配置
     * @return array
     */
    public static function cacheConfig(): array
    {
        return config('plugin.saiadmin.saithink.reflection_cache', [
            'tag' => 'saiadmin:reflection',
            'expire' => 60 * 60 * 24 * 365,
            'no_need' => 'saiadmin:reflection_cache:no_need_',
            'attr' => 'saiadmin:reflection_cache:attr_',
        ]);
    }

    /**
     * 获取控制器中无需登录的方法列表
     */
    public static function getNoNeedLogin(string $controller): array
    {
        $cache = static::cacheConfig();
        $tag = [];
        $tag[] = $cache['tag'];
        $key = $cache['no_need'] . md5($controller);

        $data = Cache::get($key);
        if ($data !== null) {
            return $data;
        }

        // 反射逻辑
        if (class_exists($controller)) {
            $ref = new ReflectionClass($controller);
            $data = $ref->getDefaultProperties()['noNeedLogin'] ?? [];
        } else {
            $data = [];
        }

        Cache::tag($tag)->set($key, $data, $cache['expire']);
        return $data;
    }

    /**
     * 获取方法上的权限属性
     */
    public static function getPermissionAttributes(string $controller, string $action): array
    {
        $cache = static::cacheConfig();
        $tag = [];
        $tag[] = $cache['tag'];
        $key = $cache['attr'] . md5($controller . '::' . $action);

        $data = Cache::get($key);
        if ($data) {
            return $data;
        }

        $data = [];
        if (method_exists($controller, $action)) {
            $refMethod = new ReflectionMethod($controller, $action);
            $attributes = $refMethod->getAttributes(Permission::class);
            if (!empty($attributes)) {
                $attr = $attributes[0]->newInstance();
                $data = [
                    'title' => $attr->getTitle(),
                    'slug'  => $attr->getSlug(),
                ];
            }
        }

        Cache::tag($tag)->set($key, $data, $cache['expire']);
        return $data;
    }

    /**
     * 清理所有反射缓存
     * @return bool
     */
    public static function clear(): bool
    {
        $cache = static::cacheConfig();
        return Cache::tag($cache['tag'])->clear();
    }

}