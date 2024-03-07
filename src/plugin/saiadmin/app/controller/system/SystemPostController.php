<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\controller\system;

use plugin\saiadmin\basic\BaseController;
use plugin\saiadmin\app\logic\system\SystemPostLogic;
use plugin\saiadmin\app\validate\system\SystemPostValidate;
use support\Request;
use support\Response;

/**
 * 系统公告控制器
 */
class SystemPostController extends BaseController
{
    /**
     * 构造
     */
    public function __construct()
    {
        $this->logic = new SystemPostLogic();
        $this->validate = new SystemPostValidate;
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
            ['status', ''],
            ['create_time', ''],
        ]);
        $query = $this->logic->search($where);
        $data = $this->logic->getList($query);
        return $this->success($data);
    }

    /**
     * 下载导入模板
     * @return Response
     */
    public function downloadTemplate() : Response
    {
        $file_name = "导入模板.xls";
        return downloadFile($file_name);
    }

    /**
     * 导入数据
     * @param Request $request
     * @return Response
     */
    public function import(Request $request) : Response
    {
        $file = current($request->file());
        if (!$file || !$file->isValid()) {
            return $this->fail('未找到上传文件');
        }
        $this->logic->import($file);
        return $this->success('导入成功');
    }

    /**
     * 导出数据
     * @param Request $request
     * @return Response
     */
    public function export(Request $request) : Response
    {
        $where = $request->more([
            ['name', ''],
            ['code', ''],
            ['status', ''],
        ]);
        return $this->logic->export($where);
    }
}
