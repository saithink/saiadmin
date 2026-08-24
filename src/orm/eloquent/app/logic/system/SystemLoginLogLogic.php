<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\system;

use plugin\saiadmin\app\model\system\SystemLoginLog;
use plugin\saiadmin\basic\eloquent\BaseLogic;
use plugin\saiadmin\utils\Helper;

/**
 * 登录日志逻辑层
 */
class SystemLoginLogLogic extends BaseLogic
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->model = new SystemLoginLog();
    }

    /**
     * 登录统计图表（近 10 天）
     * @return array
     */
    public function loginChart(): array
    {
        $days = 10;
        $start = date('Y-m-d', strtotime('-' . ($days - 1) . ' days'));

        // 聚合只用两种数据库通用的 CAST(x AS DATE)，日期轴与补 0 放在 PHP 侧完成，
        // 不要用 MySQL 专有的 CURDATE() / INTERVAL n DAY / DATE()，PG 没有这些写法
        $rows = $this->model->newQuery()
            ->where('login_time', '>=', $start . ' 00:00:00')
            ->groupByRaw('CAST(login_time AS DATE)')
            ->selectRaw('CAST(login_time AS DATE) AS login_date, COUNT(*) AS login_count')
            ->get();

        $counts = [];
        foreach ($rows as $row) {
            $counts[date('Y-m-d', strtotime((string) $row->login_date))] = (int) $row->login_count;
        }

        $login_date = [];
        $login_count = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $day = date('Y-m-d', strtotime('-' . $i . ' days'));
            $login_date[] = $day;
            $login_count[] = $counts[$day] ?? 0;
        }

        return compact('login_count', 'login_date');
    }

    /**
     * 登录统计图表（本年度按月）
     * @return array
     */
    public function loginBarChart(): array
    {
        $year = date('Y');

        // 同上，EXTRACT(MONTH FROM x) 两种数据库通用，YEAR() / MONTH() / LPAD() 只有 MySQL 有
        $rows = $this->model->newQuery()
            ->whereBetween('login_time', [$year . '-01-01 00:00:00', $year . '-12-31 23:59:59'])
            ->groupByRaw('EXTRACT(MONTH FROM login_time)')
            ->selectRaw('EXTRACT(MONTH FROM login_time) AS login_month, COUNT(*) AS login_count')
            ->get();

        $counts = [];
        foreach ($rows as $row) {
            $counts[(int) $row->login_month] = (int) $row->login_count;
        }

        $login_month = [];
        $login_count = [];
        for ($month = 1; $month <= 12; $month++) {
            $login_month[] = str_pad((string) $month, 2, '0', STR_PAD_LEFT) . '月';
            $login_count[] = $counts[$month] ?? 0;
        }

        return compact('login_count', 'login_month');
    }

}
