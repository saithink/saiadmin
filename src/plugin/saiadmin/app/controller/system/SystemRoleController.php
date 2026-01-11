<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\controller\system;

use plugin\saiadmin\app\model\system\SystemUserRole;
use plugin\saiadmin\basic\BaseController;
use plugin\saiadmin\app\cache\UserInfoCache;
use plugin\saiadmin\app\model\system\SystemUser;
use plugin\saiadmin\app\validate\system\SystemRoleValidate;
use plugin\saiadmin\app\logic\system\SystemRoleLogic;
use plugin\saiadmin\service\Permission;
use support\Request;
use support\Response;

/**
 * 角色控制器
 */
class SystemRoleController extends BaseController
{
    /**
     * 构造
     */
    public function __construct()
    {
        $this->logic = new SystemRoleLogic();
        $this->validate = new SystemRoleValidate;
        parent::__construct();
    }

    /**
     * 数据列表
     * @param Request $request
     * @return Response
     */
    #[Permission('角色数据列表', 'core:role:index')]
    public function index(Request $request): Response
    {
        $where = $request->more([
            ['name', ''],
            ['code', ''],
            ['status', ''],
        ]);
        $query = $this->logic->search($where);
        $levelArr = array_column($this->adminInfo['roleList'], 'level');
        $maxLevel = max($levelArr);
        $query->where('level', '<', $maxLevel);
        $data = $this->logic->getList($query);
        return $this->success($data);
    }

    /**
     * 读取数据
     * @param Request $request
     * @return Response
     */
    #[Permission('角色数据读取', 'core:role:read')]
    public function read(Request $request): Response
    {
        $id = $request->input('id', '');
        $model = $this->logic->read($id);
        if ($model) {
            $data = is_array($model) ? $model : $model->toArray();
            return $this->success($data);
        } else {
            return $this->fail('未查找到信息');
        }
    }

    /**
     * 保存数据
     * @param Request $request
     * @return Response
     */
    #[Permission('角色数据添加', 'core:role:save')]
    public function save(Request $request): Response
    {
        $data = $request->post();
        $this->validate('save', $data);
        $result = $this->logic->add($data);
        if ($result) {
            return $this->success('添加成功');
        } else {
            return $this->fail('添加失败');
        }
    }

    /**
     * 更新数据
     * @param Request $request
     * @return Response
     */
    #[Permission('角色数据修改', 'core:role:update')]
    public function update(Request $request): Response
    {
        $data = $request->post();
        $this->validate('update', $data);
        $result = $this->logic->edit($data['id'], $data);
        if ($result) {
            return $this->success('修改成功');
        } else {
            return $this->fail('修改失败');
        }
    }

    /**
     * 删除数据
     * @param Request $request
     * @return Response
     */
    #[Permission('角色数据删除', 'core:role:destroy')]
    public function destroy(Request $request): Response
    {
        $ids = $request->post('ids', '');
        if (empty($ids)) {
            return $this->fail('请选择要删除的数据');
        }
        $result = $this->logic->destroy($ids);
        if ($result) {
            return $this->success('删除成功');
        } else {
            return $this->fail('删除失败');
        }
    }

    /**
     * 根据角色获取菜单
     * @param Request $request
     * @return Response
     */
    #[Permission('角色数据列表', 'core:role:index')]
    public function getMenuByRole(Request $request): Response
    {
        $id = $request->get('id');
        $data = $this->logic->getMenuByRole($id);
        return $this->success($data);
    }

    /**
     * 菜单权限
     * @param Request $request
     * @return Response
     */
    #[Permission('角色菜单权限', 'core:role:menu')]
    public function menuPermission(Request $request): Response
    {
        $id = $request->post('id');
        $menu_ids = $request->post('menu_ids');
        $this->logic->saveMenuPermission($id, $menu_ids);
        return $this->success('操作成功');
    }

    /**
     * 可操作角色
     * @param Request $request
     * @return Response
     */
    public function accessRole(Request $request): Response
    {
        $where = ['status' => 1];
        $data = $this->logic->accessRole($where);
        return $this->success($data);
    }

}
