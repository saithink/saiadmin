<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\controller;

use support\Redis;
use support\Request;
use support\Response;
use plugin\saiadmin\app\logic\system\SystemUserLogic;
use Webman\Captcha\CaptchaBuilder;
use Webman\Captcha\PhraseBuilder;
use Ramsey\Uuid\Uuid;

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

        $uuid = Uuid::uuid4();
        $key = $uuid->toString();
        $mode = config('plugin.saiadmin.saithink.captcha.mode', 'session');
        $expire = config('plugin.saiadmin.saithink.captcha.expire', 300);
        $code = strtolower($captcha->getPhrase());
        if ($mode === 'redis') {
            try {
                Redis::set($key, $code, 'EX',$expire);
            } catch (\Exception $e) {
                return json(['code' => -1, 'msg' => '验证码生成失败，请检查Redis配置']);
            }
        } else {
            $request->session()->set($key, $code);
        }
        $img_content = $captcha->get();
        return json(['code' => 200, 'uuid' => $key, 'img' => base64_encode($img_content)]);
    }

    /**
     * 管理员登录
     * @return Response
     */
    public function login(Request $request)
    {
        $username = $request->post('username');
        $password = $request->post('password');
        $type = $request->post('type', 'pc');

        $captcha = $request->post('code', '');
        $uuid = $request->post('uuid', '');
        $mode = config('plugin.saiadmin.saithink.captcha.mode', 'session');
        if ($mode === 'redis') {
            try {
                $code = Redis::get($uuid);
                Redis::del($uuid);
            } catch (\Exception $e) {
                return json(['code' => -1, 'msg' => '验证码获取失败，请检查Redis配置']);
            }
        } else {
            $code = session($uuid);
            $request->session()->forget($uuid);
        }
        if (strtolower($captcha) !== $code) {
            return json(['code' => 400, 'msg' => '验证码错误']);
        }
        $logic = new SystemUserLogic();
        $data = $logic->login($username, $password, $type);

        return json(['code' => 200, 'data' => $data]);
    }
}