<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\controller\system;

use plugin\saiadmin\basic\BaseController;
use plugin\saiadmin\app\logic\system\SystemUserLogic;
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
        $data = $this->logic->getList($query);
        return $this->success($data);
    }

    /**
     * 保存数据
     * @param Request $request
     * @return Response
     */
    public function save(Request $request) : Response
    {
        $data = $request->post();
        $result = $this->logic->add($data);
        if ($result) {
            return $this->success('操作成功');
        } else {
            return $this->fail('操作失败');
        }
    }

    /**
     * 修改数据
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function update(Request $request, $id) : Response
    {
        $data = $request->post();
        $result = $this->logic->edit($data, $id);
        if ($result) {
            return $this->success('操作成功');
        } else {
            return $this->fail('操作失败');
        }
    }

    /**
     * 读取信息
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function read(Request $request, $id) : Response
    {
        $data = $this->logic->read($id);
        return $this->success($data);
    }

    /**
     * 更新资料
     * @param Request $request
     * @return Response
     */
    public function updateInfo(Request $request) : Response
    {
        $data = $request->post();
        $result = $this->logic->update($data, ['id' => $this->adminId], ['nickname', 'phone', 'email', 'avatar', 'backend_setting']);
        if ($result) {
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
        return $this->success('修改成功');
    }

    /**
     * 更新用户缓存
     * @param Request $request
     * @return Response
     */
    public function clearCache(Request $request) : Response
    {
        $id = $request->post('id', '');
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
        $this->logic->update($data, ['id' => $id]);
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
        $this->logic->update($data, ['id' => $id]);
        return $this->success('操作成功');
    }
}
