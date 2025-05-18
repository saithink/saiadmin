<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\system;

use plugin\saiadmin\app\cache\UserAuthCache;
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
        $oldLevel = $data['level'] . "," . $id;
        $data = $this->handleData($data);
        if ($data['parent_id'] == $id) {
            throw new ApiException('不能设置父级为自身');
        }
        if (in_array($id, explode(',', $data['level']))) {
            throw new ApiException('不能设置父级为下级角色');
        }
        $query = $this->model->where('id', $id);
        $query->auth([
            'id' => $this->adminInfo['id'],
            'roles' => $this->adminInfo['roleList']
        ]);
        $model = $query->findOrEmpty();
        if ($model->isEmpty() || in_array($id, array_column($this->adminInfo['roleList'], 'id'))) {
            throw new ApiException('没有权限操作该数据');
        }
        $newLevel = $data['level'].",".$id;
        $roleIds = SystemRole::whereRaw('FIND_IN_SET("'.$id.'", level) > 0')->column('id');
        SystemRole::whereIn('id', $roleIds)->exp('level', "REPLACE(level, '$oldLevel', '$newLevel')")->update();
        return $model->save($data);
    }

    /**
     * 删除数据
     */
    public function destroy($ids)
    {
        // 判断是否所属角色下的角色
        if ($this->adminInfo['id'] > 1) {
            $roleList = $this->adminInfo['roleList'];
            $roleIds = [];
            foreach ($roleList as $item) {
                $temp = SystemRole::whereRaw('FIND_IN_SET("'.$item['id'].'", level) > 0')->column('id');
                $roleIds = array_merge($roleIds, $temp);
            }
            if (count(array_diff($ids, $roleIds)) > 0) {
                throw new ApiException('删除角色不在当前角色下');
            }
        }
        $num = SystemRole::where('parent_id', 'in', $ids)->count();
        if ($num > 0) {
            throw new ApiException('该角色下存在子角色，请先删除子角色');
        } else {
            return $this->model->destroy($ids);
        }
    }

    /**
     * 数据处理
     */
    protected function handleData($data)
    {
        if ($this->adminInfo['id'] > 1) {
            // 判断parent_id是否允许使用
            $ids = [];
            foreach ($this->adminInfo['roleList'] as $item) {
                $ids[] = $item['id'];
                $temp = SystemRole::whereRaw('FIND_IN_SET("'.$item['id'].'", level) > 0')->column('id');
                $ids = array_merge($ids, $temp);
            }
            if (!in_array($data['parent_id'], array_unique($ids))) {
                throw new ApiException('父级角色不在当前角色下');
            }
        }
        if (empty($data['parent_id'])) {
            $data['level'] = '0';
            $data['parent_id'] = 0;
        } else {
            $parentMenu = SystemRole::findOrEmpty($data['parent_id']);
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

    /**
     * 根据角色数组获取菜单
     * @param $ids
     * @return array
     */
    public function getMenuIdsByRoleIds($ids) : array
    {
        if (empty($ids)) return [];
        return $this->model->where('id', 'in', $ids)->with(['menus' => function(Query $query) {
            $query->where('status', 1)->order('sort', 'desc');
        }])->select()->toArray();

    }

    /**
     * 根据角色获取菜单
     * @param $id
     * @return array
     */
    public function getMenuByRole($id): array
    {
        $role = $this->model->findOrEmpty($id);
        $menus = $role->menus ?: [];
        return [
            'id' => $id,
            'menus' => $menus
        ];
    }

    /**
     * 保存菜单权限
     * @param $id
     * @param $menu_ids
     * @return mixed
     */
    public function saveMenuPermission($id, $menu_ids): mixed
    {
        return $this->transaction(function () use ($id, $menu_ids) {
            $role = $this->model->findOrEmpty($id);
            if ($role) {
                $role->menus()->detach();
                $role->menus()->saveAll($menu_ids);
            }
            (new UserAuthCache($this->adminInfo['id']))->clearAuthCache();
            return true;
        });
    }

}
