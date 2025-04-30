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
     * 更新crontab任务
     * @param $type
     * @param $args
     * @return void
     */
    protected function afterChange($type, $args): void
    {
        if (in_array($type, ['save', 'update', 'changeStatus'])) {
            $task = new \plugin\saiadmin\process\Task();
            $task->reload();
        }
    }

    /**
     * 执行定时任务
     * @param Request $request
     * @return Response
     */
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
    public function logPageList(Request $request) : Response
    {
        $where = $request->more([
            ['crontab_id', ''],
        ]);
        $logic = new CrontabLogLogic();
        $query = $logic->search($where);
        $data = $logic->getList($query);
        return $this->success($data);
    }

    /**
     * 删除定时任务日志数据
     * @param Request $request
     * @return Response
     */
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