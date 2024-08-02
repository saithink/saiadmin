<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\system;

use GuzzleHttp\Exception\GuzzleException;
use plugin\saiadmin\basic\BaseLogic;
use plugin\saiadmin\exception\ApiException;
use plugin\saiadmin\app\model\system\SystemCrontab;
use plugin\saiadmin\app\model\system\SystemCrontabLog;
use plugin\saiadmin\utils\Helper;
use GuzzleHttp\Client;

/**
 * 定时任务逻辑层
 */
class SystemCrontabLogic extends BaseLogic
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->model = new SystemCrontab();
    }

    /**
     * 执行定时任务
     * @param $id
     * @return bool
     */
    public function run($id): bool
    {
        $info = $this->find($id);
        $data['crontab_id'] = $info->id;
        $data['name'] = $info->name;
        $data['target'] = $info->target;
        $data['parameter'] = $info->parameter;
        switch ($info->type) {
            case 1:
                // URL任务GET
                $httpClient = new Client([
                    'timeout' => 5,
                    'verify' => false,
                ]);
                try {
                    $httpClient->request('GET', $info->target);
                    $data['status'] = 1;
                    SystemCrontabLog::create($data);
                    return true;
                } catch (GuzzleException $e) {
                    $data['status'] = 2;
                    $data['exception_info'] = $e->getMessage();
                    SystemCrontabLog::create($data);
                    return false;
                }
            case 2:
                // URL任务POST
                $httpClient = new Client([
                    'timeout' => 5,
                    'verify' => false,
                ]);
                try {
                    $res = $httpClient->request('POST', $info->target, [
                        'form_params' => json_decode($info->parameter ?? '',true)
                    ]);
                    $data['status'] = 1;
                    $data['exception_info'] = $res->getBody();
                    SystemCrontabLog::create($data);
                    return true;
                } catch (GuzzleException $e) {
                    $data['status'] = 2;
                    $data['exception_info'] = $e->getMessage();
                    SystemCrontabLog::create($data);
                    return false;
                }
            case 3:
                // 类任务
                $class_name = $info->target;
                $method_name = 'run';
                $class = new $class_name;
                if (method_exists($class, $method_name)) {
                    $return = $class->$method_name($info->parameter);
                    $data['status'] = 1;
                    $data['exception_info'] = $return;
                    SystemCrontabLog::create($data);
                    return true;
                } else {
                    $data['status'] = 2;
                    $data['exception_info'] = '类:'.$class_name.',方法:run,未找到';
                    SystemCrontabLog::create($data);
                    return false;

                }
            default:
                return false;
        }
    }

}
