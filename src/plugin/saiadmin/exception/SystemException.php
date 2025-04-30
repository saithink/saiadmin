<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\exception;

use Throwable;

/**
 * 系统接口错误-返回json数据,并且记录异常日志
 */
class SystemException extends \RuntimeException
{
    public function __construct($message, $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}