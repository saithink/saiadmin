<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\tool;

use plugin\saiadmin\basic\BaseModel;
/**
 * 代码生成业务字段模型
 * Class GenerateColumns
 * @package app\model
 */
class GenerateColumns extends BaseModel
{
    /**
     * 数据表主键
     * @var string
     */
    protected $pk = 'id';

    protected $table = 'eb_tool_generate_columns';

    public function getOptionsAttr($value)
    {
        return json_decode($value ?? '', true);
    }

}