<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\cache;

use plugin\saiadmin\app\model\system\SystemUser;
use support\Cache;

/**
 * 用户信息缓存
 */
class UserInfoCache
{
    private string $prefix = 'user_info_';   // 缓存前置
    private string $cacheUserKey = '';       // 管理员缓存key

    private string $adminId = '';            // 管理员id

    /**
     * 初始化
     * @param string $adminId
     */
    public function __construct(string $adminId = '')
    {
        $this->adminId = $adminId;
        $this->cacheUserKey = $this->prefix  . $this->adminId;
    }

    /**
     * 通过id获取缓存管理员信息
     */
    public function getUserInfo()
    {
        // 直接从缓存获取
        $adminInfo = Cache::get($this->cacheUserKey);
        if ($adminInfo) {
            return $adminInfo;
        }

        // 获取信息并返回
        $adminInfo = $this->setUserInfo();
        if ($adminInfo) {
            return $adminInfo;
        }

        return false;
    }

    /**
     * 设置管理员信息
     */
    public function setUserInfo(): array
    {
        $admin = SystemUser::where('id', $this->adminId)->findOrEmpty();
        $data = $admin->hidden(['password'])->toArray();
        $data['roleList'] = $admin->roles->toArray() ?: [];
        $data['postList'] = $admin->posts->toArray() ?: [];
        $data['deptList'] = $admin->depts ? $admin->depts->toArray() : [];
        // 保存到缓存
        Cache::set($this->cacheUserKey, $data, 3600);
        return $data;
    }

    /**
     * 清理管理员信息缓存
     */
    public function clearUserInfo(): bool
    {
        Cache::delete($this->cacheUserKey);
        return true;
    }

}
