<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\controller\system;

use plugin\saiadmin\app\logic\system\DatabaseLogic;
use plugin\saiadmin\basic\BaseController;
use plugin\saiadmin\service\Permission;
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
     * 数据源列表
     * @return Response
     */
    public function source(): Response
    {
        $data = $this->logic->getDbSource();
        return $this->success($data);
    }

    /**
     * 数据列表
     * @param Request $request
     * @return Response
     */
    #[Permission('数据表列表', 'core:database:index')]
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
     * 回收站数据
     * @param Request $request
     * @return Response
     */
    #[Permission('回收站数据', 'core:recycle:index')]
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
    #[Permission('回收站销毁', 'core:recycle:edit')]
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
    #[Permission('回收站恢复', 'core:recycle:edit')]
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
    #[Permission('数据表字段', 'core:database:index')]
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
    #[Permission('数据表优化表', 'core:database:edit')]
    public function optimize(Request $request): Response
    {
        $tables = $request->input('tables', []);
        $this->logic->optimizeTable($tables);
        return $this->success('优化成功');
    }

    /**
     * 清理表碎片
     */
    #[Permission('数据表清理碎片', 'core:database:edit')]
    public function fragment(Request $request): Response
    {
        $tables = $request->input('tables', []);
        $this->logic->fragmentTable($tables);
        return $this->success('清理成功');
    }

}