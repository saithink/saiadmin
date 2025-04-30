<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\controller\tool;

use plugin\saiadmin\basic\BaseController;
use plugin\saiadmin\app\logic\tool\GenerateTablesLogic;
use plugin\saiadmin\app\validate\tool\GenerateTablesValidate;
use support\Request;
use support\Response;

/**
 * 代码生成控制器
 */
class GenerateTablesController extends BaseController
{
    /**
     * 构造
     */
    public function __construct()
    {
        $this->logic = new GenerateTablesLogic();
        $this->validate = new GenerateTablesValidate;
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
            ['table_name', ''],
        ]);
        $query = $this->logic->search($where);
        $data = $this->logic->getList($query);
        return $this->success($data);
    }

    /**
     * 装载数据表
     * @param Request $request
     * @return Response
     */
    public function loadTable(Request $request): Response
    {
        $names = $request->input('names', []);
        $source = $request->input('source', '');
        $this->logic->loadTable($names, $source);
        return $this->success('操作成功');
    }

    /**
     * 同步数据表字段信息
     * @param Request $request
     * @return Response
     */
    public function sync(Request $request): Response
    {
        $id = $request->input('id', '');
        $this->logic->sync($id);
        return $this->success('操作成功');
    }

    /**
     * 代码预览
     */
    public function preview(Request $request): Response
    {
        $id = $request->input('id', '');
        $data = $this->logic->preview($id);
        return $this->success($data);
    }

    /**
     * 代码生成
     */
    public function generate(Request $request): Response
    {
        $ids = $request->input('ids', '');
        $data = $this->logic->generate($ids);
        return response()->download($data['download'], $data['filename']);
    }

    /**
     * 生成到模块
     */
    public function generateFile(Request $request): Response
    {
        $id = $request->input('id', '');
        $this->logic->generateFile($id);
        return $this->success('操作成功');
    }

    /**
     * 获取数据表字段信息
     * @param Request $request
     * @return Response
     */
    public function getTableColumns(Request $request): Response
    {
        $table_id = $request->input('table_id', '');
        $data = $this->logic->getTableColumns($table_id);
        return $this->success($data);
    }

}