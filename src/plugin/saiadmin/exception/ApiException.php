<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\exception;

use Webman\Http\Request;
use Webman\Http\Response;
use support\exception\BusinessException;

/**
 * 常规操作异常-只返回json数据,不记录异常日志
 */
class ApiException extends BusinessException
{
    public function render(Request $request): ?Response
    {
        return json(['code' => $this->getCode() ?: 500, 'message' => $this->getMessage()]);
    }
}