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
 * 用户权限缓存
 */
class UserAuthCache
{
    /**
     * 读取缓存配置
     * @return array
     */
    public static function cacheConfig(): array
    {
        return config('plugin.saiadmin.saithink.button_cache', [
            'prefix' => 'saiadmin:button_cache:user_',
            'expire' => 60 * 60 * 2,
            'all' => 'saiadmin:button_cache:all',
            'role' => 'saiadmin:button_cache:role_',
            'tag' => 'saiadmin:button_cache',
        ]);
    }

    /**
     * 获取用户的权限
     */
    public static function getUserAuth($uid): array
    {
        if (empty($uid)) {
            return [];
        }
        $cache = static::cacheConfig();
        // 直接从缓存获取
        $auth = Cache::get($cache['prefix'] . $uid);
        if ($auth) {
            return $auth;
        }

        // 设置权限并返回
        $auth = static::setUserAuth($uid);
        if ($auth) {
            return $auth;
        }

        return [];
    }

    /**
     * 设置用户的权限
     */
    public static function setUserAuth($uid): array
    {
        // 从缓存获取，直接返回
        $roleIds = SystemUserRole::where('user_id', $uid)->column('role_id');

        // 获取角色关联的菜单权限
        $data = (new SystemMenuLogic())->getAuthByRole($roleIds);
        if (empty($data)) {
            return [];
        }

        $cache = static::cacheConfig();

        $tag = [];
        $tag[] = $cache['tag'];
        if (!empty($roleIds)) {
            foreach ($roleIds as $role) {
                $tag[] = $cache['role'] . $role;
            }
        }

        // 保存到缓存
        Cache::tag($tag)->set($cache['prefix'] . $uid, $data, $cache['expire']);
        return $data;
    }

    /**
     * 获取全部权限
     */
    public static function getAllAuth(): array
    {
        $cache = static::cacheConfig();
        // 直接从缓存获取
        $auth = Cache::get($cache['all']);
        if ($auth) {
            return $auth;
        }

        $all = (new SystemMenuLogic())->getAllCode();

        // 设置权限并返回
        Cache::tag($cache['tag'])->set($cache['all'], $all, $cache['expire']);

        return $all;
    }

    /**
     * 清理缓存
     */
    public static function clearUserAuth($uid): bool
    {
        $cache = static::cacheConfig();
        return Cache::delete($cache['prefix'] . $uid);
    }

    /**
     * 清理角色缓存
     */
    public static function clearUserAuthByRoleId($role_id): bool
    {
        $cache = static::cacheConfig();
        if (is_array($role_id)) {
            $tags = [];
            foreach ($role_id as $id) {
                $tags[] = $cache['role'] . $id;
            }
        } else {
            $tags = $cache['role'] . $role_id;
        }
        return Cache::tag($tags)->clear();
    }

    /**
     * 清理所有用户缓存
     * @return bool
     */
    public static function clear(): bool
    {
        $cache = static::cacheConfig();
        return Cache::tag($cache['tag'])->clear();
    }
}
