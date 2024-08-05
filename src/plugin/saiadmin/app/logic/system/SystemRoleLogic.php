<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\system;

use plugin\saiadmin\app\model\system\SystemRole;
use plugin\saiadmin\basic\BaseLogic;
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
