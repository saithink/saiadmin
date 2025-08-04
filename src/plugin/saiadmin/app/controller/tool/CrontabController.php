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
            $this->afterChange('changeStatus', $id);
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
        $id = $request->input('id', $id);
        if (empty($id)) {
            return $this->fail('参数错误，请检查');
        }
        $data = $request->post();
        if ($this->validate) {
            if (!$this->validate->scene('update')->check($data)) {
                return $this->fail($this->validate->getError());
            }
        }
        $up = false;
        $result = $this->logic->edit($id, $data, function($oldRule, $newRule) use(&$up){
            $up = $oldRule != $newRule;
        });
        if ($result) {
            if($up){
                $this->afterChange('update', $id);
            }
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
        if (in_array($type, ['save', 'update', 'destroy'])) {
//            $task = new \plugin\saiadmin\process\Task();
//            $task->reload();
            // 连接到Channel服务
            Client::connect();
            // 发布某个自定义事件，订阅这个事件的客户端会收到事件数据，并触发客户端对应的事件回调
            if(is_array($args)){
                foreach ($args as $id){
                    Client::publish('crontab', ['args' => $id]);
                }
            }else{
                Client::publish('crontab', ['args' => $args]);
            }
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