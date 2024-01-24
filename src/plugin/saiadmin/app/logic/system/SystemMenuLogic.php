<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\system;

use plugin\saiadmin\app\model\system\SystemMenu;
use plugin\saiadmin\basic\BaseLogic;
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
            $data['type'] = $data['type'] === 'B' ? 'M' : $data['type'];
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
     * 获取全部菜单
     */
    public function getAllMenus(): array
    {
        $query = $this->search(['type' => 'M'])->order('sort', 'desc');
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
     * 根据ids获取路由菜单
     * @param $ids
     * @return array
     */
    public function getRoutersByIds($ids): array
    {
        $query = $this->model
            ->where('status', 1)
            ->where('id', 'in', $ids)
            ->order('sort', 'desc');
        $data = $this->getAll($query);
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