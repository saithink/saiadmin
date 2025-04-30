<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\system;

use plugin\saiadmin\basic\BaseLogic;
use plugin\saiadmin\exception\ApiException;
use plugin\saiadmin\app\model\system\SystemDictType;
use plugin\saiadmin\app\model\system\SystemDictData;
use think\facade\Db;

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
    public function destroy($ids)
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

}
