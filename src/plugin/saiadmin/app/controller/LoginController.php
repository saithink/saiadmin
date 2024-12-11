<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\controller;

use support\Request;
use support\Response;
use plugin\saiadmin\utils\Captcha;
use plugin\saiadmin\basic\OpenController;
use plugin\saiadmin\app\logic\system\SystemUserLogic;

/**
 * 登录控制器
 */
class LoginController extends OpenController
{
    /**
     * 获取验证码
     */
    public function captcha() : Response
    {
        $captcha = new Captcha();
        $result = $captcha->imageCaptcha();
        if ($result['result'] !== 1) {
            return $this->fail($result['message']);
        }
        return $this->success($result);
    }

    /**
     * 登录
     * @param Request $request
     * @return Response
     */
    public function login(Request $request): Response
    {
        $username = $request->post('username', '');
        $password = $request->post('password', '');
        $type = $request->post('type', 'pc');

        $code = $request->post('code', '');
        $uuid = $request->post('uuid', '');
        $captcha = new Captcha();
        if (!$captcha->checkCaptcha($uuid, $code)) {
            return $this->fail('验证码错误');
        }
        $logic = new SystemUserLogic();
        $data = $logic->login($username, $password, $type);
        return $this->success($data);
    }
}
