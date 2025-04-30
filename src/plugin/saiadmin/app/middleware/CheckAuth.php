<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\middleware;

use ReflectionClass;
use Webman\Http\Request;
use Webman\Http\Response;
use Webman\MiddlewareInterface;
use plugin\saiadmin\app\cache\UserAuthCache;
use plugin\saiadmin\exception\SystemException;

/**
 * 权限检查中间件
 */
class CheckAuth implements MiddlewareInterface
{
    public function process(Request $request, callable $handler) : Response
    {
        // 通过反射获取控制器哪些方法不需要登录
        $controller = new ReflectionClass($request->controller);
        $noNeedLogin = $controller->getDefaultProperties()['noNeedLogin'] ?? [];

        // 不登录访问，无需权限验证
        if (in_array($request->action, $noNeedLogin)) {
            return $handler($request);
        }

        // 登录信息
        $token = getCurrentInfo();
        if ($token === false) {
            throw new SystemException('权限不足，无法访问或操作');
        }

        // 系统默认超级管理员，无需权限验证
        if ($token['id'] === 1) {
            return $handler($request);
        }

        // 接口请求权限判断
        $path = $request->path();

        // 处理接口路由替换
        $replace = config('plugin.saiadmin.saithink.route_replace');
        if (isset($replace[$path])) {
            $path = $replace[$path];
        }
        $path = strtolower($path);

        // 用户权限缓存
        $userAuthCache = new UserAuthCache($token['id']);

        // 全部路由文件
        $routes = $this->formatUrl($userAuthCache->getAllUri());
        // 请求接口有权限配置则进行验证
        if (in_array($path, $routes)) {

            $allowCodes = $userAuthCache->getAdminUri() ?? [];
            $allowCodes = $this->formatUrl($allowCodes);
            if (!in_array($path, $allowCodes)) {
                throw new SystemException('权限不足，无法访问或操作');
            }
        }
        return $handler($request);
    }

    /**
     * 格式化URL
     * @param array $data
     * @return array|string[]
     */
    public function formatUrl(array $data): array
    {
        return array_map(function ($item) {
            return strtolower($item);
        }, $data);
    }

}
