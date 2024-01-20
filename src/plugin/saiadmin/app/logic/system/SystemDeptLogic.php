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
use plugin\saiadmin\app\logic\system\SystemUserLogic;
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
        $data = $this->handleData($data);
        return $this->model->update($data, $where);
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
        return $this->getList($query);
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
