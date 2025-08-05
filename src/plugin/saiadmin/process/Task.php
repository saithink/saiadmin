<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\process;

use plugin\saiadmin\app\logic\tool\CrontabLogic;
use Webman\Channel\Client;
use Workerman\Crontab\Crontab;

class Task
{
    protected $logic; //login对象
    public $crontabIds = []; //定时任务表主键id => Crontab对象id

    public function __construct()
    {
        $this->logic = new CrontabLogic();
        // 连接webman channel服务
        Client::connect();
        // 订阅某个自定义事件并注册回调，收到事件后会自动触发此回调
        Client::on('crontab', function($data) {
            $this->reload($data);
        });
    }
    public function onWorkerStart()
    {
        $dbName = env('DB_NAME');
        if (!empty($dbName)) {
            $this->initStart();
        }
    }

    public function initStart()
    {
        $logic = new CrontabLogic();
        $taskList = $logic->where('status', 1)->select();
        foreach ($taskList as $item) {
            $crontab = new Crontab($item->rule, function () use ($item) {
                $this->logic->run($item->id);
            });
            $this->crontabIds[intval($item->id)] = $crontab->getId(); //存储定时任务表主键id => Crontab对象id
            echo date('Y-m-d H:i:s')." => 定时任务[".$item->id."][".$item->name."]:启动成功".PHP_EOL;
        }
    }

    public function reload($data)
    {
        $id = intval($data['args'] ?? 0); //定时任务表主键id
        if (isset($this->crontabIds[$id])) {
            Crontab::remove($this->crontabIds[$id]);
            unset($this->crontabIds[$id]); //删除定时任务表主键id => Crontab对象id
            echo date('Y-m-d H:i:s')." => 定时任务[".$id."]:移除成功".PHP_EOL;
        }
        $item = $this->logic->findOrEmpty($id);// 查询定时任务表数据
        if (!$item->isEmpty() && $item->status == 1) {
            $crontab = new Crontab($item->rule, function () use ($item) {
                $this->logic->run($item->id);
            });
            $this->crontabIds[$id] = $crontab->getId(); //存储定时任务表主键id => Crontab对象id
            echo date('Y-m-d H:i:s')." => 定时任务[".$item->id."][".$item->name."]:启动成功".PHP_EOL;
        }
    }
}