<?php
declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

require_once __DIR__ . '/../support/SaiSeed.php';

/**
 * 纯净版初始数据（基础菜单/配置/字典/管理员等），仅在全新安装时执行一次。
 *
 * 数据存放在 data/pure.php，由预处理语句绑定写入，MySQL / PostgreSQL 通用。
 * seeder 不被 phinxlog 跟踪，重复执行会因主键冲突报错。
 */
final class PureSeeder extends AbstractSeed
{
    use SaiSeed;

    public function run(): void
    {
        $this->seedFromFile(__DIR__ . '/../data/pure.php');
    }
}
