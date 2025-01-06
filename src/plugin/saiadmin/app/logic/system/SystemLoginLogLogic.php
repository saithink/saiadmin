<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\system;

use plugin\saiadmin\app\model\system\SystemLoginLog;
use plugin\saiadmin\basic\BaseLogic;
use plugin\saiadmin\utils\Helper;
use think\facade\Db;

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
     * 登录统计图表
     * @return array
     */
    public function loginChart(): array
    {
        $sql = "
            SELECT
                d.date AS login_date,
                COUNT(l.login_time) AS login_count
            FROM
                (SELECT CURDATE() - INTERVAL (a.N) DAY AS date
                 FROM (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3
                       UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6
                       UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) a
                 ) d
            LEFT JOIN eb_system_login_log l
                ON DATE(l.login_time) = d.date
            GROUP BY d.date
            ORDER BY d.date ASC;
        ";
        $data = Db::query($sql);
        return [
            'login_count' => array_column($data, 'login_count'),
            'login_date'  => array_column($data, 'login_date'),
        ];
    }

}
