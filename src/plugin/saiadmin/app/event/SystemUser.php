<?php
namespace plugin\saiadmin\app\event;
use plugin\saiadmin\app\model\system\SystemLoginLog;
use plugin\saiadmin\app\model\system\SystemOperLog;
use plugin\saiadmin\app\model\system\SystemMenu;


class SystemUser
{
    /**
     * 登录日志
     * @param $item
     */
    public function login($item)
    {
        $ip = request()->getRealIp();
        $http_user_agent = request()->header('user-agent');
        $data['username'] = $item['username'];
        $data['ip'] = $ip;
        $data['ip_location'] = self::getIpLocation($ip);
        $data['os'] = self::getOs($http_user_agent);
        $data['browser'] = self::getBrowser($http_user_agent);
        $data['status'] = $item['status'];
        $data['message'] = $item['message'];
        $data['login_time'] = date('Y-m-d H:i:s');
        SystemLoginLog::create($data);
    }

    /**
     * 记录操作日志
     */
    public function operateLog($flag): bool
    {
        if (request()->method() === 'GET') {
            return false;
        }
        $info = getCurrentInfo();
        $ip = request()->getRealIp();
        $module = request()->plugin;
        $rule = trim(strtolower(request()->uri()));
        $data['username'] = $info['username'];
        $data['method'] = request()->method();
        $data['router'] = $rule;
        $data['service_name'] = self::getServiceName();
        $data['app'] = $module;
        $data['ip'] = $ip;
        $data['ip_location'] = self::getIpLocation($ip);
        $data['request_data'] = $this->filterParams(request()->all());
        SystemOperLog::create($data);
        return true;
    }

    protected function getServiceName() : string
    {
        $path = request()->route->getPath();
        if (preg_match("/\{[^}]+\}/", $path)) {
            $path = rtrim(preg_replace("/\{[^}]+\}/", '', $path), '/');
        }
        $menu = SystemMenu::where('code', $path)->findOrEmpty();
        if (!$menu->isEmpty()) {
            return $menu->getAttr('name');
        } else {
            return '未知';
        }
    }

    /**
     * 过滤字段
     */
    protected function filterParams($params): string
    {
        $blackList = ['password', 'oldPassword', 'newPassword', 'content'];
        foreach ($params as $key => $value) {
            if (in_array($key, $blackList)) {
                $params[$key] = '******';
            }
        }
        return json_encode($params, JSON_UNESCAPED_UNICODE);
    }

    protected function getIpLocation($ip) {
        $ip2region = new \Ip2Region();
        try {
            $region = $ip2region->memorySearch($ip);
        } catch (\Exception $e) {
            return '未知';
        }
        list($country, $number, $province, $city, $network) = explode('|', $region['region']);
        if ($network === '内网IP') {
            return $network;
        }
        if ($country == '中国') {
            return $province.'-'.$city.':'.$network;
        } else if ($country == '0') {
            return '未知';
        } else {
            return $country;
        }
    }

    protected function getBrowser($user_agent): string
    {
        $br = 'Unknown';
        if (preg_match('/MSIE/i', $user_agent)) {
            $br = 'MSIE';
        } elseif (preg_match('/Firefox/i', $user_agent)) {
            $br = 'Firefox';
        } elseif (preg_match('/Chrome/i', $user_agent)) {
            $br = 'Chrome';
        } elseif (preg_match('/Safari/i', $user_agent)) {
            $br = 'Safari';
        } elseif (preg_match('/Opera/i', $user_agent)) {
            $br = 'Opera';
        } else {
            $br = 'Other';
        }
        return $br;
    }

    protected function getOs($user_agent): string
    {
        $os = 'Unknown';
        if (preg_match('/win/i', $user_agent)) {
            $os = 'Windows';
        } elseif (preg_match('/mac/i', $user_agent)) {
            $os = 'Mac';
        } elseif (preg_match('/linux/i', $user_agent)) {
            $os = 'Linux';
        } else {
            $os = 'Other';
        }
        return $os;
    }

}