<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\cache;

use plugin\saiadmin\app\model\system\SystemDictType;
use support\think\Cache;

/**
 * 字典信息缓存
 */
class DictCache
{
    /**
     * 读取缓存配置
     * @return array
     */
    public static function cacheConfig(): array
    {
        return config('plugin.saiadmin.saithink.dict_cache', [
            'expire' => 60 * 60 * 24 * 365,
            'tag' => 'saiadmin:dict_cache',
        ]);
    }

    /**
     * 获取全部字典
     */
    public static function getDictAll(): array
    {
        $cache = static::cacheConfig();
        // 直接从缓存获取
        $data = Cache::get($cache['tag']);
        if ($data) {
            return $data;
        }

        // 获取信息并返回
        $data = static::setDictAll();
        if ($data) {
            return $data;
        }

        return [];
    }

    /**
     * 获取单个字典
     */
    public static function getDict($code): array
    {
        $data = static::getDictAll();
        if (isset($data['code'])) {
            return $data[$code];
        } else {
            return [];
        }
    }

    /**
     * 设置全部字典
     */
    public static function setDictAll(): array
    {
        $cache = static::cacheConfig();
        $data = SystemDictType::where('status', 1)->field('id, name, code, remark')
            ->with(['dicts' => function ($query) {
                $query->where('status', 1)->withoutField(['created_by', 'updated_by', 'create_time', 'update_time'])->order('sort desc');
            }])->select()->toArray();
        $dict = static::packageDict($data, 'code');

        Cache::set($cache['tag'], $dict, $cache['expire']);
        return $dict;
    }

    /**
     * 组合数据
     * @param $array
     * @param $field
     * @return array
     */
    private static function packageDict($array, $field): array
    {
        $result = [];
        foreach ($array as $item) {
            if (isset($item[$field])) {
                if (isset($result[$item[$field]])) {
                    $result[$item[$field]] = [($result[$item[$field]])];
                    $result[$item[$field]][] = $item['dicts'];
                } else {
                    $result[$item[$field]] = $item['dicts'];
                }
            }
        }
        return $result;
    }

    /**
     * 清除全部字典信息
     */
    public static function clear(): bool
    {
        $cache = static::cacheConfig();
        return Cache::delete($cache['tag']);
    }
}
