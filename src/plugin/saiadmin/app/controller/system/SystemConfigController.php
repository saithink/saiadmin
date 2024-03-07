<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\controller\system;

use plugin\saiadmin\basic\BaseController;
use plugin\saiadmin\app\logic\system\SystemConfigLogic;
use plugin\saiadmin\app\validate\system\SystemConfigValidate;
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
     * 根据key值修改配置项
     * @param Request $request
     * @return Response
     */
    public function updateByKeys(Request $request) : Response
    {
        $data = $request->post();
        foreach ($data as $key => $value) {
            $this->logic->where('key', $key)
                ->update(['value' => is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value]);
        }
        return $this->success('操作成功');
    }


}
