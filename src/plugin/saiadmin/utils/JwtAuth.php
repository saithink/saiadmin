<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\utils;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use plugin\saiadmin\exception\ApiException;

/**
 * JWT认证类
 * Class JwtAuth
 * @package plugin\saiadmin\utils
 */
class JwtAuth
{
    /**
     * token
     * @var string
     */
    protected $token;

    public $key = 'saithink';

    /**
     * 获取token
     * @param int $id
     * @param string $username
     * @param string $type
     * @param array $params
     * @return array
     */
    public function getToken(int $id, string $username, string $type, array $params = []): array
    {
        $host = request()->host();
        $time = time();
        $hour = config('plugin.saiadmin.saithink.cross.token_expire', 6);
        $params += [
            'iss' => $host,
            'aud' => $host,
            'iat' => $time,
            'nbf' => $time,
            'exp' => strtotime('+ '.$hour.'hour'),
        ];
        $params['jti'] = compact('id','username', 'type');
        $token = JWT::encode($params, $this->key, 'HS256');
        return compact('token', 'params');
    }

    /**
     * 解析token
     * @param string $jwt
     * @return array
     */
    public function parseToken(string $jwt): array
    {
        try {
            $this->token = $jwt;
            $decoded = JWT::decode($jwt, new Key($this->key, 'HS256'));
            $json = json_decode(json_encode($decoded), true);
            return [$json['jti']['id'], $json['jti']['username'], $json['jti']['type']];
        } catch (\Exception $e) {
            throw new ApiException('登录状态已过期，需要重新登录');
        }
    }

    /**
     * 创建token
     * @param int $id
     * @param string $username
     * @param string $type
     * @param array $params
     * @return array
     */
    public function createToken(int $id, string $username, string $type, array $params = [])
    {
        $tokenInfo = $this->getToken($id, $username, $type, $params);
        $exp = $tokenInfo['params']['exp'] - $tokenInfo['params']['iat'] + 60;
        return $tokenInfo;
    }
}
