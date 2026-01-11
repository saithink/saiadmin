<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\system;

use plugin\saiadmin\basic\eloquent\BaseLogic;
use plugin\saiadmin\exception\ApiException;
use plugin\saiadmin\app\model\system\SystemDictType;
use plugin\saiadmin\app\model\system\SystemDictData;
use support\think\Db;

/**
 * 字典类型逻辑层
 */
class SystemDictTypeLogic extends BaseLogic
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->model = new SystemDictType();
    }

    /**
     * 数据更新
     */
    public function edit($id, $data): mixed
    {
        Db::startTrans();
        try {
            // 修改数据字典类型
            $result = $this->model->where('id', $id)->update($data);
            // 更新数据字典数据
            SystemDictData::where('type_id', $id)->update(['code' => $data['code']]);
            Db::commit();
            return $result;
        } catch (\Exception $e) {
            Db::rollback();
            throw new ApiException('修改数据异常，请检查');
        }
    }

    /**
     * 数据删除
     */
    public function destroy($ids): bool
    {
        Db::startTrans();
        try {
            // 删除数据字典类型
            $result = $this->model->destroy($ids);
            // 删除数据字典数据
            $typeIds = SystemDictData::whereIn('type_id', $ids)->pluck('id')->toArray();
            SystemDictData::destroy($typeIds);
            Db::commit();
            return $result;
        } catch (\Exception $e) {
            Db::rollback();
            throw new ApiException('删除数据异常，请检查');
        }
    }

    /**
     * 获取全部字典
     * @return array
     */
    public function getDictAll(): array
    {
        $data = $this->model->where('status', 1)->select('id', 'name', 'code', 'remark')
            ->with([
                'dicts' => function ($query) {
                    $query->where('status', 1)->select('id', 'type_id', 'label', 'value', 'color', 'code', 'sort')->orderBy('sort', 'desc');
                }
            ])->get()->toArray();
        return $this->packageDict($data, 'code');
    }

    /**
     * 组合数据
     * @param $array
     * @param $field
     * @return array
     */
    private function packageDict($array, $field): array
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

}
