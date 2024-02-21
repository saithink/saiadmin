<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\utils;

use support\Redis;

/**
 * 缓存管理
 */
class Cache
{

    public static function options(): array
    {
        $isCache = config('plugin.saiadmin.saithink.cache.enable', false);
        $cacheType = config('plugin.saiadmin.saithink.cache.type', 'file');
        $cachePrefix = config('plugin.saiadmin.saithink.cache.prefix','saithink_');
        return compact('isCache', 'cacheType', 'cachePrefix');
    }

    public static function get($key)
    {
        $config = self::options();
        if (!$config['isCache']) {
            return null;
        }
        $name = $config['cachePrefix'].$key;
        if ($config['cacheType'] =='redis') {
            $result = Redis::get($name);
            if (!empty($result)) {
                return json_decode($result, true);
            } else {
                return null;
            }
        }
        if ($config['cacheType'] =='file') {
            return self::fileCache($name);
        }
        return null;
    }

    public static function set($key, $value, $expire = 0)
    {
        $config = self::options();
        if ($config['isCache']) {
            $name = $config['cachePrefix'].$key;
            if ($config['cacheType'] =='redis') {
                $value = json_encode($value, JSON_UNESCAPED_UNICODE);
                Redis::set($name, $value, $expire);
            }
            if ($config['cacheType'] =='file') {
                self::fileCache($name, $value, $expire);
            }
        }
    }

    public static function clear($key)
    {
        $config = self::options();
        if ($config['isCache']) {
            $name = $config['cachePrefix'].$key;
            if ($config['cacheType'] =='redis') {
                Redis::del($name);
            }
            if ($config['cacheType'] =='file') {
                self::fileCache($name, null);
            }
        }
    }

    public static function fileCache(string $name = null, $value = '', $expire = null)
    {
        if (is_null($name)) {
            return false;
        }
        $md5 = hash('md5', $name);
        $filename = runtime_path() . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . substr($md5, 0, 2) . DIRECTORY_SEPARATOR . substr($md5, 2) . '.php';
        if ('' === $value) {
            // 获取缓存
            if (!file_exists($filename)) {
                return false;
            }
            $content = @file_get_contents($filename);
            if (false !== $content) {
                $expire = (int) substr($content, 8, 12);
                if (0 != $expire && time() - $expire > filemtime($filename)) {
                    //缓存过期删除缓存文件
                    unlink($filename);
                    return false;
                }
                $content = substr($content, 32);
                if (function_exists('gzcompress')) {
                    //启用数据压缩
                    $content = gzuncompress($content);
                }
                return is_string($content) ? unserialize($content) : null;
            }
        } elseif (is_null($value)) {
			if (!file_exists($filename)) {
                return false;
            }
            // 删除缓存
            unlink($filename);
            return false;
        }

        // 缓存数据
        $dir = dirname($filename);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $data = serialize($value);
        if (function_exists('gzcompress')) {
            //数据压缩
            $data = gzcompress($data, 3);
        }
        $data = "<?php\n//" . sprintf('%012d', $expire) . "\n exit();?>\n" . $data;
        file_put_contents($filename, $data, LOCK_EX);
        return true;
    }
}