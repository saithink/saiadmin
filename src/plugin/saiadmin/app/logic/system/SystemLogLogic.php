<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\system;

use plugin\saiadmin\basic\BaseLogic;
use plugin\saiadmin\exception\ApiException;
use plugin\saiadmin\app\model\system\SystemLog;

/**
 * 系统日志逻辑层
 */
class SystemLogLogic extends BaseLogic
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->model = new SystemLog();
    }

    /**
     * 记录日志
     * @return boolean
     */
    public function recordLog($admin_id, $admin_name)
    {
        if (request()->method() === 'GET') {
            return true;
        }
        $module = request()->plugin;
        $rule = trim(strtolower(request()->uri()));
        $data = [
            'app' => $module,
            'admin_id' => $admin_id,
            'add_time' => time(),
            'admin_name' => $admin_name,
            'path' => $rule,
            'page' => '未知',
            'ip' => request()->getRealIp(),
            'request_param'=>$this->filterParams(request()->all()),
            'method' => request()->method()
        ];
        if ($this->model->save($data)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 过滤字段
     */
    protected function filterParams($params)
    {
        $blackList = ['pwd', 'conf_pwd', 'new_pwd', 'password','content'];
        foreach ($params as $key => $value) {
            if (in_array($key, $blackList)) {
                $params[$key] = '******';
            }
        }
        return serialize($params);
    }

}