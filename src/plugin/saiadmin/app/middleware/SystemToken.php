<?php
namespace plugin\saiadmin\app\middleware;

use plugin\saiadmin\exception\ApiException;
use Webman\Event\Event;
use Webman\Http\Request;
use Webman\Http\Response;
use Webman\MiddlewareInterface;

class SystemToken implements MiddlewareInterface
{
    /**
     * @param Request $request
     * @param callable $handler
     * @return Response
     */
    public function process(Request $request, callable $handler): Response
    {
        try {
            $rule = trim(strtolower($request->path()));
            $whiteList = config('plugin.saiadmin.saithink.white_list', []);

            if (in_array($rule, $whiteList)) {
                // 记录日志
                return $handler($request);
            }
            // 记录日志
            Event::emit('user.operateLog', true);
            return $handler($request);
        } catch (\Exception $e) {
            throw new ApiException('您的登录凭证错误或者已过期，请重新登录', 401);
        }
    }
}