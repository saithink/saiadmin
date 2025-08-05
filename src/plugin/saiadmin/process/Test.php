<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\process;

use Webman\Push\Api;

class Test
{
    public function run($args): void
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