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
use Tinywan\Jwt\JwtToken;
use plugin\saiadmin\exception\ApiException;

/**
 * 登录检查中间件
 */
class CheckLogin implements MiddlewareInterface
{
    public function process(Request $request, callable $handler): Response
    {
        // 通过反射获取控制器哪些方法不需要登录
        $controller = new ReflectionClass($request->controller);
        $noNeedLogin = $controller->getDefaultProperties()['noNeedLogin'] ?? [];

        // 访问的方法需要登录
        if (!in_array($request->action, $noNeedLogin)) {
            try {
                $token = JwtToken::getExtend();
                $request->setHeader('check_login', true);
                $request->setHeader('check_admin', $token);
            } catch (\Throwable $e) {
                throw new ApiException('您的登录凭证错误或者已过期，请重新登录', 401);
            }
        }
        return $handler($request);
    }
}
