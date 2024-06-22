<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\basic;

use think\Model;
use think\model\concern\SoftDelete;

/**
 * 模型基类
 * @package plugin\saiadmin\basic
 */
class BaseModel extends Model
{
    use SoftDelete;
    // 删除时间
    protected $deleteTime = 'delete_time';
    // 添加时间
    protected $createTime = 'create_time';
    // 更新时间
    protected $updateTime = 'update_time';
    // 隐藏字段
    protected $hidden = ['delete_time'];
    // 只读字段
    protected $readonly = ['created_by', 'create_time'];

    /**
     * 时间范围搜索
     */
    public function searchCreateTimeAttr($query, $value)
    {
        $query->whereTime('create_time', 'between', $value);
    }

    /**
     * 新增前
     */
    public static function onBeforeInsert($model)
    {
        $info = getCurrentInfo();
        $info && $model->setAttr('created_by', $info['id']);
    }

    /**
     * 写入前
     */
    public static function onBeforeWrite($model)
    {
        $info = getCurrentInfo();
        $info && $model->setAttr('updated_by', $info['id']);
    }

}