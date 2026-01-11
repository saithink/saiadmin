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
    /**
     * 获取内存信息
     * @return array
     */
    public function getMemoryInfo(): array
    {
        $totalMem = 0; // 总内存 (Bytes)
        $freeMem  = 0; // 可用/剩余内存 (Bytes)

        if (stristr(PHP_OS, 'WIN')) {
            // Windows 系统
            // 一次性获取 总可见内存 和 空闲物理内存 (单位都是 KB)
            // TotalVisibleMemorySize: 操作系统可识别的内存总数 (比物理内存条总数略少，更准确反映可用上限)
            // FreePhysicalMemory: 当前可用物理内存
            $cmd = 'wmic OS get FreePhysicalMemory,TotalVisibleMemorySize /format:csv';
            $output = shell_exec($cmd);
            $output = mb_convert_encoding($output ?? '', 'UTF-8', 'GBK, UTF-8, ASCII');
            $lines  = explode("\n", trim($output));

            foreach ($lines as $line) {
                $line = trim($line);
                if (empty($line)) continue;

                // CSV 格式: Node,FreePhysicalMemory,TotalVisibleMemorySize
                $parts = str_getcsv($line);

                // 确保解析正确且排除标题行 (通常索引1是Free, 2是Total)
                if (count($parts) >= 3 && is_numeric($parts[1])) {
                    $freeMem  = floatval($parts[1]) * 1024; // KB -> Bytes
                    $totalMem = floatval($parts[2]) * 1024; // KB -> Bytes
                    break;
                }
            }
        } else {
            // Linux 系统
            // 读取 /proc/meminfo，效率远高于 shell_exec('cat ...')
            $memInfo = @file_get_contents('/proc/meminfo');
            if ($memInfo) {
                // 使用正则提取 MemTotal 和 MemAvailable (单位 kB)
                // MemAvailable 是较新的内核指标，比单纯的 MemFree 更准确（包含可回收的缓存）
                if (preg_match('/^MemTotal:\s+(\d+)\s+kB/m', $memInfo, $matches)) {
                    $totalMem = floatval($matches[1]) * 1024;
                }

                if (preg_match('/^MemAvailable:\s+(\d+)\s+kB/m', $memInfo, $matches)) {
                    $freeMem = floatval($matches[1]) * 1024;
                } else {
                    // 如果内核太老没有 MemAvailable，退化使用 MemFree
                    if (preg_match('/^MemFree:\s+(\d+)\s+kB/m', $memInfo, $matches)) {
                        $freeMem = floatval($matches[1]) * 1024;
                    }
                }
            }
        }

        // 计算已用内存
        $usedMem = $totalMem - $freeMem;

        // 避免除以0
        $rate = ($totalMem > 0) ? ($usedMem / $totalMem) * 100 : 0;

        // PHP 自身占用
        $phpMem = memory_get_usage(true);

        return [
            // 人类可读格式 (String)
            'total'     => $this->formatBytes($totalMem),
            'free'      => $this->formatBytes($freeMem),
            'used'      => $this->formatBytes($usedMem),
            'php'       => $this->formatBytes($phpMem),
            'rate'      => sprintf('%.2f', $rate) . '%',

            // 原始数值 (Float/Int)，方便前端图表使用或逻辑判断，统一单位 Bytes
            'raw' => [
                'total' => $totalMem,
                'free'  => $freeMem,
                'used'  => $usedMem,
                'php'   => $phpMem,
                'rate'  => round($rate, 2)
            ]
        ];
    }

    /**
     * 获取PHP及环境信息
     * @return array
     */
    public function getPhpAndEnvInfo(): array
    {
        return [
            'php_version'         => PHP_VERSION,
            'os'                  => PHP_OS,
            'project_path'        => BASE_PATH,
            'memory_limit'        => ini_get('memory_limit'),
            'max_execution_time'  => ini_get('max_execution_time'),
            'error_reporting'     => ini_get('error_reporting'),
            'display_errors'      => ini_get('display_errors'),
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'post_max_size'       => ini_get('post_max_size'),
            'extension_dir'       => ini_get('extension_dir'),
            'loaded_extensions'   => implode(', ', get_loaded_extensions()),
        ];
    }

    /**
     * 获取磁盘信息
     * @return array
     */
    public function getDiskInfo(): array
    {
        $disk = [];

        if (stristr(PHP_OS, 'WIN')) {
            // Windows 系统
            // 使用 CSV 格式输出，避免空格解析错误；SkipTop=1 跳过空行
            // LogicalDisk 包含: Caption(盘符), FreeSpace(剩余字节), Size(总字节)
            $cmd = 'wmic logicaldisk get Caption,FreeSpace,Size /format:csv';
            $output = shell_exec($cmd);

            // 转换编码，防止中文乱码（视服务器环境而定，通常 Windows CMD 输出为 GBK）
            $output = mb_convert_encoding($output ?? '', 'UTF-8', 'GBK, UTF-8, ASCII');
            $lines = explode("\n", trim($output));

            foreach ($lines as $line) {
                $line = trim($line);
                if (empty($line)) continue;

                // CSV 格式: Node,Caption,FreeSpace,Size
                $parts = str_getcsv($line);

                // 确保数据列足够且是一个盘符 (例如 "C:")
                // 索引通常是: 1=>Caption, 2=>FreeSpace, 3=>Size (索引0通常是计算机名)
                if (count($parts) >= 4 && preg_match('/^[A-Z]:$/', $parts[1])) {
                    $caption   = $parts[1];
                    $freeSpace = floatval($parts[2]);
                    $totalSize = floatval($parts[3]);

                    // 避免除以 0 错误（如光驱未放入光盘时 Size 可能为 0 或 null）
                    if ($totalSize <= 0) continue;

                    $usedSpace = $totalSize - $freeSpace;

                    $disk[] = [
                        'filesystem'     => $caption,
                        'mounted_on'     => $caption,
                        'size'           => $this->formatBytes($totalSize),
                        'available'      => $this->formatBytes($freeSpace),
                        'used'           => $this->formatBytes($usedSpace),
                        'use_percentage' => sprintf('%.2f', ($usedSpace / $totalSize) * 100) . '%',
                        'raw'            => [ // 保留原始数据以便前端或其他逻辑使用
                            'size'      => $totalSize,
                            'available' => $freeSpace,
                            'used'      => $usedSpace
                        ]
                    ];
                }
            }

        } else {
            // Linux 系统
            // -P: POSIX 输出格式（强制在一行显示，防止长挂载点换行）
            // -T: 显示文件系统类型
            // 默认单位是 1K-blocks (1024字节)
            $output = shell_exec('df -TP 2>/dev/null');
            $lines = explode("\n", trim($output ?? ''));

            // 过滤表头
            array_shift($lines);

            foreach ($lines as $line) {
                $line = trim($line);
                if (empty($line)) continue;

                // 限制分割数量，防止挂载点名称中有空格导致解析错位（虽然 -P 很大程度避免了这个问题，但仍需谨慎）
                $parts = preg_split('/\s+/', $line);

                // df -TP 输出列: Filesystem(0), Type(1), 1024-blocks(2), Used(3), Available(4), Capacity(5), Mounted on(6)
                if (count($parts) >= 7) {
                    $filesystem = $parts[0];
                    $type       = $parts[1];
                    $totalKB    = floatval($parts[2]); // 单位是 KB
                    $usedKB     = floatval($parts[3]);
                    $availKB    = floatval($parts[4]);
                    $mountedOn  = $parts[6];

                    // 过滤逻辑：只显示物理硬盘或特定挂载点
                    // 通常过滤掉 tmpfs, devtmpfs, overlay, squashfs(snap) 等
                    // 如果你只想看 /dev/ 开头的物理盘，保留原来的正则即可
                    if (!preg_match('/^\/dev\//', $filesystem)) {
                        // continue; // 根据需求决定是否取消注释此行
                    }
                    // 过滤掉 Docker overlay 或 kubelet 等产生的繁杂挂载
                    if (strpos($filesystem, 'overlay') !== false) continue;

                    // 转换为字节
                    $totalSize = $totalKB * 1024;
                    $usedSize  = $usedKB * 1024;
                    $freeSize  = $availKB * 1024;

                    if ($totalSize <= 0) continue;

                    $disk[] = [
                        'filesystem'     => $filesystem,
                        'type'           => $type,
                        'mounted_on'     => $mountedOn,
                        'size'           => $this->formatBytes($totalSize),
                        'available'      => $this->formatBytes($freeSize),
                        'used'           => $this->formatBytes($usedSize),
                        'use_percentage' => sprintf('%.2f', ($usedSize / $totalSize) * 100) . '%',
                        'raw'            => [
                            'size'      => $totalSize,
                            'available' => $freeSize,
                            'used'      => $usedSize
                        ]
                    ];
                }
            }
        }
        return $disk;
    }

    /**
     * 格式化字节为可读格式 (B, KB, MB, GB, TB...)
     * @param int|float $bytes 字节数
     * @param int $precision 小数点后保留位数
     * @return string
     */
    private function formatBytes($bytes, int $precision = 2): string
    {
        if ($bytes <= 0) {
            return '0 B';
        }
        $base = log($bytes, 1024);
        $suffixes = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB'];
        // 确保不会数组越界
        $class = min((int)floor($base), count($suffixes) - 1);
        return sprintf("%." . $precision . "f", $bytes / pow(1024, $class)) . ' ' . $suffixes[$class];
    }

}