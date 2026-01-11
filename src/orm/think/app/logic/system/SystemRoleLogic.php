<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\system;

use plugin\saiadmin\app\cache\UserMenuCache;
use plugin\saiadmin\app\model\system\SystemRole;
use plugin\saiadmin\basic\think\BaseLogic;
use plugin\saiadmin\exception\ApiException;
use plugin\saiadmin\utils\Helper;
use support\think\Cache;
use support\think\Db;

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
        $model = $this->model->findOrEmpty($id);
        if ($model->isEmpty()) {
            throw new ApiException('数据不存在');
        }
        $data = $this->handleData($data);
        return $model->save($data);
    }

    /**
     * 删除数据
     */
    public function destroy($ids): bool
    {
        // 越权保护
        $levelArr = array_column($this->adminInfo['roleList'], 'level');
        $maxLevel = max($levelArr);

        $num = SystemRole::where('level', '>=', $maxLevel)->whereIn('id', $ids)->count();
        if ($num > 0) {
            throw new ApiException('不能操作比当前账户职级高的角色');
        } else {
            return $this->model->destroy($ids);
        }
    }

    /**
     * 数据处理
     */
    protected function handleData($data)
    {
        // 越权保护
        $levelArr = array_column($this->adminInfo['roleList'], 'level');
        $maxLevel = max($levelArr);
        if ($data['level'] >= $maxLevel) {
            throw new ApiException('不能操作比当前账户职级高的角色');
        }
        return $data;
    }

    /**
     * 可操作角色
     * @param array $where
     * @return array
     */
    public function accessRole(array $where = []): array
    {
        $query = $this->search($where);
        // 越权保护
        $levelArr = array_column($this->adminInfo['roleList'], 'level');
        $maxLevel = max($levelArr);
        $query->where('level', '<', $maxLevel);
        $query->order('sort', 'desc');
        return $this->getAll($query);
    }

    /**
     * 根据角色数组获取菜单
     * @param $ids
     * @return array
     */
    public function getMenuIdsByRoleIds($ids): array
    {
        if (empty($ids))
            return [];
        return $this->model->where('id', 'in', $ids)->with([
            'menus' => function ($query) {
                $query->where('status', 1)->order('sort', 'desc');
            }
        ])->select()->toArray();

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
                $data = array_map(function ($menu_id) use ($id) {
                    return ['menu_id' => $menu_id, 'role_id' => $id];
                }, $menu_ids);
                Db::name('sa_system_role_menu')->limit(100)->insertAll($data);
            }
            $cache = config('plugin.saiadmin.saithink.button_cache');
            $tag = $cache['role'] . $id;
            Cache::tag($tag)->clear();       // 清理权限缓存-角色TAG
            UserMenuCache::clearMenuCache(); // 清理菜单缓存
            return true;
        });
    }

}
