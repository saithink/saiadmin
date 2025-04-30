<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\controller;

use plugin\saiadmin\app\cache\UserAuthCache;
use plugin\saiadmin\app\cache\UserInfoCache;
use plugin\saiadmin\app\logic\system\SystemDictTypeLogic;
use plugin\saiadmin\app\logic\system\SystemLoginLogLogic;
use plugin\saiadmin\app\logic\system\SystemNoticeLogic;
use plugin\saiadmin\app\logic\system\SystemOperLogLogic;
use plugin\saiadmin\basic\BaseController;
use plugin\saiadmin\app\logic\system\SystemMenuLogic;
use plugin\saiadmin\app\logic\system\SystemUserLogic;
use plugin\saiadmin\app\logic\system\SystemAttachmentLogic;
use plugin\saiadmin\utils\ServerMonitor;
use support\Request;
use support\Response;
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
        $info['user'] = $this->adminInfo;
        if ($this->adminInfo['id'] === 1) {
            $info['codes'] = ['*'];
            $info['roles'] = ['superAdmin'];
            $info['routers'] = $logic->getAllMenus();
        } else {
            $info['codes'] = $logic->getAuthByAdminId($this->adminInfo['id']);
            $info['roles'] = Arr::getArrayColumn($this->adminInfo['roleList'],'code');
            $info['routers'] = $logic->getRoutersByAdminId($this->adminInfo['id']);
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

    /**
     * 组合数据
     * @param $array
     * @param $field
     * @return array
     */
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
     * 获取资源列表
     * @param Request $request
     * @return Response
     */
    public function getResourceList(Request $request): Response
    {
        $logic = new SystemAttachmentLogic();
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
        $query->field('id, username, nickname, phone, email, create_time');
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
        $logic = new SystemAttachmentLogic();
        $data = $logic->saveNetworkImage($url, $config);
        return $this->success($data, '操作成功');
    }

    /**
     * 上传图片
     */
    public function uploadImage(Request $request): Response
    {
        $logic = new SystemAttachmentLogic();
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
        $logic = new SystemAttachmentLogic();
        $type = $request->input('mode', 'system');
        if ($type == 'local') {
            return $this->success($logic->uploadBase('file', true));
        }
        return $this->success($logic->uploadBase('file'));
    }

    /**
     * 根据id下载资源
     * @param Request $request
     * @return Response
     */
    public function downloadById(Request $request): Response
    {
        $id = $request->input('id');
        $logic = new SystemAttachmentLogic();
        $model = $logic->find($id);
        $object_name = $model->object_name;
        return response()->download($model->storage_path, $object_name);
    }

    /**
     * 根据hash下载资源
     * @param Request $request
     * @return Response
     */
    public function downloadByHash(Request $request): Response
    {
        $hash = $request->input('hash');
        $logic = new SystemAttachmentLogic();
        $model = $logic->where('hash', $hash)->find();
        $object_name = $model->object_name;
        return response()->download($model->storage_path, $object_name);
    }

    /**
     * 获取登录日志
     * @return Response
     */
    public function getLoginLogList(): Response
    {
        $logic = new SystemLoginLogLogic();
        $logic->init($this->adminInfo);
        $query = $logic->search(['username' => $this->adminName]);
        $data = $logic->getList($query);
        return $this->success($data);
    }

    /**
     * 获取操作日志
     * @return Response
     */
    public function getOperationLogList(): Response
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
    public function getServerInfo(): Response
    {
        $service = new ServerMonitor();
        return $this->success([
            'cpu' => $service->getCpuInfo(),
            'memory' => $service->getMemInfo(),
            'phpenv' => $service->getPhpAndEnvInfo(),
        ]);
    }

    /**
     * 基本统计
     * @return Response
     */
    public function statistics(): Response
    {
        $userLogic = new SystemUserLogic();
        $userCount = $userLogic->count('id');
        $uploadLogic = new SystemAttachmentLogic();
        $attachCount = $uploadLogic->count('id');
        $loginLogic = new SystemLoginLogLogic();
        $loginCount = $loginLogic->count('id');
        $operLogic = new SystemOperLogLogic();
        $operCount = $operLogic->count('id');
        return $this->success([
            'user' => $userCount,
            'attach' => $attachCount,
            'login' => $loginCount,
            'operate' => $operCount,
        ]);
    }

    /**
     * 登录统计图表
     * @return Response
     */
    public function loginChart(): Response
    {
        $logic = new SystemLoginLogLogic();
        $data = $logic->loginChart();
        return $this->success($data);
    }

    /**
     * 系统通知
     * @param Request $request
     * @return Response
     */
    public function systemNotice(Request $request) : Response
    {
        $where = $request->more([
            ['title', ''],
            ['type', ''],
            ['create_time', ''],
        ]);
        $logic = new SystemNoticeLogic();
        $logic->init($this->adminInfo);
        $query = $logic->search($where);
        $data = $logic->getList($query);
        return $this->success($data);
    }
	
	/**
     * 清除缓存
     * @return Response
     */
    public function clearAllCache() : Response
    {
        $userInfoCache = new UserInfoCache($this->adminId);
        $userInfoCache->clearUserInfo();
        $userAuthCache = new UserAuthCache($this->adminId);
        $userAuthCache->clearUserCache();
        return $this->success([], '清除缓存成功!');
    }

}