<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\system;

use plugin\saiadmin\app\model\system\SystemMenu;
use plugin\saiadmin\app\model\system\SystemRoleMenu;
use plugin\saiadmin\app\model\system\SystemUserRole;
use plugin\saiadmin\basic\BaseLogic;
use plugin\saiadmin\exception\ApiException;
use plugin\saiadmin\utils\Arr;
use plugin\saiadmin\utils\Helper;

/**
 * 菜单逻辑层
 */
class SystemMenuLogic extends BaseLogic
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->model = new SystemMenu();
    }

    /**
     * 数据添加
     */
    public function add($data): mixed
    {
        $data = $this->handleData($data);
        return $this->model->save($data);
    }

    /**
     * 数据修改
     */
    public function edit($id, $data): mixed
    {
        $data = $this->handleData($data);
        if ($data['parent_id'] == $id) {
            throw new ApiException('不能设置父级为自身');
        }
        return $this->model->update($data, ['id' => $id]);
    }

    /**
     * 数据删除
     */
    public function destroy($ids)
    {
        $num = $this->model->where('parent_id', 'in', $ids)->count();
        if ($num > 0) {
            throw new ApiException('该菜单下存在子菜单，请先删除子菜单');
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
            $data['type'] = $data['type'] === 'B' ? 'M' : $data['type'];
        } else {
            $parentMenu = $this->model->findOrEmpty($data['parent_id']);
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
        $query->order('sort', 'desc');
        $data = $this->getAll($query);
        return Helper::makeTree($data);
    }

    /**
     * 权限菜单
     * @return array
     */
    public function auth(): array
    {
        $roleLogic = new SystemRoleLogic();
        $role_ids = Arr::getArrayColumn($this->adminInfo['roleList'], 'id');
        $roles = $roleLogic->getMenuIdsByRoleIds($role_ids);
        $ids = $this->filterMenuIds($roles);
        $query = $this->model
            ->field('id, id as value, name as label, parent_id')
            ->where('status', 1)
            ->where('id', 'in', $ids)
            ->order('sort', 'desc');
        $data = $this->getAll($query);
        return Helper::makeTree($data);
    }

    /**
     * 获取全部菜单
     */
    public function getAllMenus(): array
    {
        $query = $this->search(['status' => 1, 'type' => ['M','I','L']])->order('sort', 'desc');
        $data = $this->getAll($query);
        return Helper::makeArcoMenus($data);
    }

    /**
     * 获取全部操作code
     */
    public function getAllCode(): array
    {
        $query = $this->search(['type' => 'B']);
        return $query->column('code');
    }

    /**
     * 根据ids获取权限
     * @param $ids
     * @return array
     */
    public function getMenuCode($ids): array
    {
        return $this->model
            ->where('status', 1)
            ->where('id', 'in', $ids)
            ->column('code');
    }

    /**
     * 根据管理员id获取权限
     * @param $id
     * @return array
     */
    public function getAuthByAdminId($id): array
    {
        $roleIds = SystemUserRole::where('user_id', $id)->column('role_id');
        $menuId = SystemRoleMenu::whereIn('role_id', $roleIds)->column('menu_id');

        return SystemMenu::distinct(true)
            ->where('type', 'B')
            ->where('status', 1)
            ->where('id', 'in', array_unique($menuId))
            ->column('code');
    }

    /**
     * 根据管理员id获取菜单
     * @param $id
     * @return array
     */
    public function getRoutersByAdminId($id): array
    {
        $roleIds = SystemUserRole::where('user_id', $id)->column('role_id');
        $menuId = SystemRoleMenu::whereIn('role_id', $roleIds)->column('menu_id');

        $data = SystemMenu::distinct(true)
            ->where('status', 1)
            ->where('type', 'in', ['M','I','L'])
            ->where('id', 'in', array_unique($menuId))
            ->order('sort', 'desc')
            ->select()
            ->toArray();
        return Helper::makeArcoMenus($data);
    }

    /**
     * 过滤通过角色查询出来的菜单id列表，并去重
     * @param array $roleData
     * @return array
     */
    public function filterMenuIds(array &$roleData): array
    {
        $ids = [];
        foreach ($roleData as $val) {
            foreach ($val['menus'] as $menu) {
                $ids[] = $menu['id'];
            }
        }
        unset($roleData);
        return array_unique($ids);
    }

}