<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\controller\system;

use plugin\saiadmin\app\cache\ConfigCache;
use plugin\saiadmin\basic\BaseController;
use plugin\saiadmin\app\logic\system\SystemConfigLogic;
use plugin\saiadmin\app\logic\system\SystemConfigGroupLogic;
use plugin\saiadmin\app\validate\system\SystemConfigValidate;
use plugin\saiadmin\service\Permission;
use support\Request;
use support\Response;

/**
 * 配置项数据控制器
 */
class SystemConfigController extends BaseController
{
    /**
     * 构造
     */
    public function __construct()
    {
        $this->logic = new SystemConfigLogic();
        $this->validate = new SystemConfigValidate;
        parent::__construct();
    }

    /**
     * 数据列表
     * @param Request $request
     * @return Response
     */
    #[Permission('系统设置列表', 'core:config:index')]
    public function index(Request $request): Response
    {
        $where = $request->more([
            ['group_id', ''],
            ['name', ''],
            ['key', ''],
        ]);
        $this->logic->setOrderField('sort');
        $this->logic->setOrderType('desc');
        $query = $this->logic->search($where);
        $data = $this->logic->getList($query);
        return $this->success($data);
    }

    /**
     * 保存数据
     * @param Request $request
     * @return Response
     */
    #[Permission('系统设置管理', 'core:config:edit')]
    public function save(Request $request): Response
    {
        $data = $request->post();
        $this->validate('save', $data);
        $result = $this->logic->add($data);
        if ($result) {
            return $this->success('添加成功');
        } else {
            return $this->fail('添加失败');
        }
    }

    /**
     * 更新数据
     * @param Request $request
     * @return Response
     */
    #[Permission('系统设置管理', 'core:config:edit')]
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
    #[Permission('系统设置管理', 'core:config:edit')]
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
     * 修改配置内容
     * @param Request $request
     * @return Response
     */
    #[Permission('系统设置修改', 'core:config:update')]
    public function batchUpdate(Request $request): Response
    {
        $group_id = $request->post('group_id');
        $config = $request->post('config');
        if (empty($group_id) || empty($config)) {
            return $this->fail('参数错误');
        }
        $this->logic->batchUpdate($group_id, $config);
        return $this->success('操作成功');
    }

}
