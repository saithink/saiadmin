<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\system;

use plugin\saiadmin\basic\BaseLogic;
use plugin\saiadmin\exception\ApiException;
use plugin\saiadmin\app\model\system\SystemDept;
use plugin\saiadmin\app\model\system\SystemUser;
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
     * 添加数据
     */
    public function add($data): mixed
    {
        $data = $this->handleData($data);
        $this->model->save($data);
        return $this->model->getKey();
    }

    /**
     * 修改数据
     */
    public function edit($id, $data): mixed
    {
        $oldLevel = $data['level'].",".$id;
        $data = $this->handleData($data);
        if ($data['parent_id'] == $id) {
            throw new ApiException('不能设置父级为自身');
        }
        if (in_array($id, explode(',', $data['level']))) {
			throw new ApiException('不能设置父级为下级部门');
		}
        $newLevel = $data['level'].",".$id;
        $deptIds = $this->model->whereRaw('FIND_IN_SET("'.$id.'", level) > 0')->column('id');
        $this->model->whereIn('id', $deptIds)->exp('level', "REPLACE(level, '$oldLevel', '$newLevel')")->update();
        return $this->model->update($data, ['id' => $id]);
    }

    /**
     * 数据删除
     */
    public function destroy($ids)
    {
        $num = $this->model->where('parent_id', 'in', $ids)->count();
        if ($num > 0) {
            throw new ApiException('该部门下存在子部门，请先删除子部门');
        } else {
            $count = SystemUser::where('dept_id', 'in', $ids)->count();
            if ($count > 0) {
                throw new ApiException('该部门下存在用户，请先删除或者转移用户');
            }
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
            $parentMenu = SystemDept::findOrEmpty($data['parent_id']);
            $data['level'] = $parentMenu['level'] . ',' . $parentMenu['id'];
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
        if (request()->input('tree', 'false') === 'true') {
            $query->field('id, id as value, name as label, parent_id');
        }
        $query->order('sort', 'desc');
        $query->with(['leader' => function($query) {
            $query->field('id, username, nickname');
        }]);
        $data = $this->getAll($query);
        return Helper::makeTree($data);
    }

    /**
     * 可操作部门
     * @param array $where
     * @return array
     */
    public function accessDept(array $where = []): array
    {
        $query = $this->search($where);
        $query->auth($this->adminInfo['deptList']);
        $query->field('id, id as value, name as label, parent_id');
        $query->order('sort', 'desc');
        $data = $this->getAll($query);
        foreach ($data as &$item) {
            if ($item['id'] === $this->adminInfo['dept_id']) {
                $item['disabled'] = true;
            } else {
                $item['disabled'] = false;
            }
        }
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
        $query = $logic->search($where)->alias('user')->join('sa_system_dept_leader dept', 'user.id = dept.user_id')
            ->where('dept.dept_id', $dept_id);
        return $logic->getList($query);
    }

    /**
     * 添加领导
     */
    public function addLeader($dept_id ,$users)
    {
        $model = $this->model->findOrEmpty($dept_id);
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
        $model = $this->model->findOrEmpty($id);
        $model->leader()->detach($ids);
    }

}
