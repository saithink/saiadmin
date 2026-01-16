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
use plugin\saiadmin\app\cache\UserMenuCache;
use plugin\saiadmin\service\Permission;
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
    #[Permission('代码生成列表', 'tool:code:index')]
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
     * 读取数据
     * @param Request $request
     * @return Response
     */
    #[Permission('代码生成列表', 'tool:code:index')]
    public function read(Request $request): Response
    {
        $id = $request->input('id', '');
        $model = $this->logic->read($id);
        if ($model) {
            $data = is_array($model) ? $model : $model->toArray();
            return $this->success($data);
        } else {
            return $this->fail('未查找到信息');
        }
    }

    /**
     * 修改数据
     * @param Request $request
     * @return Response
     */
    #[Permission('代码生成修改', 'tool:code:edit')]
    public function update(Request $request): Response
    {
        $data = $request->post();
        $this->validate('update', $data);
        $result = $this->logic->edit($data['id'], $data);
        if ($result) {
            return $this->success('修改成功');
        } else {
            return $this->fail('修改失败');
        }
    }

    /**
     * 删除数据
     * @param Request $request
     * @return Response
     */
    #[Permission('代码生成删除', 'tool:code:edit')]
    public function destroy(Request $request): Response
    {
        $ids = $request->post('ids', '');
        if (empty($ids)) {
            return $this->fail('请选择要删除的数据');
        }
        $result = $this->logic->destroy($ids);
        if ($result) {
            return $this->success('删除成功');
        } else {
            return $this->fail('删除失败');
        }
    }

    /**
     * 装载数据表
     * @param Request $request
     * @return Response
     */
    #[Permission('代码生成装载', 'tool:code:edit')]
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
    #[Permission('代码生成同步表结构', 'tool:code:edit')]
    public function sync(Request $request): Response
    {
        $id = $request->input('id', '');
        $this->logic->sync($id);
        return $this->success('操作成功');
    }

    /**
     * 代码预览
     */
    #[Permission('代码生成预览', 'tool:code:edit')]
    public function preview(Request $request): Response
    {
        $id = $request->input('id', '');
        $data = $this->logic->preview($id);
        return $this->success($data);
    }

    /**
     * 代码生成
     */
    #[Permission('代码生成文件', 'tool:code:edit')]
    public function generate(Request $request): Response
    {
        $ids = $request->input('ids', '');
        $data = $this->logic->generate($ids);
        return response()->download($data['download'], $data['filename']);
    }

    /**
     * 生成到模块
     */
    #[Permission('代码生成到模块', 'tool:code:edit')]
    public function generateFile(Request $request): Response
    {
        $id = $request->input('id', '');
        $this->logic->generateFile($id);
        UserMenuCache::clearMenuCache();
        return $this->success('操作成功');
    }

    /**
     * 获取数据表字段信息
     * @param Request $request
     * @return Response
     */
    #[Permission('代码生成读取表字段', 'tool:code:index')]
    public function getTableColumns(Request $request): Response
    {
        $table_id = $request->input('table_id', '');
        $data = $this->logic->getTableColumns($table_id);
        return $this->success($data);
    }

}