<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\system;

use plugin\saiadmin\app\cache\ConfigCache;
use plugin\saiadmin\app\model\system\SystemConfig;
use plugin\saiadmin\app\model\system\SystemConfigGroup;
use plugin\saiadmin\basic\think\BaseLogic;
use plugin\saiadmin\exception\ApiException;
use plugin\saiadmin\utils\Helper;

/**
 * 参数配置逻辑层
 */
class SystemConfigLogic extends BaseLogic
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->model = new SystemConfig();
    }

    /**
     * 添加数据
     * @param mixed $data
     * @return mixed
     */
    public function add($data): mixed
    {
        $result = $this->model->create($data);
        $group = SystemConfigGroup::find($data['group_id']);
        ConfigCache::clearConfig($group->code);
        return $result;
    }

    /**
     * 编辑数据
     * @param mixed $id
     * @param mixed $data
     * @return bool
     */
    public function edit($id, $data): bool
    {
        $result = parent::edit($id, $data);
        $group = SystemConfigGroup::find($data['group_id']);
        ConfigCache::clearConfig($group->code);
        return $result;
    }

    /**
     * 批量更新
     * @param mixed $group_id
     * @param mixed $config
     * @return bool
     */
    public function batchUpdate($group_id, $config): bool
    {
        $group = SystemConfigGroup::find($group_id);
        if (!$group) {
            throw new ApiException('配置组未找到');
        }
        $saveData = [];
        foreach ($config as $key => $value) {
            $saveData[] = [
                'id' => $value['id'],
                'group_id' => $group_id,
                'name' => $value['name'],
                'key' => $value['key'],
                'value' => $value['value']
            ];
        }
        // upsert: 根据 id 更新，如果不存在则插入
        $this->model->saveAll($saveData);
        ConfigCache::clearConfig($group->code);
        return true;
    }

    /**
     * 获取配置数据
     * @param mixed $code
     * @return array
     */
    public function getData($code): array
    {
        $group = SystemConfigGroup::where('code', $code)->findOrEmpty();
        if (empty($group)) {
            return [];
        }
        $config = SystemConfig::where('group_id', $group['id'])->select()->toArray();
        return $config;
    }

    /**
     * 获取配置组
     */
    public function getGroup($config): array
    {
        return ConfigCache::getConfig($config);
    }

}
