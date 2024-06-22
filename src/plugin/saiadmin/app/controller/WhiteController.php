<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\controller;

use plugin\saiadmin\basic\OpenController;
use plugin\saiadmin\app\logic\system\SystemUploadfileLogic;
use support\Response;

/**
 * 白名单控制器
 */
class WhiteController extends OpenController
{
    /**
     * 根据id下载资源
     * @param $id
     * @return Response
     */
    public function downloadById($id): Response
    {
        $logic = new SystemUploadfileLogic();
        $model = $logic->find($id);
        $object_name = $model->object_name;
        return response()->download($model->storage_path, $object_name);
    }

    /**
     * 根据hash下载资源
     * @param $hash
     * @return Response
     */
    public function downloadByHash($hash): Response
    {
        $logic = new SystemUploadfileLogic();
        $model = $logic->where('hash', $hash)->find();
        $object_name = $model->object_name;
        return response()->download($model->storage_path, $object_name);
    }
}