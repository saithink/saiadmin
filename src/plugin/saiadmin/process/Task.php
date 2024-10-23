<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\process;

use Webman\Push\Api;
use Workerman\Crontab\Crontab;
use plugin\saiadmin\app\logic\system\SystemCrontabLogic;

class Task
{
    public function onWorkerStart()
    {
        $this->initStart();
    }

    public function initStart()
    {
        $logic = new SystemCrontabLogic();
        $taskList = $logic->select();
        foreach ($taskList as $item) {
            if ($item->status == 1) {
                $task = new Crontab($item->rule, function () use ($logic, $item) {
                    $logic->run($item->id);
                });
                $task_id = $task->getId();
                $logic->update(['task_id' => $task_id],['id' => $item->id]);
            } else {
                $logic->update(['task_id' => 0], ['id' => $item->id]);
            }
        }
    }

    public function reload()
    {
        echo "重启Crontab\n";
        $logic = new SystemCrontabLogic();
        $taskList = $logic->where([['task_id', '>', 0]])->select();
        foreach($taskList as $item) {
            $taskId = intval($item->task_id);
            Crontab::remove($taskId);
            $this->initStart();
        }
        $this->initStart();
    }

    public function run($args)
    {
        echo '任务调用：'.date('Y-m-d H:i:s')."\n";
        var_dump('参数:'. $args);

        $api = new Api(
            'http://127.0.0.1:3232',
            config('plugin.webman.push.app.app_key'),
            config('plugin.webman.push.app.app_secret')
        );
        // 给订阅 saiadmin 的所有客户端推送 message 事件的消息
        $return_ret = [
            'event' => 'ev_new_message',
            'message' => '新消息通知',
            'data' => [
                [
                    'id' => 1,
                    'title' => '系统消息',
                    'content' => '欢迎使用saiadmin框架',
                    'create_time' => date('Y-m-d H:i:s'),
                    'send_user' => [
                        'nickname' => '系统管理员',
                        'avatar' => ''
                    ]
                ]
            ]
        ];
        $api->trigger('saiadmin', 'message', $return_ret);
    }
}