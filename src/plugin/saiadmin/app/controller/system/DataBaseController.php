<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\controller\system;

use plugin\saiadmin\app\logic\system\DatabaseLogic;
use plugin\saiadmin\basic\BaseController;
use support\Request;
use support\Response;

/**
 * 数据表维护控制器
 */
class DataBaseController extends BaseController
{
    /**
     * 构造
     */
    public function __construct()
    {
        $this->logic = new DatabaseLogic();
        parent::__construct();
    }

    /**
     * 数据列表
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $where = $request->more([
            ['name', ''],
            ['source', ''],
        ]);
        $data = $this->logic->getList($where);
        return $this->success($data);
    }

    /**
     * 数据源列表
     * @return Response
     */
    public function source(): Response
    {
        $list = dbSourceList();
        return $this->success($list);
    }

    /**
     * 回收站数据
     * @param Request $request
     * @return Response
     */
    public function recycle(Request $request): Response
    {
        $table = $request->input('table', '');
        $data = $this->logic->recycleData($table);
        return $this->success($data);
    }

    /**
     * 销毁数据
     * @param Request $request
     * @return Response
     */
    public function delete(Request $request): Response
    {
        $table = $request->input('table', '');
        $ids = $request->input('ids', '');
        if (!empty($ids)) {
            $result = $this->logic->delete($table, $ids);
            if (!$result) {
                return $this->fail('操作失败');
            }
            return $this->success('操作成功');
        } else {
            return $this->fail('参数错误，请检查');
        }
    }

    /**
     * 恢复数据
     * @param Request $request
     * @return Response
     */
    public function recovery(Request $request): Response
    {
        $table = $request->input('table', '');
        $ids = $request->input('ids', '');
        if (!empty($ids)) {
            $result = $this->logic->recovery($table, $ids);
            if (!$result) {
                return $this->fail('操作失败');
            }
            return $this->success('操作成功');
        } else {
            return $this->fail('参数错误，请检查');
        }
    }

    /**
     * 获取表字段信息
     * @param Request $request
     * @return Response
     */
    public function detailed(Request $request): Response
    {
        $table = $request->input('table', '');
        $data = $this->logic->getColumnList($table, '');
        return $this->success($data);
    }

    /**
     * 优化表
     * @param Request $request
     * @return Response
     */
    public function optimize(Request $request): Response
    {
        $tables = $request->input('tables', []);
        $this->logic->optimizeTable($tables);
        return $this->success('优化成功');
    }

    /**
     * 清理表碎片
     */
    public function fragment(Request $request): Response
    {
        $tables = $request->input('tables', []);
        $this->logic->fragmentTable($tables);
        return $this->success('清理成功');
    }

}