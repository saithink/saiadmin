<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\middleware;

use ReflectionClass;
use Webman\Event\Event;
use Webman\Http\Request;
use Webman\Http\Response;
use Webman\MiddlewareInterface;
use plugin\saiadmin\exception\ApiException;

class SystemLog implements MiddlewareInterface
{
    /**
     * @param Request $request
     * @param callable $handler
     * @return Response
     */
    public function process(Request $request, callable $handler): Response
    {

        // 通过反射获取控制器哪些方法不需要登录
        $controller = new ReflectionClass($request->controller);
        $noNeedLogin = $controller->getDefaultProperties()['noNeedLogin'] ?? [];

        // 访问的方法需要登录
        if (!in_array($request->action, $noNeedLogin)) {
            try {
                // 记录日志
                Event::emit('user.operateLog', true);
            } catch (\Throwable $e) {
                throw new ApiException('登录凭获取失败，请检查');
            }
        }

        return $handler($request);
    }
}