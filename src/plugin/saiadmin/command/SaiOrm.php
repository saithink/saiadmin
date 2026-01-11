<?php

namespace plugin\saiadmin\command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Question\ChoiceQuestion;

/**
 * SaiAdmin ORM 切换命令
 * 用于切换 saiadmin 插件的 ORM 实现 (think / eloquent)
 */
class SaiOrm extends Command
{
    protected static $defaultName = 'sai:orm';
    protected static $defaultDescription = '切换 SaiAdmin 使用的 ORM';

    /**
     * ORM 源文件目录
     */
    protected string $ormSourcePath;

    /**
     * 目标插件目录
     */
    protected string $pluginAppPath;

    /**
     * ORM 选项配置
     */
    protected array $ormOptions = [
        'think' => '1. ThinkORM (TopThink)',
        'eloquent' => '2. Eloquent ORM (Laravel)',
        'exit' => '3. 退出，什么也不做',
    ];

    protected function configure(): void
    {
        $this->setName('sai:orm')
            ->setDescription('切换 SaiAdmin 使用的 ORM');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('SaiAdmin ORM 切换工具');
        $io->text('此命令只切换 saiadmin 框架核心使用的 ORM, 不影响其他模块功能, 多种 ORM 可以同时使用!');
        $io->newLine();

        // 创建选择问题（编号从1开始）
        $helper = $this->getHelper('question');
        $choices = [
            1 => '1. ThinkORM (TopThink)',
            2 => '2. Eloquent ORM (Laravel)',
            3 => '3. 退出，什么也不做',
        ];
        $question = new ChoiceQuestion(
            '请选择要使用的 ORM 框架:',
            $choices,
            1 // 默认选中第一个
        );
        $question->setErrorMessage('选项 %s 无效');

        // 获取用户选择
        $selected = $helper->ask($input, $output, $question);

        // 根据选择的文本反查 key
        $selectedKey = array_search($selected, $choices);

        // 如果选择退出
        if ($selectedKey == 3) {
            $io->newLine();
            $io->info('已退出，什么也没做。');
            return Command::SUCCESS;
        }

        // 映射选项到 ORM 类型
        $ormMap = [1 => 'think', 2 => 'eloquent'];
        $orm = $ormMap[$selectedKey];

        $io->newLine();
        $io->section("您选择了: {$selected}");

        // 确认操作
        if (!$io->confirm('确定要切换吗？这将覆盖 saiadmin 核心代码文件', true)) {
            $io->warning('操作已取消');
            return Command::SUCCESS;
        }

        // 设置路径
        $this->ormSourcePath = BASE_PATH . '/vendor/saithink/saiadmin/src/orm/' . $orm . '/app';
        $this->pluginAppPath = BASE_PATH . '/plugin/saiadmin/app';

        // 检查源目录是否存在
        if (!is_dir($this->ormSourcePath)) {
            $io->error("ORM 源目录不存在: {$this->ormSourcePath}");
            return Command::FAILURE;
        }

        $io->section('开始复制文件...');

        try {
            $copiedFiles = $this->copyDirectory($this->ormSourcePath, $this->pluginAppPath, $io);

            $io->newLine();
            $io->success([
                "ORM 切换成功！",
                "已切换到: {$selected}",
                "复制文件数: {$copiedFiles}"
            ]);

            $io->note([
                '请重启 webman 服务使更改生效',
                '命令: php webman restart 或 php windows.php'
            ]);

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $io->error("切换失败: " . $e->getMessage());
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
}
