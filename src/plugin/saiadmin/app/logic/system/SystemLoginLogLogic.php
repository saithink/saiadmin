<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\system;

use plugin\saiadmin\app\model\system\SystemLoginLog;
use plugin\saiadmin\basic\think\BaseLogic;
use plugin\saiadmin\utils\Helper;
use support\think\Db;

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
     * 登录统计图表（近 10 天每日登录次数）
     * @return array
     */
    public function loginChart(): array
    {
        $days = 10;
        $table = $this->model->getTableName();
        // CAST(x AS DATE) 是 MySQL / PostgreSQL 通用写法，取代 MySQL 专有的 CURDATE()、DATE()、INTERVAL N DAY
        $sql = "SELECT CAST(login_time AS DATE) AS login_date, COUNT(*) AS login_count
                FROM {$table}
                WHERE login_time >= :start AND login_time < :end
                GROUP BY CAST(login_time AS DATE)";
        $data = Db::query($sql, [
            'start' => date('Y-m-d 00:00:00', strtotime('-' . ($days - 1) . ' day')),
            'end' => date('Y-m-d 00:00:00', strtotime('+1 day')),
        ]);

        // 没有登录记录的日期数据库不会返回，日期轴与补 0 都在 PHP 侧完成
        $counts = [];
        foreach ($data as $row) {
            $counts[substr((string) $row['login_date'], 0, 10)] = (int) $row['login_count'];
        }

        $dates = [];
        $values = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-{$i} day"));
            $dates[] = $date;
            $values[] = $counts[$date] ?? 0;
        }

        return [
            'login_count' => $values,
            'login_date' => $dates,
        ];
    }

    /**
     * 登录统计图表（本年度每月登录次数）
     * @return array
     */
    public function loginBarChart(): array
    {
        $year = (int) date('Y');
        $table = $this->model->getTableName();
        // EXTRACT(MONTH FROM x) 两种数据库通用，取代 MySQL 专有的 YEAR()、MONTH()、CURDATE()、LPAD()
        $sql = "SELECT EXTRACT(MONTH FROM login_time) AS login_month, COUNT(*) AS login_count
                FROM {$table}
                WHERE login_time >= :start AND login_time < :end
                GROUP BY EXTRACT(MONTH FROM login_time)";
        $data = Db::query($sql, [
            'start' => $year . '-01-01 00:00:00',
            'end' => ($year + 1) . '-01-01 00:00:00',
        ]);

        // 12 个月的标签固定输出，没有记录的月份补 0
        $counts = [];
        foreach ($data as $row) {
            $counts[(int) $row['login_month']] = (int) $row['login_count'];
        }

        $months = [];
        $values = [];
        for ($month = 1; $month <= 12; $month++) {
            $months[] = sprintf('%02d月', $month);
            $values[] = $counts[$month] ?? 0;
        }

        return [
            'login_count' => $values,
            'login_month' => $months,
        ];
    }

}
