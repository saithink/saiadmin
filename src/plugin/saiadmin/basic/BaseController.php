<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\basic;

use plugin\saiadmin\app\cache\UserInfoCache;
use plugin\saiadmin\exception\ApiException;

/**
 * 基类 控制器继承此类
 */
class BaseController extends OpenController
{

    /**
     * 当前登陆管理员信息
     */
    protected $adminInfo;

    /**
     * 当前登陆管理员ID
     */
    protected int $adminId;

    /**
     * 当前登陆管理员账号
     */
    protected string $adminName;

    /**
     * 逻辑层注入
     */
    protected $logic;

    /**
     * 验证器注入
     */
    protected $validate;

    /**
     * 初始化
     */
    protected function init(): void
    {
        // 登录模式赋值
        $isLogin = request()->header('check_login', false);
        if ($isLogin) {
            $result = request()->header('check_admin');
            $this->adminId = $result['id'];
            $this->adminName = $result['username'];
            $this->adminInfo = UserInfoCache::getUserInfo($result['id']);

            // 用户数据传递给逻辑层
            $this->logic && $this->logic->init($this->adminInfo);
        }
    }

    /**
     * 验证器调用
     */
    protected function validate(string $scene, $data): bool
    {
        if ($this->validate) {
            if (!$this->validate->scene($scene)->check($data)) {
                throw new ApiException($this->validate->getError());
            }
        }
        return true;
    }

}
