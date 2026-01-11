<?php

namespace plugin\saiadmin\command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * SaiAdmin 升级命令
 * 用于从 vendor 目录升级 saiadmin 插件到最新版本
 */
class SaiUpgrade extends Command
{
    protected static $defaultName = 'sai:upgrade';
    protected static $defaultDescription = '升级 SaiAdmin 插件到最新版本';

    /**
     * 升级源目录
     */
    protected string $sourcePath;

    /**
     * 目标插件目录
     */
    protected string $targetPath;

    protected function configure(): void
    {
        $this->setName('sai:upgrade')
            ->setDescription('升级 SaiAdmin 插件到最新版本');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('SaiAdmin 升级工具');
        $io->text([
            '此命令将从 vendor 目录复制最新版本的 saiadmin 插件文件到 plugin 目录',
            '源目录: vendor/saithink/saiadmin/src/plugin/saiadmin',
            '目标目录: plugin/saiadmin',
        ]);
        $io->newLine();

        // 设置路径
        $this->sourcePath = BASE_PATH . '/vendor/saithink/saiadmin/src/plugin/saiadmin';
        $this->targetPath = BASE_PATH . '/plugin/saiadmin';

        // 检查源目录是否存在
        if (!is_dir($this->sourcePath)) {
            $io->error([
                "升级源目录不存在: {$this->sourcePath}",
                "请确保已通过 composer 安装了 saithink/saiadmin 包",
            ]);
            return Command::FAILURE;
        }

        // 获取版本信息
        $currentVersion = $this->getVersion($this->targetPath);
        $latestVersion = $this->getVersion($this->sourcePath);

        // 显示版本信息
        $io->section('版本信息');
        $io->table(
            ['项目', '版本'],
            [
                ['当前版本', $currentVersion ?: '未知'],
                ['最新版本', $latestVersion ?: '未知'],
            ]
        );

        // 版本对比提示
        if ($currentVersion && $latestVersion) {
            if (version_compare($currentVersion, $latestVersion, '>=')) {
                $io->success('当前已是最新版本！');
                if (!$io->confirm('是否仍要继续覆盖安装？', false)) {
                    $io->info('操作已取消');
                    return Command::SUCCESS;
                }
            } else {
                $io->info("发现新版本: {$currentVersion} → {$latestVersion}");
            }
        }

        // 警告信息
        $io->warning([
            "注意：此操作将覆盖 {$this->targetPath} 目录的现有文件！",
            "建议在执行前备份您的自定义修改。",
        ]);

        // 确认操作
        if (!$io->confirm('确定要执行升级操作吗？', false)) {
            $io->info('操作已取消');
            return Command::SUCCESS;
        }

        $io->section('开始升级...');

        try {
            $copiedFiles = $this->copyDirectory($this->sourcePath, $this->targetPath, $io);

            $io->newLine();
            $io->success([
                "SaiAdmin 升级成功！",
                "复制文件数: {$copiedFiles}",
            ]);

            $io->note([
                '请重启 webman 服务使更改生效',
                '命令: php webman restart 或 php windows.php',
            ]);

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $io->error("升级失败: " . $e->getMessage());
            return Command::FAILURE;
        }
    }

    /**
     * 递归复制目录
     * @param string $source 源目录
     * @param string $dest 目标目录
     * @param SymfonyStyle $io 输出接口
     * @return int 复制的文件数量
     */
    protected function copyDirectory(string $source, string $dest, SymfonyStyle $io): int
    {
        $count = 0;

        if (!is_dir($dest)) {
            mkdir($dest, 0755, true);
        }

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        // 先计算文件总数用于进度条
        $files = [];
        foreach ($iterator as $item) {
            if (!$item->isDir()) {
                $files[] = $item;
            }
        }

        // 创建进度条
        $io->progressStart(count($files));

        // 重新遍历并复制
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {
            $destPath = $dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName();

            if ($item->isDir()) {
                if (!is_dir($destPath)) {
                    mkdir($destPath, 0755, true);
                }
            } else {
                copy($item->getPathname(), $destPath);
                $count++;
                $io->progressAdvance();
            }
        }

        $io->progressFinish();

        return $count;
    }

    /**
     * 从目录中获取版本号
     * @param string $path 插件目录路径
     * @return string|null 版本号
     */
    protected function getVersion(string $path): ?string
    {
        $configFile = $path . '/config/app.php';

        if (!file_exists($configFile)) {
            return null;
        }

        try {
            $config = include $configFile;
            return $config['version'] ?? null;
        } catch (\Exception $e) {
            return null;
        }
    }
}
