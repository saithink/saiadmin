<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\system;

use plugin\saiadmin\app\model\system\SystemConfigGroup;
use plugin\saiadmin\basic\BaseLogic;
use plugin\saiadmin\exception\ApiException;
use plugin\saiadmin\app\model\system\SystemConfig;
use support\Cache;
use think\facade\Db;

/**
 * 参数配置分组逻辑层
 */
class SystemConfigGroupLogic extends BaseLogic
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->model = new SystemConfigGroup();
    }

    /**
     * 删除配置信息
     */
    public function destroy($ids)
    {
        $model = $this->model->where('id', $ids)->findOrEmpty();
        if ($model->isEmpty()) {
            throw new ApiException('配置数据未找到');
        }
        if (in_array(intval($ids), [1, 2, 3])) {
            throw new ApiException('系统默认分组，无法删除');
        }
        Db::startTrans();
        try {
            // 删除配置组
            $model->delete();
            // 删除配置组数据
            $typeIds = SystemConfig::where('group_id', $ids)->column('id');
            SystemConfig::destroy($typeIds);
            Cache::delete('cfg_' . $model->code);
            Db::commit();
            return true;
        } catch (\Exception $e) {
            Db::rollback();
            throw new ApiException('删除数据异常，请检查');
        }
    }
}
