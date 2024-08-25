<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\controller\system;

use plugin\saiadmin\basic\BaseController;
use plugin\saiadmin\app\logic\system\SystemMenuLogic;
use plugin\saiadmin\app\validate\system\SystemMenuValidate;
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
        $this->validate = new SystemMenuValidate;
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
        if ($this->adminId > 1) {
            if (request()->input('auth', 'false') === 'true') {
                $data = $this->logic->auth();
                return $this->success($data);
            }
        }
        $data = $this->logic->tree($where);
        return $this->success($data);
    }

}