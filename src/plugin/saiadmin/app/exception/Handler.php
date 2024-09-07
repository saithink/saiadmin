<?php
namespace plugin\saiadmin\app\exception;

use Throwable;
use Webman\Http\Request;
use Webman\Http\Response;

/**
 * Class Handler
 * @package Support\Exception
 */
class Handler extends \support\exception\Handler
{
    public function render(Request $request, Throwable $exception): Response
    {
        $debug = config('app.debug', true);
        $code = $exception->getCode();
        $json = [
            'code' => $code ? $code : 500,
            'message' => $debug ? $exception->getMessage() : 'Server internal error',
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
                'trace' => $exception->getTrace()
            ];
        }
        return new Response(200, ['Content-Type' => 'application/json'],
            \json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }
}
