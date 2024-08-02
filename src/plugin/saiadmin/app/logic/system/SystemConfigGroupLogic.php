<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\system;

use plugin\saiadmin\app\model\system\SystemConfigGroup;
use plugin\saiadmin\basic\BaseLogic;
use plugin\saiadmin\exception\ApiException;
use plugin\saiadmin\app\model\system\SystemConfig;
use plugin\saiadmin\utils\Cache;
use plugin\saiadmin\utils\Helper;

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

    public function save($data): bool
    {
        $model = $this->model->where('code', $data['code'])->findOrEmpty();
        if (!$model->isEmpty()) {
            throw new ApiException('组标识已存在');
        }
        return $this->model->save($data);
    }

    public function destroy($id)
    {
        $model = $this->model->where('id', $id)->findOrEmpty();
        Cache::set('cfg_' . $model->code, null);
        $model->delete();
        SystemConfig::where('group_id', $id)->delete();
    }
}
