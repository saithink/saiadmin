<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\controller\system;

use plugin\saiadmin\service\Permission;
use plugin\saiadmin\basic\BaseController;
use plugin\saiadmin\app\logic\system\SystemMailLogic;
use plugin\saiadmin\app\validate\system\SystemMailValidate;
use support\Request;
use support\Response;

/**
 * 邮件记录控制器
 */
class SystemMailController extends BaseController
{
    /**
     * 构造
     */
    public function __construct()
    {
        $this->logic = new SystemMailLogic();
        $this->validate = new SystemMailValidate;
        parent::__construct();
    }

    /**
     * 数据列表
     * @param Request $request
     * @return Response
     */
    #[Permission('邮件日志列表', 'core:email:index')]
    public function index(Request $request): Response
    {
        $where = $request->more([
            ['gateway', ''],
            ['from', ''],
            ['code', ''],
            ['email', ''],
            ['status', ''],
            ['create_time', ''],
        ]);
        $query = $this->logic->search($where);
        $data = $this->logic->getList($query);
        return $this->success($data);
    }

    /**
     * 删除数据
     * @param Request $request
     * @return Response
     */
    #[Permission('邮件日志删除', 'core:email:destroy')]
    public function destroy(Request $request) : Response
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

}