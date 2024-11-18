<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\controller\system;

use plugin\saiadmin\basic\BaseController;
use plugin\saiadmin\app\logic\system\SystemConfigLogic;
use plugin\saiadmin\app\logic\system\SystemConfigGroupLogic;
use plugin\saiadmin\app\validate\system\SystemConfigValidate;
use support\Cache;
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
    public function index(Request $request) : Response
    {
        $where = $request->more([
            ['group_id', ''],
            ['name', ''],
            ['key', ''],
        ]);
        $query = $this->logic->search($where);
        $data = $this->logic->getAll($query);
        return $this->success($data);
    }

    /**
     * 修改配置内容
     * @param Request $request
     * @return Response
     */
    public function batchUpdate(Request $request): Response
    {
        $group_id = $request->post('group_id');
        $config = $request->post('config');
        $groupLogic = new SystemConfigGroupLogic();
        $group = $groupLogic->where('id', $group_id)->findOrEmpty();
        if ($group->isEmpty()) {
            $this->fail('配置分组查找失败');
        }
        $saveData = [];
        foreach ($config as $key => $value) {
            $saveData[] = [
                'id' => $value['id'],
                'sort' => $value['sort'],
                'name' => $value['name'],
                'key' => $value['key'],
                'value' => $value['value']
            ];
        }
        $this->logic->saveAll($saveData);
        Cache::set('cfg_'.$group->code, $saveData);
        return $this->success('操作成功');
    }
}
