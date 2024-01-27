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
        if ($request->expectsJson()) {
            $json = ['code' => $code ? $code : 500, 'message' => $debug ? $exception->getMessage() : 'Server internal error', 'type' => 'failed'];
            $debug && $json['traces'] = (string)$exception;
            return new Response(200, ['Content-Type' => 'application/json'],
                \json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }
        $error = $debug ? \nl2br((string)$exception) : 'Server internal error';
        return new Response(500, [], $error);
    }
}
