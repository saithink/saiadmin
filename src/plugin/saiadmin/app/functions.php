<?php

use plugin\saiadmin\utils\Cache;
use plugin\saiadmin\utils\JwtAuth;
use plugin\saiadmin\exception\ApiException;
use plugin\saiadmin\app\logic\system\SystemConfigGroupLogic;
use support\Response;
use Webman\Route;

/**
 * 获取当前登录用户
 */
function getCurrentInfo()
{
    if (!request()) {
        return false;
    }
    $header = request()->header(config('plugin.saiadmin.saithink.cross.token_name', 'Authori-zation'));
    if ($header) {
        $token = trim($header);
        if ($token !== 'null' && $token !== '') {
            $jwt = new JwtAuth();
            [$id, $username, $type] = $jwt->parseToken($token);
            return compact('id', 'username', 'type');
        } else {
            return false;
        }
    } else {
        throw new ApiException('请通过正确的方式进行访问');
    }
}

/**
 * 快速注册路由[index|save|update|read|changeStatus|destroy|recycle|recovery|import|export]
 * @param string $name
 * @param string $controller
 * @return void
 */
function fastRoute(string $name, string $controller)
{
    $name = trim($name, '/');
    if (method_exists($controller, 'index')) Route::get("/$name/index", [$controller, 'index']);
    if (method_exists($controller, 'save')) Route::post("/$name/save", [$controller, 'save']);
    if (method_exists($controller, 'update')) Route::put("/$name/update/{id}", [$controller, 'update']);
    if (method_exists($controller, 'read')) Route::get("/$name/read/{id}", [$controller, 'read']);
    if (method_exists($controller, 'changeStatus')) Route::post("/$name/changeStatus", [$controller, 'changeStatus']);
    if (method_exists($controller, 'destroy')) Route::delete("/$name/destroy", [$controller, 'destroy']);
    if (method_exists($controller, 'recycle')) Route::get("/$name/recycle", [$controller, 'recycle']);
    if (method_exists($controller, 'recovery')) Route::post("/$name/recovery", [$controller, 'recovery']);
    if (method_exists($controller, 'import')) Route::post("/$name/import", [$controller, 'import']);
    if (method_exists($controller, 'export')) Route::post("/$name/export", [$controller, 'export']);
}

/**
 * 下载模板
 * @param $file_name
 * @return Response|\Webman\Http\Response
 */
function downloadFile($file_name)
{
    $base_dir = base_path(). '/plugin/saiadmin/public/template';
    if (file_exists($base_dir. DIRECTORY_SEPARATOR.$file_name)) {
        return response()->download($base_dir. DIRECTORY_SEPARATOR.$file_name, urlencode($file_name));
    } else {
        throw new ApiException('模板不存在');
    }
}

/**
 * 根据字节计算大小
 * @param $bytes
 * @return string
 */
function formatBytes($bytes): string
{
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    for ($i = 0; $bytes > 1024; $i++) {
        $bytes /= 1024;
    }
    return round($bytes, 2) . ' ' . $units[$i];
}

/**
 * 读取配置
 * @param $group
 * @return bool|mixed
 */
function getConfigGroup($group)
{
    $logic = new SystemConfigGroupLogic();
    $model = $logic->where('code', $group)->find();
    return $model->configs->toArray();
}
