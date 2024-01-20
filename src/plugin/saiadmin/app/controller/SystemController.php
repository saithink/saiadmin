<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\controller;

use plugin\saiadmin\app\logic\system\SystemLoginLogLogic;
use plugin\saiadmin\app\logic\system\SystemOperLogLogic;
use plugin\saiadmin\app\logic\system\SystemRoleLogic;
use plugin\saiadmin\basic\BaseController;
use plugin\saiadmin\app\logic\system\SystemMenuLogic;
use plugin\saiadmin\app\logic\system\SystemUserLogic;
use plugin\saiadmin\app\logic\system\SystemNoticeLogic;
use plugin\saiadmin\app\logic\system\SystemDictDataLogic;
use plugin\saiadmin\app\logic\system\SystemUploadfileLogic;
use plugin\saiadmin\utils\ServerMonitor;
use support\Request;
use support\Response;
use plugin\saiadmin\utils\Cache;
use plugin\saiadmin\utils\Arr;

/**
 * 系统控制器
 */
class SystemController extends BaseController
{

    /**
     * 用户信息
     */
    public function userInfo(): Response
    {
        $logic = new SystemMenuLogic();
        $roleLogic = new SystemRoleLogic();
        $info['user'] = $this->adminInfo;
        if ($this->adminInfo['id'] === 1) {
            $info['codes'] = ['*'];
            $info['roles'] = ['superAdmin'];
            $info['routers'] = $logic->getAllMenus();
        } else {
            $role_ids = Arr::getArrayColumn($this->adminInfo['roleList'], 'id');
            $roles = $roleLogic->getMenuIdsByRoleIds($role_ids);
            $ids = $logic->filterMenuIds($roles);
            $info['codes'] = $logic->getMenuCode($ids);
            $info['roles'] = Arr::getArrayColumn($this->adminInfo['roleList'],'code');
            $info['routers'] = $logic->getRoutersByIds($ids);
        }
        return $this->success($info);
    }

    /**
     * 数据字典
     */
    public function dictData(Request $request)
    {
        $code = $request->input('code');
        $data = Cache::get($code);
        if ($data) {
            return $this->success($data);
        }
        $logic = new SystemDictDataLogic();
        $query = $logic->where('status', 1)->where('code', $code)->field('id, label, value')->order('sort desc');
        $data = $logic->getAll($query);
        Cache::set($code, $data);
        return $this->success($data);
    }

    /**
     * 获取资源列表
     * @param Request $request
     * @return Response
     */
    public function getResourceList(Request $request): Response
    {
        $logic = new SystemUploadfileLogic();
        $where = $request->more([
            ['origin_name', ''],
            ['storage_mode', ''],
            ['mime_type', ''],
        ]);
        $query = $logic->search($where);
        $data = $logic->getList($query);
        return $this->success($data);
    }

    /**
     * 获取用户列表
     * @param Request $request
     * @return Response
     */
    public function getUserList(Request $request): Response
    {
        $logic = new SystemUserLogic();
        $where = $request->more([
            ['username', ''],
            ['nickname', ''],
            ['phone', ''],
            ['email', ''],
            ['dept_id', ''],
            ['role_id', ''],
            ['post_id', ''],
        ]);
        $query = $logic->search($where);
        $data = $logic->getList($query);
        return $this->success($data);
    }

    /**
     * 根据id获取用户信息
     * @param Request $request
     * @return Response
     */
    public function getUserInfoByIds(Request $request): Response
    {
        $ids = $request->input('ids');
        $logic = new SystemUserLogic();
        $data = $logic->where('id', 'in', $ids)
            ->field('id, username, nickname, phone, email, create_time')
            ->select()
            ->toArray();
        return $this->success($data);
    }

    /**
     * 下载网络图片
     */
    public function saveNetworkImage(Request $request): Response
    {
        $url = $request->input('url', '');
        $logic = new SystemUploadfileLogic();
        $data = $logic->saveNetworkImage($url, '/upload/image/'.date('Ymd'), $this->adminId);
        return $this->success($data, '操作成功');
    }

    /**
     * 上传图片
     */
    public function uploadImage(Request $request): Response
    {
        $result = $this->uploadBase($request, 'image');
        return $this->success($result);
    }

    /**
     * 上传文件
     */
    public function uploadFile(Request $request): Response
    {
        $result = $this->uploadBase($request, 'file');
        return $this->success($result);
    }

    public function uploadBase($request, $type)
    {
        $file = current($request->file());
        if (!$file || !$file->isValid()) {
            return $this->fail('未找到上传文件');
        }
        $hash = md5_file($file->getPath() . '/' . $file->getFilename());
        $logic = new SystemUploadfileLogic();
        $model = $logic->where('hash', $hash)->find();
        if ($model) {
            return $model->toArray();
        } else {
            $data = $logic->uploadInfo($request, $type);
            $info['storage_mode'] = 1;
            $info['origin_name'] = $data['name'];
            $info['object_name'] = $data['object_name'];
            $info['hash'] = $hash;
            $info['mime_type'] = $data['mime_type'];
            $info['storage_path'] = $data['storage_path'];
            $info['suffix'] = $data['ext'];
            $info['size_byte'] = $data['size'];
            $info['size_info'] = formatBytes($data['size']);
            $info['url'] = $data['url'];
            $info['created_by'] = $this->adminId;
            $info['updated_by'] = $this->adminId;
            $logic->save($info);
            return $info;
        }
    }

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
        $base_dir = public_path();
        return response()->download($base_dir . $model->storage_path . '/' .$object_name, $object_name);
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
        $base_dir = public_path();
        return response()->download($base_dir . $model->storage_path . '/' .$object_name, $object_name);
    }

    /**
     * 根据id获取文件信息
     * @param $id
     * @return Response
     */
    public function getFileInfoById($id): Response
    {
        $logic = new SystemUploadfileLogic();
        $model = $logic->find($id);
        if ($model) {
            return $this->success($model->toArray());
        }
        return $this->success([]);
    }

    /**
     * 根据hash获取文件信息
     * @param $hash
     * @return Response
     */
    public function getFileInfoByHash($hash): Response
    {
        $logic = new SystemUploadfileLogic();
        $model = $logic->where('hash', $hash)->find();
        if ($model) {
            return $this->success($model->toArray());
        }
        return $this->success([]);
    }

    /**
     * 获取登录日志
     * @return Response
     */
    public function getLoginLogList() : Response
    {
        $logic = new SystemLoginLogLogic();
        $query = $logic->search(['username' => $this->adminName]);
        $data = $logic->getList($query);
        return $this->success($data);
    }

    /**
     * 获取操作日志
     * @return Response
     */
    public function getOperationLogList() : Response
    {
        $logic = new SystemOperLogLogic();
        $query = $logic->search(['username' => $this->adminName])->hidden(['request_data', 'delete_time']);
        $data = $logic->getList($query);
        return $this->success($data);
    }

    /**
     * 获取服务器信息
     * @return Response
     */
    public function getServerInfo() : Response
    {
        $service = new ServerMonitor();
        return $this->success([
            'cpu' => $service->getCpuInfo(),
            'memory' => $service->getMemInfo(),
            'phpenv' => $service->getPhpAndEnvInfo(),
        ]);
    }
}