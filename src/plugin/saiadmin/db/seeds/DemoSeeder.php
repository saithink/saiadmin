<?php
declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

require_once __DIR__ . '/../support/SaiSeed.php';

/**
 * 演示版初始数据：纯净版全部内容 + 文章模块演示数据，仅在全新安装时执行一次。
 *
 * 数据存放在 data/demo.php，由预处理语句绑定写入，MySQL / PostgreSQL 通用。
 * seeder 不被 phinxlog 跟踪，重复执行会因主键冲突报错。
 */
final class DemoSeeder extends AbstractSeed
{
    use SaiSeed;

    public function run(): void
    {
        $this->seedFromFile(__DIR__ . '/../data/demo.php');
    }
}
