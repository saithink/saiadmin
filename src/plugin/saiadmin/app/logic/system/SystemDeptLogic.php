<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\system;

use plugin\saiadmin\basic\BaseLogic;
use plugin\saiadmin\exception\ApiException;
use plugin\saiadmin\app\model\system\SystemDept;
use plugin\saiadmin\app\model\system\SystemDeptLeader;
use plugin\saiadmin\utils\Helper;
use plugin\saiadmin\utils\Arr;

/**
 * 部门逻辑层
 */
class SystemDeptLogic extends BaseLogic
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->model = new SystemDept();
    }

    /**
     * 数据保存
     */
    public function save($data)
    {
        $data = $this->handleData($data);
        return $this->model->save($data);
    }

    /**
     * 数据修改
     */
    public function update($data, $where)
    {
        $oldLevel = $data['level'].",".$where['id'];
        $data = $this->handleData($data);
        if ($data['parent_id'] == $where['id']) {
            throw new ApiException('不能设置父级为自身');
        }
        $newLevel = $data['level'].",".$where['id'];
        $deptIds = $this->model->where('level', $oldLevel)
            ->whereOr('level', 'like', $oldLevel . ',%')
            ->column('id');
        $this->model->whereIn('id', $deptIds)->exp('level', "REPLACE(level, '$oldLevel', '$newLevel')")->update();
        return $this->model->update($data, $where);
    }

    /**
     * 数据删除
     */
    public function destroy($ids, $force = false)
    {
        $num = $this->model->where('parent_id', 'in', $ids)->count();
        if ($num > 0) {
            throw new ApiException('该部门下存在子部门，请先删除子部门');
        } else {
            return $this->model->destroy($ids, $force);
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
            $parentMenu = $this->model->find((int)$data['parent_id']);
            $data['level'] = $parentMenu['level'] . ',' . $parentMenu['id'];
        }
        return $data;
    }

    /**
     * 数据树形化
     * @param $where
     * @return array
     */
    public function tree($where = []): array
    {
        $query = $this->search($where);
        if (request()->input('tree', 'false') === 'true') {
            $query->field('id, id as value, name as label, parent_id');
        }
        $data = $this->getAll($query);
        return Helper::makeTree($data);
    }

    /**
     * 领导列表
     */
    public function leaders($where = [])
    {
        $dept_id = $where['dept_id'];
        unset($where['dept_id']);
        $logic = new SystemUserLogic();
        $query = $logic->search($where)->alias('user')->join('eb_system_dept_leader dept', 'user.id = dept.user_id')
            ->where('dept.dept_id', $dept_id);
        return $logic->getList($query);
    }

    /**
     * 添加领导
     */
    public function addLeader($dept_id ,$users)
    {
        $model = $this->model->find($dept_id);
        $leader = new SystemDeptLeader();
        foreach ($users as $key => $user) {
            $info = $leader->where('user_id', $user['user_id'])->where('dept_id', $dept_id)->findOrEmpty();
            if (!$info->isEmpty()) {
                unset($users[$key]);
            }
        }
        $model->leader()->saveAll(Arr::getArrayColumn($users, 'user_id'));
    }

    /**
     * 删除领导
     */
    public function delLeader($id, $ids)
    {
        $model = $this->model->find($id);
        $model->leader()->detach($ids);
    }

}
