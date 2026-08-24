<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\command;

use plugin\saiadmin\utils\PhinxRunner;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * SaiAdmin 数据库迁移管理命令（基于 Phinx）
 * 结构由 plugin/saiadmin/db/migrations 管理，初始数据由 plugin/saiadmin/db/seeds 提供
 */
class SaiMigrate extends Command
{
    protected static $defaultName = 'sai:migrate';

    protected static $defaultDescription = 'SaiAdmin 数据库迁移管理 (Phinx)';

    protected function configure(): void
    {
        $this->setName('sai:migrate')
            ->setDescription('SaiAdmin 数据库迁移管理 (Phinx)')
            ->addArgument('action', InputArgument::OPTIONAL, '操作：migrate|rollback|status|seed', 'migrate')
            ->addOption('seed', 's', InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'seed 操作时指定要执行的 Seeder 类名')
            ->addOption('target', 't', InputOption::VALUE_REQUIRED, 'rollback 目标版本号（0 表示回退全部迁移，会删表！)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $action = $input->getArgument('action');
        if (!in_array($action, ['migrate', 'rollback', 'status', 'seed'], true)) {
            $output->writeln("<error>不支持的操作：{$action}，可选 migrate|rollback|status|seed</error>");

            return Command::FAILURE;
        }

        $args = [];
        if ($action === 'seed') {
            $seeds = (array) $input->getOption('seed');
            if ($seeds === []) {
                $output->writeln('<error>请通过 --seed 指定要执行的 Seeder，例如：php webman sai:migrate seed --seed PureSeeder</error>');

                return Command::FAILURE;
            }
            $args['--seed'] = $seeds;
        }
        if ($action === 'rollback') {
            $target = $input->getOption('target');
            if ($target !== null) {
                $args['--target'] = $target;
            }
            if ($target === '0') {
                $output->writeln('<comment>警告：即将回退全部迁移并删除所有基础表！</comment>');
            }
        }

        $result = PhinxRunner::run($action, $args);
        $output->write($result['output']);

        return $result['ok'] ? Command::SUCCESS : Command::FAILURE;
    }
}
