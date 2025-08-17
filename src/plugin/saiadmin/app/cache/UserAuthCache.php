<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\cache;

use support\Cache;
use plugin\saiadmin\app\logic\system\SystemMenuLogic;

/**
 * 用户权限缓存
 */
class UserAuthCache
{
    private string $prefix = 'user_auth_'; // 缓存前缀
    private array $authCodeList = [];      // 全部权限列表
    private string $cacheMd5Key = '';      // 权限文件MD5的key
    private string $cacheAllKey = '';      // 全部权限的key
    private string $cacheUrlKey = '';      // 管理员的url缓存key
    private string $authMd5 = '';          // 权限文件MD5的值
    private string $adminId = '';          // 管理员id

    /**
     * 初始化
     * @param string $adminId
     */
    public function __construct(string $adminId = '')
    {
        $this->adminId = $adminId;

        // 全部权限
        $this->authCodeList = (new SystemMenuLogic())->getAllCode();
        // 当前权限配置文件的md5
        $this->authMd5 = md5(json_encode($this->authCodeList));

        $this->cacheMd5Key = $this->prefix . 'md5';
        $this->cacheAllKey = $this->prefix . 'all';
        $this->cacheUrlKey = $this->prefix . 'url_' . $this->adminId;

        $cacheAuthMd5 = Cache::get($this->cacheMd5Key);
        $cacheAuth = Cache::get($this->cacheAllKey);

        //权限配置和缓存权限对比，不一样说明权限配置文件已修改，清理缓存
        if ($this->authMd5 !== $cacheAuthMd5 || empty($cacheAuth)) {
            Cache::deleteMultiple([
                $this->cacheMd5Key,
                $this->cacheAllKey,
                $this->cacheUrlKey
            ]);
        }
    }

    /**
     * 获取全部权限uri
     */
    public function getAllUri()
    {
        // 从缓存获取，直接返回
        $cacheAuth = Cache::get($this->cacheAllKey);
        if ($cacheAuth) {
            return $cacheAuth;
        }

        // 获取全部权限
        $authList = (new SystemMenuLogic)->getAllCode();

        // 保存到缓存并读取返回
        Cache::set($this->cacheMd5Key, $this->authMd5);
        Cache::set($this->cacheAllKey, $authList);
        return $authList;
    }

    /**
     * 获取管理权限uri
     */
    public function getAdminUri()
    {
        // 从缓存获取，直接返回
        $urisAuth = Cache::get($this->cacheUrlKey);
        if ($urisAuth) {
            return $urisAuth;
        }

        // 获取角色关联的菜单id(菜单或权限)
        $urisAuth = (new SystemMenuLogic)->getAuthByAdminId($this->adminId);
        if (empty($urisAuth)) {
            return [];
        }

        // 保存到缓存
        Cache::set($this->cacheUrlKey, $urisAuth, 3600);
        return $urisAuth;
    }

    /**
     * 清理用户权限缓存
     */
    public function clearUserCache(): bool
    {
        Cache::delete($this->cacheUrlKey);
        return true;
    }

    /**
     * 清理缓存
     */
    public function clearAuthCache(): bool
    {
        Cache::delete($this->cacheAllKey);
        return true;
    }

}
