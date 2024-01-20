<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\controller\system;

use plugin\saiadmin\basic\BaseController;
use plugin\saiadmin\app\logic\system\SystemMenuLogic;
use support\Request;
use support\Response;

/**
 * 菜单控制器
 */
class SystemMenuController extends BaseController
{
    /**
     * 构造
     */
    public function __construct()
    {
        $this->logic = new SystemMenuLogic();
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
            ['name', ''],
            ['code', ''],
            ['is_hidden', ''],
            ['status', ''],
        ]);
        $data = $this->logic->tree($where);
        return $this->success($data);
    }

}