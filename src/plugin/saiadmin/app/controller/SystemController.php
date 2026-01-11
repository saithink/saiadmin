<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\controller;

use plugin\saiadmin\app\cache\DictCache;
use plugin\saiadmin\app\cache\UserAuthCache;
use plugin\saiadmin\app\cache\UserInfoCache;
use plugin\saiadmin\app\cache\UserMenuCache;
use plugin\saiadmin\app\logic\system\SystemCategoryLogic;
use plugin\saiadmin\app\logic\system\SystemLoginLogLogic;
use plugin\saiadmin\app\logic\system\SystemOperLogLogic;
use plugin\saiadmin\basic\BaseController;
use plugin\saiadmin\app\logic\system\SystemUserLogic;
use plugin\saiadmin\app\logic\system\SystemAttachmentLogic;
use plugin\saiadmin\service\Permission;
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
        $info['user'] = $this->adminInfo;
        $info = [];
        $info['id'] = $this->adminInfo['id'];
        $info['username'] = $this->adminInfo['username'];
        $info['dashboard'] = $this->adminInfo['dashboard'];
        $info['avatar'] = $this->adminInfo['avatar'];
        $info['email'] = $this->adminInfo['email'];
        $info['phone'] = $this->adminInfo['phone'];
        $info['gender'] = $this->adminInfo['gender'];
        $info['signed'] = $this->adminInfo['signed'];
        $info['realname'] = $this->adminInfo['realname'];
        $info['department'] = $this->adminInfo['deptList'];
        if ($this->adminInfo['id'] === 1) {
            $info['buttons'] = ['*'];
            $info['roles'] = ['super_admin'];
        } else {
            $info['buttons'] = UserAuthCache::getUserAuth($this->adminInfo['id']);
            $info['roles'] = Arr::getArrayColumn($this->adminInfo['roleList'], 'code');
        }
        return $this->success($info);
    }

    /**
     * 全部字典数据
     */
    public function dictAll(): Response
    {
        $dict = DictCache::getDictAll();
        return $this->success($dict);
    }

    /**
     * 菜单数据
     * @return Response
     */
    public function menu(): Response
    {
        $data = UserMenuCache::getUserMenu($this->adminInfo['id']);
        return $this->success($data);
    }

    /**
     * 获取资源列表
     * @param Request $request
     * @return Response
     */
    #[Permission('附件列表读取', 'core:system:resource')]
    public function getResourceCategory(Request $request): Response
    {
        $logic = new SystemCategoryLogic();
        $data = $logic->tree([]);
        return $this->success($data);
    }

    /**
     * 获取资源列表
     * @param Request $request
     * @return Response
     */
    #[Permission('附件列表读取', 'core:system:resource')]
    public function getResourceList(Request $request): Response
    {
        $logic = new SystemAttachmentLogic();
        $where = $request->more([
            ['origin_name', ''],
            ['category_id', ''],
        ]);
        $query = $logic->search($where);
        $query->whereIn('mime_type', ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
        $data = $logic->getList($query);
        return $this->success($data);
    }

    /**
     * 获取用户列表
     * @param Request $request
     * @return Response
     */
    #[Permission('用户列表读取', 'core:system:user')]
    public function getUserList(Request $request): Response
    {
        $logic = new SystemUserLogic();
        $where = $request->more([
            ['keyword', ''],
            ['dept_id', ''],
        ]);
        $data = $logic->openUserList($where);
        return $this->success($data);
    }

    /**
     * 下载网络图片
     */
    #[Permission('上传网络图片', 'core:system:uploadImage')]
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
    #[Permission('上传图片', 'core:system:uploadImage')]
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
    #[Permission('上传文件', 'core:system:uploadFile')]
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
     * 切片上传
     */
    #[Permission('上传文件', 'core:system:chunkUpload')]
    public function chunkUpload(Request $request): Response
    {
        $logic = new SystemAttachmentLogic();
        $data = $request->post();
        $result = $logic->chunkUpload($data);
        return $this->success($result);
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
        $data = $logic->getOwnOperLogList(['username' => $this->adminName]);
        return $this->success($data);
    }

    /**
     * 清除缓存
     * @return Response
     */
    public function clearAllCache(): Response
    {
        UserInfoCache::clearUserInfo($this->adminId);
        UserAuthCache::clearUserAuth($this->adminId);
        UserMenuCache::clearUserMenu($this->adminId);
        return $this->success([], '清除缓存成功!');
    }

    /**
     * 基本统计
     * @return Response
     */
    #[Permission('工作台数据统计', 'core:console:list')]
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
     * 登录统计曲线图
     * @return Response
     */
    #[Permission('工作台数据统计', 'core:console:list')]
    public function loginChart(): Response
    {
        $logic = new SystemLoginLogLogic();
        $data = $logic->loginChart();
        return $this->success($data);
    }

    /**
     * 登录统计柱状图
     * @return Response
     */
    #[Permission('工作台数据统计', 'core:console:list')]
    public function loginBarChart(): Response
    {
        $logic = new SystemLoginLogLogic();
        $data = $logic->loginBarChart();
        return $this->success($data);
    }

}
