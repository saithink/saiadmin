<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\controller\system;

use plugin\saiadmin\app\cache\UserAuthCache;
use plugin\saiadmin\basic\BaseController;
use plugin\saiadmin\app\cache\UserInfoCache;
use plugin\saiadmin\app\logic\system\SystemUserLogic;
use plugin\saiadmin\app\validate\system\SystemUserValidate;
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
    public function index(Request $request) : Response
    {
        $where = $request->more([
            ['username', ''],
            ['phone', ''],
            ['email', ''],
            ['status', ''],
            ['dept_id', ''],
            ['create_time', ''],
        ]);
        $query = $this->logic->search($where);
        $query->auth([
            'id' => $this->adminId,
            'dept' => $this->adminInfo['deptList']
        ]);
        $data = $this->logic->getList($query);
        return $this->success($data);
    }

    /**
     * 修改状态
     * @param Request $request
     * @return Response
     */
    public function changeStatus(Request $request) : Response
    {
        $id = $request->input('id', '');
        $status = $request->input('status', 1);
        $model = $this->logic->findOrEmpty($id);
        if ($model->isEmpty()) {
            return $this->fail('未查找到信息');
        }
        $result = $model->save(['status' => $status]);
        if ($result) {
            $this->afterChange('changeStatus', $model);
            return $this->success('操作成功');
        } else {
            return $this->fail('操作失败');
        }
    }

    /**
     * 更新资料
     * @param Request $request
     * @return Response
     */
    public function updateInfo(Request $request) : Response
    {
        $data = $request->post();
        unset($data['deptList']);
        unset($data['postList']);
        unset($data['roleList']);
        $result = $this->logic->update($data, ['id' => $this->adminId], ['nickname', 'phone', 'signed', 'email', 'avatar', 'backend_setting']);
        if ($result) {
            $userInfoCache = new UserInfoCache($this->adminId);
            $userInfoCache->clearUserInfo();
            $userAuthCache = new UserAuthCache($this->adminId);
            $userAuthCache->clearUserCache();
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
    public function modifyPassword(Request $request) : Response
    {
        $oldPassword = $request->input('oldPassword');
        $newPassword = $request->input('newPassword');
        $this->logic->modifyPassword($this->adminId, $oldPassword, $newPassword);
        $userInfoCache = new UserInfoCache($this->adminId);
        $userInfoCache->clearUserInfo();
        $userAuthCache = new UserAuthCache($this->adminId);
        $userAuthCache->clearUserCache();
        return $this->success('修改成功');
    }

    /**
     * 清理用户缓存
     * @param Request $request
     * @return Response
     */
    public function clearCache(Request $request) : Response
    {
        $id = $request->post('id', '');
        $userInfoCache = new UserInfoCache($id);
        $userInfoCache->clearUserInfo();
        $userAuthCache = new UserAuthCache($id);
        $userAuthCache->clearUserCache();
        return $this->success('操作成功');
    }

    /**
     * 重置密码
     * @param Request $request
     * @return Response
     */
    public function initUserPassword(Request $request) : Response
    {
        $id = $request->post('id', '');
        if ($id == 1) {
            return $this->fail('超级管理员不允许重置密码');
        }
        $data = ['password' => password_hash('sai123456', PASSWORD_DEFAULT)];
        $this->logic->authEdit($id, $data);
        $userInfoCache = new UserInfoCache($id);
        $userInfoCache->clearUserInfo();
        $userAuthCache = new UserAuthCache($id);
        $userAuthCache->clearUserCache();
        return $this->success('操作成功');
    }

    /**
     * 设置首页
     * @param Request $request
     * @return Response
     */
    public function setHomePage(Request $request) : Response
    {
        $id = $request->post('id', '');
        $dashboard = $request->post('dashboard', '');
        $data = ['dashboard' => $dashboard];
        $this->logic->authEdit($id, $data);
        $userInfoCache = new UserInfoCache($id);
        $userInfoCache->clearUserInfo();
        $userAuthCache = new UserAuthCache($id);
        $userAuthCache->clearUserCache();
        return $this->success('操作成功');
    }
}
