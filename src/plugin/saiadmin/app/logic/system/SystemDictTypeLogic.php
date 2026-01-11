<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\system;

use plugin\saiadmin\basic\think\BaseLogic;
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
     * 添加数据
     */
    public function add($data): mixed
    {
        $model = $this->model->where('code', $data['code'])->findOrEmpty();
        if (!$model->isEmpty()) {
            throw new ApiException('该字典标识已存在');
        }
        return $this->model->save($data);
    }

    /**
     * 数据更新
     */
    public function edit($id, $data): mixed
    {
        Db::startTrans();
        try {
            // 修改数据字典类型
            $result = $this->model->update($data, ['id' => $id]);
            // 更新数据字典数据
            SystemDictData::update(['code' => $data['code']], ['type_id' => $id]);
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
            $typeIds = SystemDictData::where('type_id', 'in', $ids)->column('id');
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
        $data = $this->model->where('status', 1)->field('id, name, code, remark')
            ->with([
                'dicts' => function ($query) {
                    $query->where('status', 1)->field('id, type_id, label, value, color, code, sort')->order('sort', 'desc');
                }
            ])->select()->toArray();
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
