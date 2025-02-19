<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
use Tinywan\Jwt\JwtToken;
use plugin\saiadmin\exception\ApiException;
use plugin\saiadmin\app\logic\system\SystemConfigLogic;
use plugin\saiadmin\app\model\system\SystemDictData;
use support\Response;
use Webman\Route;
use support\Cache;

if (!function_exists('getCurrentInfo')) {
    /**
     * 获取当前登录用户
     */
    function getCurrentInfo(): bool|array
    {
        if (!request()) {
            return false;
        }
        try {
            $token = JwtToken::getExtend();
        } catch (\Throwable $e) {
            return false;
        }
        return $token;
    }
}

if (!function_exists('fastRoute')) {
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
        if (method_exists($controller, 'realDestroy')) Route::delete("/$name/realDestroy", [$controller, 'realDestroy']);
        if (method_exists($controller, 'recovery')) Route::post("/$name/recovery", [$controller, 'recovery']);
        if (method_exists($controller, 'import')) Route::post("/$name/import", [$controller, 'import']);
        if (method_exists($controller, 'export')) Route::post("/$name/export", [$controller, 'export']);
    }
}

if (!function_exists('fastNormalRoute')) {
    /**
     * 快速注册常规路由[index|save|update|read|changeStatus|destroy|recycle|recovery|import|export]
     * @param string $name
     * @param string $controller
     * @return void
     */
    function fastNormalRoute(string $name, string $controller)
    {
        $name = trim($name, '/');
        if (method_exists($controller, 'index')) Route::get("/$name/index", [$controller, 'index']);
        if (method_exists($controller, 'save')) Route::post("/$name/save", [$controller, 'save']);
        if (method_exists($controller, 'update')) Route::put("/$name/update", [$controller, 'update']);
        if (method_exists($controller, 'read')) Route::get("/$name/read", [$controller, 'read']);
        if (method_exists($controller, 'changeStatus')) Route::post("/$name/changeStatus", [$controller, 'changeStatus']);
        if (method_exists($controller, 'destroy')) Route::delete("/$name/destroy", [$controller, 'destroy']);
        if (method_exists($controller, 'recycle')) Route::get("/$name/recycle", [$controller, 'recycle']);
        if (method_exists($controller, 'realDestroy')) Route::delete("/$name/realDestroy", [$controller, 'realDestroy']);
        if (method_exists($controller, 'recovery')) Route::post("/$name/recovery", [$controller, 'recovery']);
        if (method_exists($controller, 'import')) Route::post("/$name/import", [$controller, 'import']);
        if (method_exists($controller, 'export')) Route::post("/$name/export", [$controller, 'export']);
    }
}

if (!function_exists('downloadFile')) {
    /**
     * 下载模板
     * @param $file_name
     * @return Response|\Webman\Http\Response
     */
    function downloadFile($file_name)
    {
        $base_dir = config('plugin.saiadmin.saithink.template',base_path().'/public/template');
        if (file_exists($base_dir. DIRECTORY_SEPARATOR.$file_name)) {
            return response()->download($base_dir. DIRECTORY_SEPARATOR.$file_name, urlencode($file_name));
        } else {
            throw new ApiException('模板不存在');
        }
    }
}

if (!function_exists('formatBytes')) {
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
}

if (!function_exists('getConfigGroup')) {
    /**
     * 读取配置组
     * @param $group
     * @return bool|mixed
     */
    function getConfigGroup($group)
    {
        $logic = new SystemConfigLogic();
        return $logic->getGroup($group);
    }
}

if (!function_exists('remoteVue')) {
    /**
     * 注册远程vue文件读取路由
     * @param string $plugin 插件名称
     * @param string $path 内部文件路径
     * @param bool $is_group 是否在分组路由内部
     * @return void
     */
    function remoteVue(string $plugin, string $path, bool $is_group = true)
    {
        Route::get(($is_group ? "" : "/$plugin") . $path, function () use ($plugin, $path) {
            $path = base_path().'/plugin/'.$plugin.'/remote'.$path;
            if (file_exists($path)) {
                return response()->file($path);
            } else {
                return response('Not Found', 404);
            }
        });
    }
}

if (!function_exists('dictDataList')) {
    /**
     * 根据字典编码获取字典列表
     * @param string $code 字典编码
     * @return array
     */
    function dictDataList(string $code): array
    {

        $data = Cache::get($code);
        if ($data) {
            return $data;
        }
        $model = new SystemDictData;
        $query = $model->where('status', 1)->where('code', $code)->field('id, label, value')->order('sort desc');
        $data = $query->select()->toArray();
        Cache::set($code, $data);
        return $data;
    }
}