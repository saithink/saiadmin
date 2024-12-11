<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\basic;

use plugin\saiadmin\exception\ApiException;
use plugin\saiadmin\utils\Arr;
use support\Request;
use support\Response;

/**
 * 基类 控制器继承此类
 */
class OpenController
{
    /**
     * 逻辑层注入
     */
    protected $logic;

    /**
     * 构造方法
     * @access public
     */
    public function __construct()
    {
        // 控制器初始化
        $this->init();
    }

    /**
     * 成功返回json内容
     * @param array|string $data
     * @param string $msg
     * @return Response
     */
    public function success(array | string $data = [], string $msg = 'success'): Response
    {
        if (is_string($data)) {
            $msg = $data;
        }
        return json(['code' => 200, 'message' => $msg, 'data' => $data]);
    }

    /**
     * 失败返回json内容
     * @param string $msg
     * @return Response
     */
    public function fail(string $msg = 'fail'): Response
    {
        return json(['code' => 400, 'message' => $msg]);
    }

    /**
     * 初始化
     */
    protected function init()
    {
        // TODO
    }

}