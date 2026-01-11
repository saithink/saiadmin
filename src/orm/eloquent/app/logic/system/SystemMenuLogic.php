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
use plugin\saiadmin\basic\eloquent\BaseLogic;
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
        return $this->model->create($data);
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
        return $this->model->where('id', $id)->update($data);
    }

    /**
     * 数据删除
     */
    public function destroy($ids): bool
    {
        $num = $this->model->whereIn('parent_id', $ids)->count();
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
        // 处理上级菜单
        if (empty($data['parent_id']) || $data['parent_id'] == 0) {
            $data['parent_id'] = 0;
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
        $request = request();
        if ($request && $request->input('tree', 'false') === 'true') {
            $query->select('id', 'id as value', 'name as label', 'parent_id', 'type');
        }
        $query->orderBy('sort', 'desc');
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
            ->select('id', 'id as value', 'name as label', 'parent_id', 'type')
            ->where('status', 1)
            ->whereIn('id', $ids)
            ->orderBy('sort', 'desc');
        $data = $this->getAll($query);
        return Helper::makeTree($data);
    }

    /**
     * 获取全部菜单
     */
    public function getAllMenus(): array
    {
        $query = $this->search(['status' => 1, 'type' => [1, 2, 4]])->orderBy('sort', 'desc');
        $data = $this->getAll($query);
        return Helper::makeArtdMenus($data);
    }

    /**
     * 获取全部权限
     * @return array
     */
    public function getAllAuth(): array
    {
        return SystemMenu::where('type', 3)
            ->where('status', 1)
            ->pluck('slug')
            ->toArray();
    }

    /**
     * 根据角色获取权限
     * @param $roleIds
     * @return array
     */
    public function getAuthByRole($roleIds): array
    {
        $menuId = SystemRoleMenu::whereIn('role_id', $roleIds)->pluck('menu_id')->toArray();

        return SystemMenu::distinct()
            ->where('type', 3)
            ->where('status', 1)
            ->whereIn('id', array_unique($menuId))
            ->pluck('slug')
            ->toArray();
    }

    /**
     * 根据角色获取菜单
     * @param $roleIds
     * @return array
     */
    public function getMenuByRole($roleIds): array
    {
        $menuId = SystemRoleMenu::whereIn('role_id', $roleIds)->pluck('menu_id')->toArray();

        $data = SystemMenu::distinct()
            ->where('status', 1)
            ->whereIn('type', [1, 2, 4])
            ->whereIn('id', array_unique($menuId))
            ->orderBy('sort', 'desc')
            ->get()
            ->toArray();
        return Helper::makeArtdMenus($data);
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