<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\controller;

use support\Request;
use support\Response;
use plugin\saiadmin\app\logic\system\SystemUserLogic;
use Webman\Captcha\CaptchaBuilder;
use Webman\Captcha\PhraseBuilder;

/**
 * 登录控制器
 */
class LoginController
{
    /**
     * 获取验证码
     */
    public function captcha(Request $request, string $type = 'login') : Response
    {
        $builder = new PhraseBuilder(4, 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ');
        $captcha = new CaptchaBuilder(null, $builder);
        $captcha->build(120, 36);
        $request->session()->set("captcha-$type", strtolower($captcha->getPhrase()));
        $img_content = $captcha->get();
        return response($img_content, 200, ['Content-Type' => 'image/jpeg']);
    }

    /**
     * 管理员登录
     * @return Response
     */
    public function login(Request $request)
    {
        $username = $request->post('username');
        $password = $request->post('password');

        $captcha = $request->post('code', '');
        if (strtolower($captcha) !== session('captcha-login')) {
            return json(['code' => 400, 'msg' => '验证码错误']);
        }
        $request->session()->forget('captcha-login');

        $logic = new SystemUserLogic();
        $data = $logic->login($username, $password, 'pc');

        return json(['code' => 200, 'data' => $data]);
    }
}