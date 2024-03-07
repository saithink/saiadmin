<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\controller\system;

use plugin\saiadmin\app\validate\system\SystemDeptValidate;
use plugin\saiadmin\basic\BaseController;
use plugin\saiadmin\app\logic\system\SystemDeptLogic;
use support\Request;
use support\Response;

/**
 * 部门控制器
 */
class SystemDeptController extends BaseController
{
    /**
     * 构造
     */
    public function __construct()
    {
        $this->logic = new SystemDeptLogic();
        $this->validate = new SystemDeptValidate;
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
            ['leader', ''],
            ['phone', ''],
            ['status', ''],
        ]);
        $data = $this->logic->tree($where);
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
        if (!$this->validate->scene('save')->check($data)) {
            return $this->fail($this->validate->getError());
        }
        $result = $this->logic->save($data);
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
        if (!$this->validate->scene('update')->check($data)) {
            return $this->fail($this->validate->getError());
        }
        $result = $this->logic->update($data, ['id' => $id]);
        if ($result) {
            return $this->success('操作成功');
        } else {
            return $this->fail('操作失败');
        }
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
        $result = $this->logic->update(['status' => $status], ['id' => $id]);
        if ($result) {
            return $this->success('操作成功');
        } else {
            return $this->fail('操作失败');
        }
    }

    /**
     * 删除数据
     * @param Request $request
     * @return Response
     */
    public function destroy(Request $request) : Response
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
     * 部门领导列表
     * @param Request $request
     * @return Response
     */
    public function leaders(Request $request) : Response
    {
        $where = $request->more([
            ['dept_id', ''],
            ['username', ''],
            ['nickname', ''],
            ['status', ''],
        ]);
        $data = $this->logic->leaders($where);
        return $this->success($data);
    }

    /**
     * 添加部门领导
     * @param Request $request
     * @return Response
     */
    public function addLeader(Request $request) : Response
    {
        $id = $request->post('id');
        $users = $request->post('users');
        $this->logic->addLeader($id, $users);
        return $this->success('操作成功');
    }

    /**
     * 删除部门领导
     * @param Request $request
     * @return Response
     */
    public function delLeader(Request $request) : Response
    {
        $id = $request->post('id');
        $ids = $request->post('ids');
        if (!empty($id)) {
            $this->logic->delLeader($id, $ids);
            return $this->success('操作成功');
        } else {
            return $this->fail('参数错误，请检查');
        }
    }
}
