<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\controller\system;

use plugin\saiadmin\app\cache\UserInfoCache;
use plugin\saiadmin\app\model\system\SystemUserPost;
use plugin\saiadmin\basic\BaseController;
use plugin\saiadmin\app\logic\system\SystemPostLogic;
use plugin\saiadmin\app\validate\system\SystemPostValidate;
use support\Request;
use support\Response;

/**
 * 岗位信息控制器
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
     * 修改状态
     * @param Request $request
     * @return Response
     */
    public function changeStatus(Request $request) : Response
    {
        $id = $request->input('id', '');
        $status = $request->input('status', 1);
        $model = $this->logic->findOrEmpty($id);
        if ($model->isEmpty()) {
            return $this->fail('未查找到信息');
        }
        $result = $model->save(['status' => $status]);
        if ($result) {
            $this->afterChange('changeStatus', $model);
            return $this->success('操作成功');
        } else {
            return $this->fail('操作失败');
        }
    }

    /**
     * 数据改变后执行
     * @param $type
     * @param $args
     * @return void
     */
    protected function afterChange($type, $args): void
    {
        // 批量清理用户缓存
        if ($type == 'update') {
            $post_id = request()->input('id', '');
            $userIds = SystemUserPost::where('post_id', $post_id)->column('user_id');
            $userIds = array_unique($userIds);
            foreach ($userIds as $userId) {
                $userInfoCache = new UserInfoCache($userId);
                $userInfoCache->clearUserInfo();
            }
        }
        if ($type == 'destroy') {
            $post_ids = request()->input('ids', '');
            if (is_array($post_ids)) {
                $userIds = SystemUserPost::whereIn('post_id', $post_ids)->column('user_id');
                $userIds = array_unique($userIds);
                foreach ($userIds as $userId) {
                    $userInfoCache = new UserInfoCache($userId);
                    $userInfoCache->clearUserInfo();
                }
            }
        }
    }

    /**
     * 可操作岗位
     * @param Request $request
     * @return Response
     */
    public function accessPost(Request $request) : Response
    {
        $where = [];
        $data = $this->logic->accessPost($where);
        return $this->success($data);
    }

    /**
     * 下载导入模板
     * @return Response
     */
    public function downloadTemplate() : Response
    {
        $file_name = "template.xlsx";
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
