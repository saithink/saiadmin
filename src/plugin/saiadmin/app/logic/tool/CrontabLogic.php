<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\tool;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use plugin\saiadmin\app\model\tool\Crontab;
use plugin\saiadmin\app\model\tool\CrontabLog;
use plugin\saiadmin\basic\BaseLogic;
use plugin\saiadmin\exception\ApiException;

/**
 * 定时任务逻辑层
 */
class CrontabLogic extends BaseLogic
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->model = new Crontab();
    }

    /**
     * 添加任务
     */
    public function add($data): mixed
    {
        $second = $data['second'];
        $minute = $data['minute'];
        $hour = $data['hour'];
        $week = $data['week'];
        $day = $data['day'];
        $month = $data['month'];

        // 规则处理
        $rule = match ($data['task_style']) {
            1 => "0 {$minute} {$hour} * * *",
            2 => "0 {$minute} * * * *",
            3 => "0 {$minute} */{$hour} * * *",
            4 => "0 */{$minute} * * * *",
            5 => "*/{$second} * * * * *",
            6 => "0 {$minute} {$hour} * * {$week}",
            7 => "0 {$minute} {$hour} {$day} * *",
            8 => "0 {$minute} {$hour} {$day} {$month} *",
            default => throw new ApiException("任务类型异常"),
        };

        // 定时任务模型新增
        $model = Crontab::create([
            'name' => $data['name'],
            'type' => $data['type'],
            'task_style' => $data['task_style'],
            'rule' => $rule,
            'target' => $data['target'],
            'parameter' => $data['parameter'],
            'status' => $data['status'],
            'remark' => $data['remark'],
        ]);
        return $model->getKey();
    }

    /**
     * 修改任务
     */
    public function edit($id, $data): mixed
    {
        $second = $data['second'];
        $minute = $data['minute'];
        $hour = $data['hour'];
        $week = $data['week'];
        $day = $data['day'];
        $month = $data['month'];

        // 规则处理
        $rule = match ($data['task_style']) {
            1 => "0 {$minute} {$hour} * * *",
            2 => "0 {$minute} * * * *",
            3 => "0 {$minute} */{$hour} * * *",
            4 => "0 */{$minute} * * * *",
            5 => "*/{$second} * * * * *",
            6 => "0 {$minute} {$hour} * * {$week}",
            7 => "0 {$minute} {$hour} {$day} * *",
            8 => "0 {$minute} {$hour} {$day} {$month} *",
            default => throw new ApiException("任务类型异常"),
        };

        // 查询任务数据
        $model = $this->model->findOrEmpty($id);
        if ($model->isEmpty()) {
            throw new ApiException('数据不存在');
        }

        // 修改任务数据
        return $model->save([
            'name' => $data['name'],
            'type' => $data['type'],
            'task_style' => $data['task_style'],
            'rule' => $rule,
            'target' => $data['target'],
            'parameter' => $data['parameter'],
            'status' => $data['status'],
            'remark' => $data['remark'],
        ]);
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
                    CrontabLog::create($data);
                    return true;
                } catch (GuzzleException $e) {
                    $data['status'] = 2;
                    $data['exception_info'] = $e->getMessage();
                    CrontabLog::create($data);
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
                    CrontabLog::create($data);
                    return true;
                } catch (GuzzleException $e) {
                    $data['status'] = 2;
                    $data['exception_info'] = $e->getMessage();
                    CrontabLog::create($data);
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
                    CrontabLog::create($data);
                    return true;
                } else {
                    $data['status'] = 2;
                    $data['exception_info'] = '类:'.$class_name.',方法:run,未找到';
                    CrontabLog::create($data);
                    return false;

                }
            default:
                return false;
        }
    }

}
