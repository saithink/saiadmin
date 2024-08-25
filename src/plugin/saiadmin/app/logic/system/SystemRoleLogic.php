<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\system;

use plugin\saiadmin\app\model\system\SystemRole;
use plugin\saiadmin\basic\BaseLogic;
use plugin\saiadmin\exception\ApiException;
use plugin\saiadmin\utils\Helper;
use think\db\Query;

/**
 * 角色逻辑层
 */
class SystemRoleLogic extends BaseLogic
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->model = new SystemRole();
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
        $oldLevel = $data['level'] . "," . $where['id'];
        $data = $this->handleData($data);
        if ($data['parent_id'] == $where['id']) {
            throw new ApiException('不能设置父级为自身');
        }
        $newLevel = $data['level'].",".$where['id'];
        $roleIds = $this->model->where('level', $oldLevel)
            ->whereOr('level', 'like', $oldLevel . ',%')
            ->column('id');
        $this->model->whereIn('id', $roleIds)->exp('level', "REPLACE(level, '$oldLevel', '$newLevel')")->update();
        return $this->model->update($data, $where);
    }

    /**
     * 数据删除
     */
    public function destroy($ids, $force = false)
    {
        $num = $this->model->where('parent_id', 'in', $ids)->count();
        if ($num > 0) {
            throw new ApiException('该角色下存在子角色，请先删除子角色');
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
     * @param array $where
     * @return array
     */
    public function tree(array $where = []): array
    {
        $query = $this->search($where);
        if (request()->input('tree', 'false') === 'true') {
            $query->field('id, id as value, name as label, parent_id');
        }
        $query->auth([
            'id' => $this->adminInfo['id'],
            'roles' => $this->adminInfo['roleList']
        ]);
        if ($this->adminInfo['id'] === 1) {
            $disabled = [1];
        } else {
            $disabled = array_column($this->adminInfo['roleList'], 'id');
        }
        $query->order('sort', 'desc');
        $data = $this->getAll($query);
        if (request()->input('filter', 'true') === 'true') {
            if (!empty($disabled)) {
                foreach ($data as &$item) {
                    if (in_array($item['id'], $disabled)) {
                        $item['disabled'] = true;
                    } else {
                        $item['disabled'] = false;
                    }
                }
            }
        }
        return Helper::makeTree($data);
    }

    /**
     * 可操作角色
     * @param array $where
     * @return array
     */
    public function accessRole(array $where = []): array
    {
        $query = $this->search($where);
        $query->field('id, id as value, name as label, parent_id');
        $query->auth([
            'id' => $this->adminInfo['id'],
            'roles' => $this->adminInfo['roleList']
        ]);
        if ($this->adminInfo['id'] === 1) {
            $disabled = [1];
        } else {
            $disabled = array_column($this->adminInfo['roleList'], 'id');
        }
        $query->order('sort', 'desc');
        $data = $this->getAll($query);
        if (!empty($disabled)) {
            foreach ($data as &$item) {
                if (in_array($item['id'], $disabled)) {
                    $item['disabled'] = true;
                } else {
                    $item['disabled'] = false;
                }
            }
        }
        return Helper::makeTree($data);
    }

    public function getMenuIdsByRoleIds($ids) : array
    {
        if (empty($ids)) return [];
        return $this->model->where('id', 'in', $ids)->with(['menus' => function(Query $query) {
            $query->where('status', 1)->order('sort', 'desc');
        }])->select()->toArray();

    }

    public function getMenuByRole($id): array
    {
        $role = $this->model->find($id);
        $menus = $role->menus ?: [];
        return [
            'id' => $id,
            'menus' => $menus
        ];
    }

    public function saveMenuPermission($id, $menu_ids)
    {
        return $this->transaction(function () use ($id, $menu_ids) {
            $role = $this->model->find($id);
            if ($role) {
                $role->menus()->detach();
                $role->menus()->saveAll($menu_ids);
            }
            return true;
        });
    }

    public function getDeptByRole($id) : array
    {
        $role = $this->model->find($id);
        $depts = $role->depts?: [];
        return [
            'id' => $id,
            'depts' => $depts
        ];
    }

    public function saveDeptPermission($id, $data)
    {
        return $this->transaction(function () use ($id, $data) {
            $role = $this->model->find($id);
            $role->data_scope = $data['data_scope'];
            $result = $role->save();
            $role->depts()->detach();
            if ($result && $data['data_scope'] == 2) {
                $role->depts()->saveAll($data['dept_ids']);
            }
            return $result;
        });
    }

}
