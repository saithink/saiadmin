<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\utils;

use Phinx\Config\Config;
use Phinx\Config\ConfigInterface;
use Phinx\Console\PhinxApplication;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * Phinx 运行器：在当前进程内调用 Phinx 命令（迁移/种子），
 * 供安装向导、sai:migrate 命令与插件安装器共用。
 */
class PhinxRunner
{
    /**
     * 核心迁移配置文件路径
     * 配置随插件走：plugin/saiadmin/utils → plugin/saiadmin/db/phinx.php
     */
    public static function corePhinxFile(): string
    {
        return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'phinx.php';
    }

    /**
     * 运行一条 Phinx 命令
     * @param string $command migrate|seed|rollback|status（seed 会映射为 Phinx 的 seed:run）
     * @param array $args 额外参数，如 ['--seed' => ['PureSeeder']]、['--target' => '0']
     * @param ConfigInterface|array|string|null $preset 预置配置：
     *        null 用核心的 phinx.php；字符串当作配置文件路径；
     *        数组/Config 则直接注入内存配置（插件迁移用这条，见 PluginMigrator::config()）
     * @return array{ok: bool, output: string, exitCode: int}
     */
    public static function run(string $command, array $args = [], ConfigInterface|array|string|null $preset = null): array
    {
        // 预设终端尺寸，避免 Symfony 探测真实终端（Windows 下会 spawn mode CON 子进程）
        putenv('COLUMNS=120');
        putenv('LINES=40');

        // Phinx 注册的命令名是 seed:run，直接传 seed 会被当作命名空间输出帮助信息
        if ($command === 'seed') {
            $command = 'seed:run';
        }

        $configFile = self::corePhinxFile();
        $config = null;
        if ($preset instanceof ConfigInterface) {
            $config = $preset;
        } elseif (is_array($preset)) {
            $config = new Config($preset, $configFile);
        } elseif (is_string($preset) && $preset !== '') {
            $configFile = $preset;
        }

        $application = new PhinxApplication();
        // 必须关闭 autoExit，否则 Symfony 在运行结束时会 exit() 杀死 webman 常驻进程
        $application->setAutoExit(false);

        $base = ['command' => $command, '--environment' => 'db'];
        if ($config === null) {
            $base['--configuration'] = $configFile;
        }
        $input = new ArrayInput(array_merge($base, $args));
        $input->setInteractive(false);

        $output = new BufferedOutput();
        try {
            if ($config !== null) {
                // AbstractCommand::bootstrap() 只在 !hasConfig() 时才去 loadConfig()，
                // 而 find() 返回的就是稍后 run() 要执行的那个命令实例，注入到它身上即可生效。
                // 每次调用都是新的 PhinxApplication，实例之间不会串配置
                $cmd = $application->find($command);
                if (method_exists($cmd, 'setConfig')) {
                    $cmd->setConfig($config);
                }
            }
            $exitCode = $application->run($input, $output);
        } catch (\Throwable $e) {
            return ['ok' => false, 'output' => $e->getMessage(), 'exitCode' => 1];
        }

        return ['ok' => $exitCode === 0, 'output' => $output->fetch(), 'exitCode' => $exitCode];
    }

    /**
     * 提取 Phinx 错误输出的尾部信息，用于接口提示
     * @param string $output 完整输出
     * @param int $length 最大字符数
     */
    public static function errorTail(string $output, int $length = 1200): string
    {
        $lines = preg_split('/\r\n|\r|\n/', trim($output)) ?: [];
        $lines = array_values(array_filter($lines, static fn ($line) => trim($line) !== ''));
        if ($lines === []) {
            return '未知错误';
        }
        $tail = implode("\n", array_slice($lines, -10));

        return mb_substr($tail, -$length);
    }
}
