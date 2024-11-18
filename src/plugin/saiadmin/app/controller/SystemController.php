<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\controller;

use plugin\saiadmin\app\logic\system\SystemDictTypeLogic;
use plugin\saiadmin\app\logic\system\SystemLoginLogLogic;
use plugin\saiadmin\app\logic\system\SystemOperLogLogic;
use plugin\saiadmin\app\logic\system\SystemRoleLogic;
use plugin\saiadmin\basic\BaseController;
use plugin\saiadmin\app\logic\system\SystemMenuLogic;
use plugin\saiadmin\app\logic\system\SystemUserLogic;
use plugin\saiadmin\app\logic\system\SystemDictDataLogic;
use plugin\saiadmin\app\logic\system\SystemUploadfileLogic;
use plugin\saiadmin\utils\ServerMonitor;
use plugin\saiadmin\exception\ApiException;
use support\Request;
use support\Response;
use support\Cache;
use plugin\saiadmin\utils\Arr;
use Tinywan\Storage\Storage;

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
     * 全部字典数据
     */
    public function dictAll(): Response
    {
        $logic = new SystemDictTypeLogic();
        $query = $logic->where('status', 1)
            ->field('id, name, code, remark')
            ->with(['dicts' => function ($query) {
                $query->where('status', 1)->withoutField(['created_by','updated_by','create_time','update_time'])->order('sort desc');
            }]);
        $data = $logic->getAll($query);
        $dict = $this->packageDict($data, 'code');
        return $this->success($dict);
    }

    private function packageDict($array, $field): array
    {
        $result = [];
        foreach ($array as $item) {
            if (isset($item[$field])) {
                if (isset($result[$item[$field]])) {
                    $result[$item[$field]] = [($result[$item[$field]])];
                    $result[$item[$field]][] = $item['dicts'];
                } else {
                    $result[$item[$field]] = $item['dicts'];
                }
            }
        }
        return $result;
    }

    /**
     * 数据字典
     */
    public function dictData(Request $request)
    {
        $code = $request->input('code');
        $data = Cache::get($code);
        if (!is_null($data)) {
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
        $query->auth([
            'id' => $this->adminId,
            'dept' => $this->adminInfo['deptList']
        ]);
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
        $config = Storage::getConfig('local');
        $logic = new SystemUploadfileLogic();
        $data = $logic->saveNetworkImage($url, $config);
        return $this->success($data, '操作成功');
    }

    /**
     * 上传图片
     */
    public function uploadImage(Request $request): Response
    {
        $logic = new SystemUploadfileLogic();
        $type = $request->input('mode', 'system');
        if ($type == 'local') {
            return $this->success($logic->uploadBase('image', true));
        }
        return $this->success($logic->uploadBase('image'));
    }

    /**
     * 上传文件
     */
    public function uploadFile(Request $request): Response
    {
        $logic = new SystemUploadfileLogic();
        $type = $request->input('mode', 'system');
        if ($type == 'local') {
            return $this->success($logic->uploadBase('file', true));
        }
        return $this->success($logic->uploadBase('file'));
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
        $logic->init($this->adminInfo);
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
	
	/**
     * 清除缓存
     * @return Response
     */
    public function clearAllCache() : Response
    {
        return $this->success([], '清除缓存成功!');
    }

    /**
     * 获取插件信息
     * @param Request $request
     * @return Response
     */
    public function getPlugin(Request $request): Response
    {
        $plugin = $request->input('plugin', '');
        $config = config("plugin.$plugin.app", []);
        return $this->success($config);
    }
}