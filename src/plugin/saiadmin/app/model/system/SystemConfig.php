<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\system;

use plugin\saiadmin\basic\BaseModel;

/**
 * 参数配置模型
 */
class SystemConfig extends BaseModel
{
    /**
     * 数据表主键
     * @var string
     */
    protected $pk = 'id';

    protected $table = 'sa_system_config';

    public function getConfigSelectDataAttr($value)
    {
        return json_decode($value ?? '', true);
    }

}