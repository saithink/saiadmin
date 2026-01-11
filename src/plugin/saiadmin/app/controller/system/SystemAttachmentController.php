<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\controller\system;

use plugin\saiadmin\basic\BaseController;
use plugin\saiadmin\app\logic\system\SystemAttachmentLogic;
use plugin\saiadmin\service\Permission;
use support\Request;
use support\Response;

/**
 * 附件管理控制器
 */
class SystemAttachmentController extends BaseController
{
    /**
     * 构造
     */
    public function __construct()
    {
        $this->logic = new SystemAttachmentLogic();
        parent::__construct();
    }

    /**
     * 数据列表
     * @param Request $request
     * @return Response
     */
    #[Permission('附件数据列表', 'core:attachment:index')]
    public function index(Request $request) : Response
    {
        $where = $request->more([
            ['origin_name', ''],
            ['category_id', ''],
            ['storage_mode', ''],
            ['mime_type', ''],
            ['create_time', ''],
        ]);
        $query = $this->logic->search($where);
        $data = $this->logic->getList($query);
        return $this->success($data);
    }

    /**
     * 更新数据
     * @param Request $request
     * @return Response
     */
    #[Permission('附件数据修改', 'core:attachment:edit')]
    public function update(Request $request): Response
    {
        $data = $request->post();
        $result = $this->logic->edit($data['id'], ['origin_name' => $data['origin_name']]);
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
    #[Permission('附件数据删除', 'core:attachment:edit')]
    public function destroy(Request $request) : Response
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
     * 移动分类
     * @param Request $request
     * @return Response
     */
    #[Permission('附件移动分类', 'core:attachment:edit')]
    public function move(Request $request) : Response
    {
        $category_id = $request->post('category_id', '');
        $ids = $request->post('ids', '');
        if (empty($ids) || empty($category_id)) {
            return $this->fail('参数错误，请检查参数');
        }
        $result = $this->logic->move($category_id, $ids);
        if ($result) {
            return $this->success('删除成功');
        } else {
            return $this->fail('删除失败');
        }
    }

}
