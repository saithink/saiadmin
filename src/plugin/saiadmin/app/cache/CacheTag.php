<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
declare(strict_types=1);

namespace plugin\saiadmin\app\cache;

use InvalidArgumentException;
use support\think\Cache;

/**
 * 标签缓存写入辅助类
 */
class CacheTag
{
    /**
     * 写入带标签的缓存，并在标签索引被旧值污染时自动恢复。
     *
     * @param array|string $tags
     * @param mixed $value
     */
    public static function set(array|string $tags, string $key, mixed $value, int $expire): bool
    {
        $tags = (array) $tags;

        try {
            return Cache::tag($tags)->set($key, $value, $expire);
        } catch (InvalidArgumentException $exception) {
            if ($exception->getMessage() !== 'only array cache can be push') {
                throw $exception;
            }

            $store = Cache::store();
            foreach ($tags as $tag) {
                $store->delete($store->getTagKey($tag));
            }

            return Cache::tag($tags)->set($key, $value, $expire);
        }
    }
}
