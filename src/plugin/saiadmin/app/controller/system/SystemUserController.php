<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\controller\system;

use plugin\saiadmin\app\cache\UserAuthCache;
use plugin\saiadmin\app\cache\UserMenuCache;
use plugin\saiadmin\basic\BaseController;
use plugin\saiadmin\app\cache\UserInfoCache;
use plugin\saiadmin\app\logic\system\SystemUserLogic;
use plugin\saiadmin\app\validate\system\SystemUserValidate;
use plugin\saiadmin\service\Permission;
use support\Request;
use support\Response;

/**
 * 用户信息控制器
 */
class SystemUserController extends BaseController
{
    /**
     * 构造
     */
    public function __construct()
    {
        $this->logic = new SystemUserLogic();
        $this->validate = new SystemUserValidate;
        parent::__construct();
    }

    /**
     * 数据列表
     * @param Request $request
     * @return Response
     */
    #[Permission('用户数据列表', 'core:user:index')]
    public function index(Request $request): Response
    {
        $where = $request->more([
            ['username', ''],
            ['phone', ''],
            ['email', ''],
            ['status', ''],
            ['dept_id', ''],
            ['create_time', ''],
        ]);
        $data = $this->logic->indexList($where);
        return $this->success($data);
    }

    /**
     * 读取数据
     * @param Request $request
     * @return Response
     */
    #[Permission('用户数据读取', 'core:user:read')]
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
    #[Permission('用户数据保存', 'core:user:save')]
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
    #[Permission('用户数据更新', 'core:user:update')]
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
    #[Permission('用户数据删除', 'core:user:destroy')]
    public function destroy(Request $request): Response
    {
        $ids = $request->input('ids', '');
        if (!empty($ids)) {
            $this->logic->destroy($ids);
            return $this->success('操作成功');
        } else {
            return $this->fail('参数错误，请检查');
        }
    }

    /**
     * 清理用户缓存
     * @param Request $request
     * @return Response
     */
    #[Permission('清理用户缓存', 'core:user:cache')]
    public function clearCache(Request $request): Response
    {
        $id = $request->post('id', '');
        UserInfoCache::clearUserInfo($id);
        UserAuthCache::clearUserAuth($id);
        UserMenuCache::clearUserMenu($id);
        return $this->success('操作成功');
    }

    /**
     * 修改用户密码
     * @param Request $request
     * @return Response
     */
    #[Permission('修改用户密码', 'core:user:password')]
    public function initUserPassword(Request $request): Response
    {
        $id = $request->post('id', '');
        $password = $request->post('password', '');
        if ($id == 1) {
            return $this->fail('超级管理员不允许重置密码');
        }
        $data = ['password' => password_hash($password, PASSWORD_DEFAULT)];
        $this->logic->authEdit($id, $data);
        UserInfoCache::clearUserInfo($id);
        return $this->success('操作成功');
    }

    /**
     * 设置用户首页
     * @param Request $request
     * @return Response
     */
    #[Permission('设置用户首页', 'core:user:home')]
    public function setHomePage(Request $request): Response
    {
        $id = $request->post('id', '');
        $dashboard = $request->post('dashboard', '');
        $data = ['dashboard' => $dashboard];
        $this->logic->authEdit($id, $data);
        UserInfoCache::clearUserInfo($id);
        return $this->success('操作成功');
    }

    /**
     * 更新资料
     * @param Request $request
     * @return Response
     */
    #[Permission('用户修改资料')]
    public function updateInfo(Request $request): Response
    {
        $data = $request->post();
        unset($data['deptList']);
        unset($data['postList']);
        unset($data['roleList']);
        $result = $this->logic->updateInfo($this->adminId, $data);
        if ($result) {
            UserInfoCache::clearUserInfo($this->adminId);
            return $this->success('操作成功');
        } else {
            return $this->fail('操作失败');
        }
    }

    /**
     * 修改密码
     * @param Request $request
     * @return Response
     */
    #[Permission('用户修改密码')]
    public function modifyPassword(Request $request): Response
    {
        $oldPassword = $request->input('oldPassword');
        $newPassword = $request->input('newPassword');
        $this->logic->modifyPassword($this->adminId, $oldPassword, $newPassword);
        UserInfoCache::clearUserInfo($this->adminId);
        return $this->success('修改成功');
    }
}
