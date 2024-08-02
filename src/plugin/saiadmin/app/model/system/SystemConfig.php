<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\system;

use think\Model;
use think\model\relation\HasMany;

/**
 * 参数配置信息模型
 * Class SystemConfig
 * @package app\model
 */
class SystemConfig extends Model
{
    /**
     * 数据表主键
     * @var string
     */
    protected $pk = 'id';

    protected $table = 'eb_system_config';

    public function getConfigSelectDataAttr($value)
    {
        return json_decode($value ?? '', true);
    }

}