<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\utils;

/**
 * 服务器监控信息
 */
class ServerMonitor
{
    private $cache = [];
    private $cacheTime = 2; // 缓存时间（秒）

    /**
     * 获取缓存数据
     * @param string $key
     * @return mixed|null
     */
    private function getCache(string $key)
    {
        if (isset($this->cache[$key]) && (time() - $this->cache[$key]['time']) < $this->cacheTime) {
            return $this->cache[$key]['data'];
        }
        return null;
    }

    /**
     * 设置缓存数据
     * @param string $key
     * @param mixed $data
     */
    private function setCache(string $key, $data)
    {
        $this->cache[$key] = [
            'time' => time(),
            'data' => $data
        ];
    }

    /**
     * 获取Windows系统信息
     * @return array
     */
    private function getWindowsSystemInfo(): array
    {
        $cacheKey = 'windows_system_info';
        $cached = $this->getCache($cacheKey);
        if ($cached !== null) {
            return $cached;
        }

        // 设置默认值
        $defaultData = [
            'cpu_usage' => 0,
            'cpu_name' => 'Unknown',
            'cpu_cores' => 1,
            'cpu_logical_cores' => 1,
            'cpu_l3_cache' => 0,
            'cpu_l2_cache' => 0,
            'total_memory' => 0,
            'available_memory' => 0
        ];

        try {
            $data = $defaultData;
            $usePowerShell = true;

            // 尝试使用 PowerShell 获取信息
            if ($usePowerShell) {
                // 使用 PowerShell 获取 CPU 信息
                $cpuInfo = shell_exec('powershell -NoProfile -NonInteractive -Command "Get-WmiObject -Class Win32_Processor | Select-Object Name, NumberOfCores, NumberOfLogicalProcessors, L2CacheSize, L3CacheSize | ConvertTo-Json"');

                // 使用 PowerShell 获取 CPU 使用率
                $cpuUsage = shell_exec('powershell -NoProfile -NonInteractive -Command "Get-Counter -Counter \'\\Processor(_Total)\\% Processor Time\' -SampleInterval 1 -MaxSamples 1 | Select-Object -ExpandProperty CounterSamples | Select-Object -ExpandProperty CookedValue"');

                // 检查 PowerShell 命令是否成功
                if ($cpuInfo && $cpuUsage !== null) {
                    $cpuData = json_decode($cpuInfo, true);
                    if ($cpuData) {
                        $data['cpu_name'] = $cpuData['Name'] ?? 'Unknown';
                        $data['cpu_cores'] = intval($cpuData['NumberOfCores'] ?? 1);
                        $data['cpu_logical_cores'] = intval($cpuData['NumberOfLogicalProcessors'] ?? 1);
                        $data['cpu_l2_cache'] = intval($cpuData['L2CacheSize'] ?? 0);
                        $data['cpu_l3_cache'] = intval($cpuData['L3CacheSize'] ?? 0);
                        $data['cpu_usage'] = round(floatval($cpuUsage), 2);
                    }
                } else {
                    $usePowerShell = false;
                }
            }

            // 如果 PowerShell 失败，回退到使用 systeminfo
            if (!$usePowerShell) {
                $systemInfo = shell_exec('systeminfo');
                if ($systemInfo) {
                    // 解析 CPU 信息
                    if (preg_match('/Processor\(s\):\s+([^\n]+)/', $systemInfo, $matches)) {
                        $data['cpu_name'] = trim($matches[1]);
                    }
                    
                    if (preg_match('/Number of Processors:\s+(\d+)/', $systemInfo, $matches)) {
                        $data['cpu_cores'] = intval($matches[1]);
                        $data['cpu_logical_cores'] = intval($matches[1]);
                    }

                    // 获取 CPU 使用率（使用 tasklist 作为备选方案）
                    $tasklist = shell_exec('tasklist /FI "IMAGENAME eq System" /FO CSV /NH');
                    if ($tasklist) {
                        $data['cpu_usage'] = 0; // 暂时设为0，因为 tasklist 不提供 CPU 使用率
                    }
                }
            }

            // 获取内存信息
            $systemInfo = shell_exec('systeminfo');
            if ($systemInfo) {
                if (preg_match('/Total Physical Memory:\s+([\d,]+)/', $systemInfo, $matches)) {
                    $memory = str_replace(',', '', $matches[1]);
                    $data['total_memory'] = intval($memory) * 1024 * 1024; // Convert to bytes
                }

                if (preg_match('/Available Physical Memory:\s+([\d,]+)/', $systemInfo, $matches)) {
                    $memory = str_replace(',', '', $matches[1]);
                    $data['available_memory'] = intval($memory) * 1024 * 1024; // Convert to bytes
                }
            }

            // 验证数据
            foreach ($data as $key => $value) {
                if ($key !== 'cpu_name' && (!is_numeric($value) || $value < 0)) {
                    $data[$key] = $defaultData[$key];
                }
            }

            $this->setCache($cacheKey, $data);
            return $data;
        } catch (\Throwable $e) {
            error_log("ServerMonitor error: " . $e->getMessage());
        }

        return $defaultData;
    }

    /**
     * 获取cpu信息
     * @return array
     */
    public function getCpuInfo(): array
    {
        try {
            if (PHP_OS == 'Linux') {
                $cpu = $this->getCpuUsage();
                preg_match('/(\d+)/', shell_exec('cat /proc/cpuinfo | grep "cache size"') ?? '', $cache);
                if (count($cache) == 0) {
                    // aarch64 有可能是arm架构
                    $cache = trim(shell_exec("lscpu | grep L3 | awk '{print \$NF}'") ?? '');
                    if ($cache == '') {
                        $cache = trim(shell_exec("lscpu | grep L2 | awk '{print \$NF}'") ?? '');
                    }
                    if ($cache != '') {
                        $cache = [0, intval(str_replace(['K', 'B'], '', strtoupper($cache)))];
                    }
                }
            } elseif (PHP_OS == 'Darwin') { // macOS
                $cpu = trim(shell_exec("ps -A -o %cpu | awk '{s+=$1} END {print s}'"));
                $cpu = sprintf("%.2f",intval($cpu) / shell_exec("sysctl -n hw.ncpu"));
                $cache = shell_exec("sysctl -n hw.l3cachesize");
                if ($cache == '') {
                    $cache = shell_exec("sysctl -n hw.l2cachesize");
                }
                if ($cache != '') {
                    $cache = [0, intval($cache)];
                }
            } else {
                $info = $this->getWindowsSystemInfo();
                $cache = $info['cpu_l3_cache'] ?: $info['cpu_l2_cache'];
                return [
                    'name' => $info['cpu_name'],
                    'cores' => '物理核心数：' . $info['cpu_cores'] . '个，逻辑核心数：' . $info['cpu_logical_cores'] . '个',
                    'cache' => $cache ? $cache / 1024 : 0,
                    'usage' => $info['cpu_usage'],
                    'free' => sprintf("%.2f", round(100 - $info['cpu_usage'], 2))
                ];
            }
            return [
                'name' => $this->getCpuName(),
                'cores' => '物理核心数：' . $this->getCpuPhysicsCores() . '个，逻辑核心数：' . $this->getCpuLogicCores() . '个',
                'cache' => $cache[1] ? $cache[1] / 1024 : 0,
                'usage' => $cpu,
                'free' => sprintf("%.2f",round(100 - $cpu, 2))
            ];
        } catch (\Throwable $e) {
            $res = '无法获取';
            echo $e->getMessage(), "\n";
            return [
                'name' => $res,
                'cores' => $res,
                'cache' => $res,
                'usage' => $res,
                'free' => $res,
            ];
        }
    }

    /**
     * 获取CPU名称
     * @return string
     */
    public function getCpuName(): string
    {
        if (PHP_OS == 'Linux') {
            preg_match('/^\s+\d\s+(.+)/', shell_exec('cat /proc/cpuinfo | grep name | cut -f2 -d: | uniq -c') ?? '', $matches);
            if (count($matches) == 0) {
                // aarch64 有可能是arm架构
                $name = trim(shell_exec("lscpu| grep Architecture | awk '{print $2}'") ?? '');
                if ($name != '') {
                    $mfMhz = trim(shell_exec("lscpu| grep 'MHz' | awk '{print \$NF}' | head -n1") ?? '');
                    $mfGhz = trim(shell_exec("lscpu| grep 'GHz' | awk '{print \$NF}' | head -n1") ?? '');
                    if ($mfMhz == '' && $mfGhz == '') {
                        return $name;
                    } else if ($mfGhz != '') {
                        return $name . ' @ ' . $mfGhz . 'GHz';
                    } else if ($mfMhz != '') {
                        return $name . ' @ ' . round(intval($mfMhz) / 1000, 2) . 'GHz';
                    }
                } else {
                    return '未知';
                }
            }
            return $matches[1] ?? "未知";
        } elseif (PHP_OS == 'Darwin') { // macOS
            $name = shell_exec("sysctl -n machdep.cpu.brand_string");
            return trim($name);
        } else {
            $info = $this->getWindowsSystemInfo();
            return $info['cpu_name'];
        }
    }

    /**
     * 获取cpu物理核心数
     */
    public function getCpuPhysicsCores(): string
    {
        if (PHP_OS == 'Linux') {
            $num = str_replace("\n", '', shell_exec('cat /proc/cpuinfo |grep "physical id"|sort |uniq|wc -l'));
            return intval($num) == 0 ? '1' : $num;
        } elseif (PHP_OS == 'Darwin') { // macOS
            $num = shell_exec('sysctl -n hw.physicalcpu');
            return trim(strval($num));
        } else {
            $info = $this->getWindowsSystemInfo();
            return strval($info['cpu_cores']);
        }
    }

    /**
     * 获取cpu逻辑核心数
     */
    public function getCpuLogicCores(): string
    {
        if (PHP_OS == 'Linux') {
            return str_replace("\n", '', shell_exec('cat /proc/cpuinfo |grep "processor"|wc -l'));
        } elseif (PHP_OS == 'Darwin') { // macOS
            return trim(strval(shell_exec('sysctl -n hw.logicalcpu')));
        } else {
            $info = $this->getWindowsSystemInfo();
            return strval($info['cpu_logical_cores']);
        }
    }

    /**
     * 获取CPU使用率
     * @return string
     */
    public function getCpuUsage(): string
    {
        if (PHP_OS == 'Linux') {
            $start = $this->calculationCpu();
            sleep(1);
            $end = $this->calculationCpu();

            $totalStart = $start['total'];
            $totalEnd = $end['total'];

            $timeStart = $start['time'];
            $timeEnd = $end['time'];

            return sprintf('%.2f', ($timeEnd - $timeStart) / ($totalEnd - $totalStart) * 100);
        } elseif (PHP_OS == 'Darwin') { // macOS
            $usage = shell_exec("ps -A -o %cpu | awk '{s+=$1} END {print s}'");
            return sprintf('%.2f', $usage / shell_exec("sysctl -n hw.ncpu"));
        } else {
            $info = $this->getWindowsSystemInfo();
            return sprintf('%.2f', $info['cpu_usage']);
        }
    }

    /**
     * 计算CPU
     * @return array
     */
    protected function calculationCpu(): array
    {
        $mode = '/(cpu)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)/';
        $string = shell_exec('cat /proc/stat | grep cpu');
        preg_match_all($mode, $string, $matches);

        $total = $matches[2][0] + $matches[3][0] + $matches[4][0] + $matches[5][0] + $matches[6][0] + $matches[7][0] + $matches[8][0] + $matches[9][0];
        $time = $matches[2][0] + $matches[3][0] + $matches[4][0] + $matches[6][0] + $matches[7][0] + $matches[8][0] + $matches[9][0];

        return ['total' => $total, 'time' => $time];
    }

    /**
     * 获取内存信息
     * @return array
     */
    public function getMemInfo(): array
    {
        if (PHP_OS == 'Linux') {
            $string = shell_exec('cat /proc/meminfo | grep MemTotal');
            preg_match('/(\d+)/', $string, $total);
            $result['total'] = sprintf('%.2f', $total[1] / 1024 / 1024);

            $string = shell_exec('cat /proc/meminfo | grep MemAvailable');
            preg_match('/(\d+)/', $string, $available);

            $result['free'] = sprintf('%.2f', $available[1] / 1024 / 1024);

            $result['usage'] = sprintf('%.2f', ($total[1] - $available[1]) / 1024 / 1024);

            $result['php'] = round(memory_get_usage() / 1024 / 1024, 2);

            $result['rate'] = sprintf(
                '%.2f',
                (sprintf('%.2f', $result['usage']) / sprintf('%.2f', $result['total'])) * 100
            );
        } elseif (PHP_OS == 'Darwin') { // macOS
            $result['total'] = round(intval(shell_exec('sysctl -n hw.memsize')) / 1024 / 1024 / 1024, 2);

            $free = shell_exec('vm_stat | grep "Pages free"');
            preg_match('/(\d+)/', $free, $matches);
            $result['free'] = round(intval($matches[1]) * 4096 / 1024 / 1024 / 1024, 2);

            $result['usage'] = round($result['total'] - $result['free'], 2);

            $result['php'] = round(memory_get_usage() / 1024 / 1024, 2);

            $result['rate'] = sprintf(
                '%.2f',
                (sprintf('%.2f', $result['usage']) / sprintf('%.2f', $result['total'])) * 100
            );
        } else {
            $info = $this->getWindowsSystemInfo();
            $result['total'] = round($info['total_memory'] / 1024 / 1024 / 1024, 2);
            $result['free'] = round($info['available_memory'] / 1024 / 1024 / 1024, 2);
            $result['usage'] = round($result['total'] - $result['free'], 2);
            $result['php'] = round(memory_get_usage() / 1024 / 1024, 2);
            
            // 防止除以0错误
            if ($result['total'] > 0) {
                $result['rate'] = sprintf(
                    '%.2f',
                    (sprintf('%.2f', $result['usage']) / sprintf('%.2f', $result['total'])) * 100
                );
            } else {
                $result['rate'] = '0.00';
            }
            
            return $result;
        }

        return $result;
    }

    /**
     * 获取PHP及环境信息
     * @return array
     */
    public function getPhpAndEnvInfo(): array
    {

        $result['php_version'] = PHP_VERSION;

        $result['os'] = PHP_OS_FAMILY;

        $result['project_path'] = BASE_PATH;

        return $result;
    }
}