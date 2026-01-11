<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\middleware;

use Webman\Http\Request;
use Webman\Http\Response;
use Webman\MiddlewareInterface;
use plugin\saiadmin\app\cache\UserAuthCache;
use plugin\saiadmin\app\cache\ReflectionCache;
use plugin\saiadmin\exception\SystemException;

/**
 * 权限检查中间件
 */
class CheckAuth implements MiddlewareInterface
{

    public function process(Request $request, callable $handler) : Response
    {
        $controller = $request->controller;
        $action = $request->action;

        // 通过反射获取控制器哪些方法不需要登录
        $noNeedLogin = ReflectionCache::getNoNeedLogin($controller);

        // 不登录访问，无需权限验证
        if (in_array($action, $noNeedLogin)) {
            return $handler($request);
        }

        // 登录信息
        $token = getCurrentInfo();
        if ($token === false) {
            throw new SystemException('用户信息读取失败，无法访问或操作');
        }

        // 系统默认超级管理员，无需权限验证
        if ($token['id'] === 1) {
            return $handler($request);
        }

        // 2. 获取接口权限属性 (使用缓存类)
        $permissions = ReflectionCache::getPermissionAttributes($controller, $action);

        if (!empty($permissions) && !empty($permissions['slug'])) {
            // 用户权限缓存
            $auth = UserAuthCache::getUserAuth($token['id']);

            if (!$this->checkPermissions($permissions, $auth)) {
                throw new SystemException('权限不足，无法访问或操作');
            }
        }

        return $handler($request);
    }

    /**
     * 检查权限
     */
    private function checkPermissions(array $attr, array $userPermissions): bool
    {
        // 直接对比 slug
        return in_array($attr['slug'], $userPermissions);
    }

}
