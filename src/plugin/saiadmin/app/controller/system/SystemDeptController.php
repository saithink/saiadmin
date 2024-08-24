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
     * 可操作部门
     * @param Request $request
     * @return Response
     */
    public function accessDept(Request $request) : Response
    {
        $where = [];
        $data = $this->logic->accessDept($where);
        return $this->success($data);
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
