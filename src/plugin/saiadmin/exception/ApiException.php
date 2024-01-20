<?php

namespace plugin\saiadmin\exception;

use Throwable;

/**
 * 自定义异常类
 * @package plugin\saiadmin\app\exception
 */
class ApiException extends \RuntimeException
{
    public function __construct($message, $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}