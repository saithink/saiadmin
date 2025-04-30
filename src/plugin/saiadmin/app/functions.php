<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
use Webman\Route;
use support\Cache;
use support\Response;
use Tinywan\Jwt\JwtToken;
use plugin\saiadmin\exception\ApiException;
use plugin\saiadmin\app\model\system\SystemDictData;
use plugin\saiadmin\app\logic\system\SystemConfigLogic;

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
     * 快速注册路由[index|save|update|read|changeStatus|destroy|import|export]
     * @param string $name
     * @param string $controller
     * @return void
     */
    function fastRoute(string $name, string $controller): void
    {
        $name = trim($name, '/');
        if (method_exists($controller, 'index')) Route::get("/$name/index", [$controller, 'index']);
        if (method_exists($controller, 'save')) Route::post("/$name/save", [$controller, 'save']);
        if (method_exists($controller, 'update')) Route::put("/$name/update", [$controller, 'update']);
        if (method_exists($controller, 'read')) Route::get("/$name/read", [$controller, 'read']);
        if (method_exists($controller, 'changeStatus')) Route::post("/$name/changeStatus", [$controller, 'changeStatus']);
        if (method_exists($controller, 'destroy')) Route::delete("/$name/destroy", [$controller, 'destroy']);
        if (method_exists($controller, 'import')) Route::post("/$name/import", [$controller, 'import']);
        if (method_exists($controller, 'export')) Route::post("/$name/export", [$controller, 'export']);
    }
}

if (!function_exists('downloadFile')) {
    /**
     * 下载模板
     * @param $file_name
     * @return Response
     */
    function downloadFile($file_name): Response
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
     * @return mixed
     */
    function getConfigGroup($group): mixed
    {
        $logic = new SystemConfigLogic();
        return $logic->getGroup($group);
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

if (!function_exists('dbSourceList')) {
    /**
     * 数据源列表
     * @return array
     */
    function dbSourceList(): array
    {
        $data = config('think-orm.connections');
        if (empty($data)) {
            $data = config('thinkorm.connections');
        }
        $list = [];
        foreach ($data as $k => $v) {
            $list[] = $k;
        }
        return $list;
    }
}

if (!function_exists('defaultDbSource')) {
    /**
     * 获取默认数据源
     * @return string
     */
    function defaultDbSource(): string
    {
        $config = config('think-orm');
        if (empty($config)) {
            $config = config('thinkorm');
        }
        return $config['default'] ?? 'mysql';
    }
}

if (!function_exists('dbSource')) {
    /**
     * 数据源
     * @return array
     */
    function dbSource(): array
    {
        $data = config('think-orm.connections');
        if (empty($data)) {
            $data = config('thinkorm.connections');
        }
        return $data;
    }
}