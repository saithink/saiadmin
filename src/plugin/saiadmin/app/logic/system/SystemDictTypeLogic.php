<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\system;

use plugin\saiadmin\basic\BaseLogic;
use plugin\saiadmin\exception\ApiException;
use plugin\saiadmin\app\model\system\SystemDictType;
use plugin\saiadmin\app\model\system\SystemDictData;
use plugin\saiadmin\utils\Helper;
use think\db\Query;

/**
 * 字典类型逻辑层
 */
class SystemDictTypeLogic extends BaseLogic
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->model = new SystemDictType();
    }

    public function update($data, $where)
    {
        $this->model->update($data, $where);
        SystemDictData::update(['code' => $data['code']], ['type_id' => $where['id']]);
        return true;
    }

}
