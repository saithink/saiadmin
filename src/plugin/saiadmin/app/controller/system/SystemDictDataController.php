<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\controller\system;

use plugin\saiadmin\basic\BaseController;
use plugin\saiadmin\app\logic\system\SystemDictDataLogic;
use plugin\saiadmin\app\validate\system\SystemDictDataValidate;
use support\Cache;
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
     * 修改状态
     * @param Request $request
     * @return Response
     */
    public function changeStatus(Request $request) : Response
    {
        $id = $request->input('id', '');
        $status = $request->input('status', 1);
        $model = $this->logic->findOrEmpty($id);
        if ($model->isEmpty()) {
            return $this->fail('未查找到信息');
        }
        $result = $model->save(['status' => $status]);
        if ($result) {
            $this->afterChange('changeStatus', $model);
            return $this->success('操作成功');
        } else {
            return $this->fail('操作失败');
        }
    }

    /**
     * 数据改变后执行
     * @param $type
     * @param $args
     * @return void
     */
    protected function afterChange($type, $args): void
    {
        if (in_array($type, ['save', 'update'])) {
            Cache::delete(request()->input('code'));
        }
        if ($type === 'changeStatus') {
            $id = request()->input('id', '');
            $info = $this->logic->findOrEmpty($id);
            if (!$info->isEmpty()) {
                Cache::delete($info->code);
            }
        }
        if ($type === 'destroy') {
            $ids = request()->input('ids', '');
            if (is_array($ids)) {
                $id = $ids[0];
                $info = $this->logic->findOrEmpty($id);
                if (!$info->isEmpty()) {
                    Cache::delete($info->code);
                }
            }
        }
    }
}
