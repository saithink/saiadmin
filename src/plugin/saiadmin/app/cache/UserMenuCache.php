<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\cache;

use plugin\saiadmin\app\logic\system\SystemMenuLogic;
use plugin\saiadmin\app\model\system\SystemUserRole;
use support\think\Cache;

/**
 * 用户菜单缓存
 */
class UserMenuCache
{
    /**
     * 读取缓存配置
     * @return array
     */
    public static function cacheConfig(): array
    {
        return config('plugin.saiadmin.saithink.menu_cache', [
            'prefix' => 'saiadmin:menu_cache:user_',
            'expire' => 60 * 60 * 24 * 7,
            'tag' => 'saiadmin:menu_cache',
        ]);
    }

    /**
     * 获取用户的菜单
     */
    public static function getUserMenu($uid): array
    {
        if (empty($uid)) {
            return [];
        }
        $cache = static::cacheConfig();
        // 直接从缓存获取
        $menu = Cache::get($cache['prefix'] . $uid);
        if ($menu) {
            return $menu;
        }

        // 设置用户菜单并获取
        $menu = static::setUserMenu($uid);
        if ($menu) {
            return $menu;
        }

        return [];
    }

    /**
     * 设置用户菜单
     */
    public static function setUserMenu($uid): array
    {
        $cache = static::cacheConfig();
        $tag = [];
        $tag[] = $cache['tag'];
        $logic = new SystemMenuLogic();
        if ($uid == 1) {
            $data = $logic->getAllMenus();
        } else {
            $roleIds = SystemUserRole::where('user_id', $uid)->column('role_id');
            $data = $logic->getMenuByRole($roleIds);
            if (empty($data)) {
                return [];
            }
        }

        // 保存到缓存
        Cache::tag($tag)->set($cache['prefix'] . $uid, $data, $cache['expire']);
        return $data;
    }

    /**
     * 清理用户缓存
     */
    public static function clearUserMenu($uid): bool
    {
        $cache = static::cacheConfig();
        return Cache::delete($cache['prefix'] . $uid);
    }

    /**
     * 清理所有菜单缓存
     * @return bool
     */
    public static function clearMenuCache(): bool
    {
        $cache = static::cacheConfig();
        return Cache::tag($cache['tag'])->clear();
    }

}
