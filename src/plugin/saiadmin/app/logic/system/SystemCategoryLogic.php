<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\system;

use plugin\saiadmin\basic\think\BaseLogic;
use plugin\saiadmin\exception\ApiException;
use plugin\saiadmin\app\model\system\SystemCategory;
use plugin\saiadmin\utils\Helper;
use plugin\saiadmin\utils\Arr;

/**
 * 附件分类逻辑层
 */
class SystemCategoryLogic extends BaseLogic
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->model = new SystemCategory();
    }

    /**
     * 添加数据
     */
    public function add($data): bool
    {
        $data = $this->handleData($data);
        return $this->model->save($data);
    }

    /**
     * 修改数据
     */
    public function edit($id, $data): bool
    {
        $data = $this->handleData($data);
        if ($data['parent_id'] == $id) {
            throw new ApiException('上级分类和当前分类不能相同');
        }
        if (in_array($id, explode(',', $data['level']))) {
            throw new ApiException('不能将上级分类设置为当前分类的子分类');
        }
        $model = $this->model->findOrEmpty($id);
        if ($model->isEmpty()) {
            throw new ApiException('数据不存在');
        }
        return $model->save($data);
    }

    /**
     * 数据删除
     */
    public function destroy($ids): bool
    {
        $num = $this->model->where('parent_id', 'in', $ids)->count();
        if ($num > 0) {
            throw new ApiException('该部门下存在子分类，请先删除子分类');
        } else {
            return $this->model->destroy($ids);
        }
    }

    /**
     * 数据处理
     */
    protected function handleData($data)
    {
        if (empty($data['parent_id']) || $data['parent_id'] == 0) {
            $data['level'] = '0';
            $data['parent_id'] = 0;
        } else {
            $parentMenu = SystemCategory::findOrEmpty($data['parent_id']);
            $data['level'] = $parentMenu['level'] . $parentMenu['id'] . ',';
        }
        return $data;
    }

    /**
     * 数据树形化
     * @param array $where
     * @return array
     */
    public function tree(array $where = []): array
    {
        $query = $this->search($where);
        $request = request();
        if ($request && $request->input('tree', 'false') === 'true') {
            $query->field('id, id as value, category_name as label, parent_id, category_name, sort');
        }
        $query->order('sort', 'desc');
        $data = $this->getAll($query);
        return Helper::makeTree($data);
    }

}
