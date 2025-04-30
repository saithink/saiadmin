<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\utils;

use support\Cache;
use Ramsey\Uuid\Uuid;
use Webman\Captcha\CaptchaBuilder;
use Webman\Captcha\PhraseBuilder;
use plugin\saiadmin\exception\ApiException;

/**
 * 验证码工具类
 */
class Captcha
{
    /**
     * 图形验证码
     * @return array
     */
    public static function imageCaptcha(): array
    {
        $builder = new PhraseBuilder(4, 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ');
        $captcha = new CaptchaBuilder(null, $builder);
        $captcha->setBackgroundColor(242, 243, 245);
        $captcha->build(120, 36);

        $uuid = Uuid::uuid4();
        $key = $uuid->toString();
        $mode = config('plugin.saiadmin.saithink.captcha.mode', 'session');
        $expire = config('plugin.saiadmin.saithink.captcha.expire', 300);
        $code = strtolower($captcha->getPhrase());
        if ($mode === 'cache') {
            try {
                Cache::set($key, $code, $expire);
            } catch (\Exception $e) {
                return [
                    'result' => -1,
                    'message' => '验证码获取失败，请检查缓存配置'
                ];
            }
        } else {
            request()->session()->set($key, $code);
        }
        $img_content = $captcha->get();
        return [
            'result' => 1,
            'uuid' => $key,
            'image' => 'data:image/png;base64,' . base64_encode($img_content)
        ];
    }

    /**
     * 数字验证码
     * @param string $key
     * @param int $length
     * @return array
     */
    public static function numberCaptcha(string $key, int $length = 4): array
    {
        $code   = str_pad(rand(0, 999999), $length, '0', STR_PAD_LEFT);
        $mode = config('plugin.saiadmin.saithink.captcha.mode', 'session');
        $expire = config('plugin.saiadmin.saithink.captcha.expire', 300);
        if ($mode === 'cache') {
            try {
                Cache::set($key, $code, $expire);
            } catch (\Exception $e) {
                return [
                    'result' => -1,
                    'message' => '验证码获取失败，请检查缓存配置'
                ];
            }
        } else {
            request()->session()->set($key, $code);
        }
        return [
            'result' => 1,
            'uuid'  => $key,
            'code' => $code,
        ];
    }

    /**
     * 验证码验证
     * @param string $uuid
     * @param string|int $captcha
     * @return bool
     */
    public static function checkCaptcha(string $uuid, string|int $captcha): bool
    {
        $mode = config('plugin.saiadmin.saithink.captcha.mode', 'session');
        if ($mode === 'cache') {
            try {
                $code = Cache::get($uuid);
                Cache::delete($uuid);
            } catch (\Exception $e) {
                throw new ApiException($e->getMessage());
            }
        } else {
            try {
                $code = session($uuid);
                session()->forget($uuid);
            } catch (\Exception $e) {
                throw new ApiException($e->getMessage());
            }
        }
        if (strtolower($captcha) !== $code) {
            return false;
        }
        return true;
    }
}
