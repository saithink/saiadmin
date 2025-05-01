<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\basic;

use support\Request;
use support\Response;
use plugin\saiadmin\app\cache\UserInfoCache;
use plugin\saiadmin\exception\ApiException;

/**
 * 基类 控制器继承此类
 */
class BaseController extends OpenController
{

    /**
     * 当前登陆管理员信息
     */
    protected $adminInfo;

    /**
     * 当前登陆管理员ID
     */
    protected $adminId;

    /**
     * 当前登陆管理员账号
     */
    protected $adminName;

    /**
     * 逻辑层注入
     */
    protected $logic;

    /**
     * 验证器注入
     */
    protected $validate;

    /**
     * 初始化
     */
    protected function init(): void
    {
        // 检查默认请求类型
        $this->checkDefaultMethod();
        // 登录模式赋值
        $isLogin = request()->header('check_login', false);
        if ($isLogin) {
            $result = request()->header('check_admin');
            $userInfoCache = new UserInfoCache($result['id']);
            $this->adminId = $result['id'];
            $this->adminName = $result['username'];
            $this->adminInfo = $userInfoCache->getUserInfo();

            // 用户数据传递给逻辑层
            $this->logic && $this->logic->init($this->adminInfo);
        }
    }

    /**
     * 检查默认方法
     * @return void
     */
    protected function checkDefaultMethod()
    {
        $functions = [
            'index' => 'get',
            'save' => 'post',
            'update' => 'put',
            'read' => 'get',
            'changestatus' => 'post',
            'destroy' => 'delete',
            'import' => 'post',
            'export' => 'post',
        ];
        
        $action = strtolower(request()->action);
        if (array_key_exists($action, $functions)) {
            $this->checkMethod($functions[$action]);
        }
    }

    /**
     * 验证请求方式
     * @param string $method
     * @return void
     */
    protected  function checkMethod(string $method)
    {
        $m = strtolower(request()->method());
        if ($m !== strtolower($method)) {
            throw new ApiException('Not Found!', 404);
        }
    }

    /**
     * 添加数据
     * @param Request $request
     * @return Response
     */
    public function save(Request $request) : Response
    {
        $data = $request->post();
        if ($this->validate) {
            if (!$this->validate->scene('save')->check($data)) {
                return $this->fail($this->validate->getError());
            }
        }
        $key = $this->logic->add($data);
        if ($key > 0) {
            $this->afterChange('save', $key);
            return $this->success('操作成功');
        } else {
            return $this->fail('操作失败');
        }
    }

    /**
     * 修改数据
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function update(Request $request, $id) : Response
    {
        $id = $request->input('id', $id);
        if (empty($id)) {
            return $this->fail('参数错误，请检查');
        }
        $data = $request->post();
        if ($this->validate) {
            if (!$this->validate->scene('update')->check($data)) {
                return $this->fail($this->validate->getError());
            }
        }
        $result = $this->logic->edit($id, $data);
        if ($result) {
            $this->afterChange('update', $result);
            return $this->success('操作成功');
        } else {
            return $this->fail('操作失败');
        }
    }

    /**
     * 删除数据
     * @param Request $request
     * @return Response
     */
    public function destroy(Request $request) : Response
    {
        $ids = $request->input('ids', '');
        if (!empty($ids)) {
            $this->logic->destroy($ids);
            $this->afterChange('destroy', $ids);
            return $this->success('操作成功');
        } else {
            return $this->fail('参数错误，请检查');
        }
    }

    /**
     * 读取数据
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function read(Request $request, $id) : Response
    {
        $id = $request->input('id', $id);
        $model = $this->logic->read($id);
        if ($model) {
            $data = is_array($model) ? $model : $model->toArray();
            return $this->success($data);
        } else {
            return $this->fail('未查找到信息');
        }
    }

    /**
     * 数据改变后执行
     * @param string $type 类型
     * @param $args
     */
    protected function afterChange(string $type, $args): void
    {
        // todo
    }
}
