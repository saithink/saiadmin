<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\cache;

use plugin\saiadmin\app\model\system\SystemUser;
use support\think\Cache;

/**
 * 用户信息缓存
 */
class UserInfoCache
{
    /**
     * 读取缓存配置
     * @return array
     */
    public static function cacheConfig(): array
    {
        return config('plugin.saiadmin.saithink.user_cache', [
            'prefix' => 'saiadmin:user_cache:info_',
            'expire' => 60 * 60 * 4,
            'dept' => 'saiadmin:user_cache:dept_',
            'role' => 'saiadmin:user_cache:role_',
            'post' => 'saiadmin:user_cache:post_',
        ]);
    }

    /**
     * 通过id获取缓存管理员信息
     */
    public static function getUserInfo($uid): array
    {
        if (empty($uid)) {
            return [];
        }
        $cache = static::cacheConfig();
        // 直接从缓存获取
        $adminInfo = Cache::get($cache['prefix'] . $uid);

        if ($adminInfo) {
            return $adminInfo;
        }

        // 获取缓存信息并返回
        $adminInfo = static::setUserInfo($uid);
        if ($adminInfo) {
            return $adminInfo;
        }

        return [];
    }

    /**
     * 设置管理员信息
     */
    public static function setUserInfo($uid): array
    {
        $admin = SystemUser::where('id', $uid)->findOrEmpty();
        $data = $admin->hidden(['password'])->toArray();
        $data['roleList'] = $admin->roles->toArray() ?: [];
        $data['postList'] = $admin->posts->toArray() ?: [];
        $data['deptList'] = $admin->depts ? $admin->depts->toArray() : [];

        $cache = static::cacheConfig();

        $tags = [];
        if (!empty($data['deptList'])) {
            $tags[] = $cache['dept'] . $data['deptList']['id'];
        }
        if (!empty($data['roleList'])) {
            foreach ($data['roleList'] as $role) {
                $tags[] = $cache['role'] . $role['id'];
            }
        }
        if (!empty($data['postList'])) {
            foreach ($data['postList'] as $post) {
                $tags[] = $cache['post'] . $post['id'];
            }
        }
        Cache::tag($tags)->set($cache['prefix'] . $uid, $data, $cache['expire']);
        return $data;
    }

    /**
     * 清理管理员信息缓存
     */
    public static function clearUserInfo($uid): bool
    {
        $cache = static::cacheConfig();
        return Cache::delete($cache['prefix'] . $uid);
    }

    /**
     * 清理部门下所有用户缓存
     */
    public static function clearUserInfoByDeptId($dept_id): bool
    {
        $cache = static::cacheConfig();
        if (is_array($dept_id)) {
            $tags = [];
            foreach ($dept_id as $id) {
                $tags[] = $cache['dept'] . $id;
            }
        } else {
            $tags = $cache['dept'] . $dept_id;
        }
        return Cache::tag($tags)->clear();
    }

    /**
     * 清理角色下所有用户缓存
     */
    public static function clearUserInfoByRoleId($role_id): bool
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
     * 清理岗位下所有用户缓存
     */
    public static function clearUserInfoByPostId($post_id): bool
    {
        $cache = static::cacheConfig();
        if (is_array($post_id)) {
            $tags = [];
            foreach ($post_id as $id) {
                $tags[] = $cache['post'] . $id;
            }
        } else {
            $tags = $cache['post'] . $post_id;
        }
        return Cache::tag($tags)->clear();
    }

}
