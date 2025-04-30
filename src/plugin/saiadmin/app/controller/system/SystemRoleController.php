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
    public function index(Request $request) : Response
    {
        $where = $request->more([
            ['name', ''],
            ['code', ''],
            ['status', ''],
        ]);
        $data = $this->logic->tree($where);
        return $this->success($data);
    }

    /**
     * 可操作角色
     * @param Request $request
     * @return Response
     */
    public function accessRole(Request $request) : Response
    {
        $where = [];
        $data = $this->logic->accessRole($where);
        return $this->success($data);
    }

    /**
     * 菜单权限
     * @param Request $request
     * @return Response
     */
    public function menuPermission(Request $request) : Response
    {
        $id = $request->get('id');
        $menu_ids = $request->post('menu_ids');
        $this->logic->saveMenuPermission($id, $menu_ids);
        return $this->success('操作成功');
    }

    /**
     * 根据角色获取菜单
     * @param Request $request
     * @return Response
     */
    public function getMenuByRole(Request $request) : Response
    {
        $id = $request->get('id');
        $data = $this->logic->getMenuByRole($id);
        return $this->success($data);
    }

    /**
     * 数据改变后执行
     * @param $type
     * @param $args
     * @return void
     */
    protected function afterChange($type, $args): void
    {
        // 批量清理用户缓存
        if ($type == 'update') {
            $role_id = request()->input('id', '');
            $userIds = SystemUserRole::where('role_id', $role_id)->column('user_id');
            $userIds = array_unique($userIds);
            foreach ($userIds as $userId) {
                $userInfoCache = new UserInfoCache($userId);
                $userInfoCache->clearUserInfo();
            }
        }
        if ($type == 'destroy') {
            $role_ids = request()->input('ids', '');
            if (is_array($role_ids)) {
                $userIds = SystemUserRole::whereIn('role_id', $role_ids)->column('user_id');
                $userIds = array_unique($userIds);
                foreach ($userIds as $userId) {
                    $userInfoCache = new UserInfoCache($userId);
                    $userInfoCache->clearUserInfo();
                }
            }
        }
    }

}
