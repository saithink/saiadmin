<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\exception;

use Throwable;
use Webman\Http\Request;
use Webman\Http\Response;
use Webman\Exception\ExceptionHandler;
use plugin\saiadmin\exception\ApiException;

/**
 * 异常处理类
 */
class Handler extends ExceptionHandler
{
    public $dontReport = [
        ApiException::class,
    ];

    public function report(Throwable $exception)
    {
        if ($this->shouldntReport($exception)) {
            return;
        }
        $logs = '';
        if ($request = \request()) {
            $user = getCurrentInfo();
            $logs .= $request->method() . ' ' . $request->uri();
            $logs .= PHP_EOL . '[request_param]: ' . json_encode($request->all());
            $logs .= PHP_EOL . '[timestamp]: ' . date('Y-m-d H:i:s');
            $logs .= PHP_EOL . '[client_ip]: ' . $request->getRealIp();
            $logs .= PHP_EOL . '[action_user]: ' . var_export($user, true);
            $logs .= PHP_EOL . '[exception_handle]: ' . get_class($exception);
            $logs .= PHP_EOL . '[exception_info]: ' . PHP_EOL . $exception;
        }
        $this->logger->error($logs);
    }

    public function render(Request $request, Throwable $exception): Response
    {
        $debug = config('app.debug', true);
        $code = $exception->getCode();
        $json = [
            'code' => $code ? $code : 500,
            'message' => $code !== 500 ? $exception->getMessage() : 'Server internal error',
            'type' => 'failed'
        ];
        if ($debug) {
            $json['request_url'] = $request->method() . ' ' . $request->uri();
            $json['timestamp'] = date('Y-m-d H:i:s');
            $json['client_ip'] = $request->getRealIp();
            $json['request_param'] = $request->all();
            $json['exception_handle'] = get_class($exception);
            $json['exception_info'] = [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => explode("\n", $exception->getTraceAsString())
            ];
        }
        return new Response(200, ['Content-Type' => 'application/json;charset=utf-8'], json_encode($json));
    }
}
