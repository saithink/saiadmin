<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\basic\contracts;

/**
 * Model 接口定义
 * 所有 Model 基类必须实现此接口
 */
interface ModelInterface
{
    /**
     * 获取表名
     * @return string
     */
    public function getTableName(): string;

    /**
     * 获取主键名
     * @return string
     */
    public function getPrimaryKeyName(): string;

}
