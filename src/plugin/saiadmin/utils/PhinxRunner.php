<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\utils;

use Phinx\Console\PhinxApplication;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * Phinx 运行器：在当前进程内调用 Phinx 命令（迁移/种子），
 * 供安装向导与 sai:migrate 命令共用。
 */
class PhinxRunner
{
    /**
     * 运行一条 Phinx 命令
     * @param string $command migrate|seed|rollback|status（seed 会映射为 Phinx 的 seed:run）
     * @param array $args 额外参数，如 ['--seed' => ['PureSeeder']]、['--target' => '0']
     * @return array{ok: bool, output: string, exitCode: int}
     */
    public static function run(string $command, array $args = []): array
    {
        // 预设终端尺寸，避免 Symfony 探测真实终端（Windows 下会 spawn mode CON 子进程）
        putenv('COLUMNS=120');
        putenv('LINES=40');

        // Phinx 注册的命令名是 seed:run，直接传 seed 会被当作命名空间输出帮助信息
        if ($command === 'seed') {
            $command = 'seed:run';
        }

        $application = new PhinxApplication();
        // 必须关闭 autoExit，否则 Symfony 在运行结束时会 exit() 杀死 webman 常驻进程
        $application->setAutoExit(false);

        $input = new ArrayInput(array_merge([
            'command' => $command,
            // 配置随插件走：plugin/saiadmin/utils → plugin/saiadmin/db/phinx.php
            '--configuration' => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'phinx.php',
            '--environment' => 'db',
        ], $args));
        $input->setInteractive(false);

        $output = new BufferedOutput();
        try {
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
