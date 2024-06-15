<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\system;

use plugin\saiadmin\basic\BaseModel;
/**
 * 字典类型模型
 * Class SystemDictType
 * @package app\model
 */
class SystemDictType extends BaseModel
{
    /**
     * 数据表主键
     * @var string
     */
    protected $pk = 'id';

    protected $table = 'eb_system_dict_type';

    public function dicts()
    {
        return $this->hasMany(SystemDictData::class, 'type_id', 'id');
    }

}