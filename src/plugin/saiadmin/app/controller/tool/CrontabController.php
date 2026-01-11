<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\controller\tool;

use plugin\saiadmin\app\logic\tool\CrontabLogic;
use plugin\saiadmin\app\logic\tool\CrontabLogLogic;
use plugin\saiadmin\app\validate\tool\CrontabValidate;
use plugin\saiadmin\basic\BaseController;
use plugin\saiadmin\service\Permission;
use Webman\Channel\Client;
use support\Request;
use support\Response;

/**
 * 定时任务控制器
 */
class CrontabController extends BaseController
{
    /**
     * 构造
     */
    public function __construct()
    {
        $this->logic = new CrontabLogic();
        $this->validate = new CrontabValidate;
        parent::__construct();
    }

    /**
     * 数据列表
     * @param Request $request
     * @return Response
     */
    #[Permission('定时任务列表', 'tool:crontab:index')]
    public function index(Request $request) : Response
    {
        $where = $request->more([
            ['name', ''],
            ['type', ''],
            ['status', ''],
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
    #[Permission('定时任务添加', 'tool:crontab:edit')]
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
    #[Permission('定时任务修改', 'tool:crontab:edit')]
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
    #[Permission('定时任务删除', 'tool:crontab:edit')]
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

    /**
     * 修改状态
     * @param Request $request
     * @return Response
     */
    #[Permission('定时任务状态修改', 'tool:crontab:edit')]
    public function changeStatus(Request $request) : Response
    {
        $id = $request->input('id', '');
        $status = $request->input('status', 1);
        if (empty($id)) {
            return $this->fail('参数错误，请检查');
        }
        $result = $this->logic->changeStatus($id, $status);
        if ($result) {
            return $this->success('操作成功');
        } else {
            return $this->fail('操作失败');
        }
    }

    /**
     * 执行定时任务
     * @param Request $request
     * @return Response
     */
    #[Permission('定时任务执行', 'tool:crontab:run')]
    public function run(Request $request) : Response
    {
        $id = $request->input('id', '');
        $result = $this->logic->run($id);
        if ($result) {
            return $this->success('执行成功');
        } else {
            return $this->fail('执行失败');
        }
    }

    /**
     * 定时任务日志
     * @param Request $request
     * @return Response
     */
    #[Permission('定时任务日志', 'tool:crontab:index')]
    public function logPageList(Request $request) : Response
    {
        $where = $request->more([
            ['crontab_id', ''],
            ['create_time', []]
        ]);
        $logic = new CrontabLogLogic();
        $query = $logic->search($where);
        $data = $logic->getList($query);
        return $this->success($data);
    }

    /**
     * 定时任务日志删除
     * @param Request $request
     * @return Response
     */
    #[Permission('定时任务日志删除', 'tool:crontab:edit')]
    public function deleteCrontabLog(Request $request) : Response
    {
        $ids = $request->input('ids', '');
        if (!empty($ids)) {
            $logic = new CrontabLogLogic();
            $logic->destroy($ids);
            return $this->success('操作成功');
        } else {
            return $this->fail('参数错误，请检查');
        }
    }
}