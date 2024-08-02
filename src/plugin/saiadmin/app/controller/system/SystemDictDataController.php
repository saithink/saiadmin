<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\controller\system;

use plugin\saiadmin\basic\BaseController;
use plugin\saiadmin\app\logic\system\SystemDictDataLogic;
use plugin\saiadmin\app\validate\system\SystemDictDataValidate;
use plugin\saiadmin\utils\Cache;
use support\Request;
use support\Response;

/**
 * 字典数据控制器
 */
class SystemDictDataController extends BaseController
{
    /**
     * 构造
     */
    public function __construct()
    {
        $this->logic = new SystemDictDataLogic();
        $this->validate = new SystemDictDataValidate;
        parent::__construct();
    }

    /**
     * 数据列表
     * @param Request $request
     * @return Response
     */
    public function index(Request $request) : Response
    {
        $where = $request->more([
            ['label', ''],
            ['value', ''],
            ['type_id', ''],
            ['status', ''],
        ]);
        $query = $this->logic->search($where);
        $data = $this->logic->getList($query);
        return $this->success($data);
    }

    /**
     * 数据改变后执行
     * @return void
     */
    public function afterChange($type)
    {
        if (in_array($type, ['save', 'update'])) {
            Cache::clear(request()->input('code'));
        }
        if ($type === 'changeStatus') {
            $id = request()->input('id', '');
            $info = $this->logic->find($id);
            if ($info) {
                Cache::clear($info->code);
            }
        }
        if ($type === 'destroy') {
            $ids = request()->input('ids', '');
            if (is_array($ids)) {
                $id = $ids[0];
                $info = $this->logic->find($id);
                if ($info) {
                    Cache::clear($info->code);
                }
            }
        }
    }
}
