<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\controller\system;

use plugin\saiadmin\app\cache\ConfigCache;
use plugin\saiadmin\basic\BaseController;
use plugin\saiadmin\app\logic\system\SystemConfigGroupLogic;
use plugin\saiadmin\app\validate\system\SystemConfigGroupValidate;
use plugin\saiadmin\service\Permission;
use plugin\saiadmin\utils\Arr;
use support\Request;
use support\Response;
use plugin\saiadmin\service\EmailService;
use plugin\saiadmin\app\model\system\SystemMail;

/**
 * 配置控制器
 */
class SystemConfigGroupController extends BaseController
{
    /**
     * 构造
     */
    public function __construct()
    {
        $this->logic = new SystemConfigGroupLogic();
        $this->validate = new SystemConfigGroupValidate;
        parent::__construct();
    }

    /**
     * 数据列表
     * @param Request $request
     * @return Response
     */
    #[Permission('系统设置列表', 'core:config:index')]
    public function index(Request $request) : Response
    {
        $where = $request->more([
            ['name', ''],
            ['code', ''],
        ]);
        $query = $this->logic->search($where);
        $data = $this->logic->getAll($query);
        return $this->success($data);
    }

    /**
     * 保存数据
     * @param Request $request
     * @return Response
     */
    #[Permission('系统设置管理', 'core:config:edit')]
    public function save(Request $request): Response
    {
        $data = $request->post();
        $this->validate('save', $data);
        $result = $this->logic->add($data);
        if ($result) {
            return $this->success('添加成功');
        } else {
            return $this->fail('添加失败');
        }
    }

    /**
     * 更新数据
     * @param Request $request
     * @return Response
     */
    #[Permission('系统设置管理', 'core:config:edit')]
    public function update(Request $request): Response
    {
        $data = $request->post();
        $this->validate('update', $data);
        $result = $this->logic->edit($data['id'], $data);
        if ($result) {
            ConfigCache::clearConfig($data['code']);
            return $this->success('修改成功');
        } else {
            return $this->fail('修改失败');
        }
    }

    /**
     * 删除数据
     * @param Request $request
     * @return Response
     */
    #[Permission('系统设置管理', 'core:config:edit')]
    public function destroy(Request $request) : Response
    {
        $ids = $request->post('ids', '');
        if (empty($ids)) {
            return $this->fail('请选择要删除的数据');
        }
        $result = $this->logic->destroy($ids);
        if ($result) {
            return $this->success('删除成功');
        } else {
            return $this->fail('删除失败');
        }
    }

    /**
     * 邮件测试
     * @param Request $request
     * @return Response
     */
    #[Permission('系统设置修改', 'core:config:update')]
    public function email(Request $request) : Response
    {
        $email = $request->input('email', '');
        if (empty($email)) {
            return $this->fail('请输入邮箱');
        }
        $subject = "测试邮件";
        $code = "9527";
        $content = "<h1>验证码：{code}</h1><p>这是一封测试邮件,请忽略</p>";
        $template = [
            'code' => $code
        ];
        $config = EmailService::getConfig();
        $model = SystemMail::create([
            'gateway' => Arr::getConfigValue($config,'Host'),
            'from' => Arr::getConfigValue($config,'From'),
            'email' => $email,
            'code' => $code,
        ]);
        try {
            $result = EmailService::sendByTemplate($email, $subject, $content, $template);
            if (!empty($result)) {
                $model->status = 'failure';
                $model->response = $result;
                $model->save();
                return $this->fail('发送失败，请查看日志');
            } else {
                $model->status = 'success';
                $model->save();
                return $this->success([], '发送成功');
            }
        } catch (\Exception $e) {
            $model->status = 'failure';
            $model->response = $e->getMessage();
            $model->save();
            return $this->fail($e->getMessage());
        }
    }

}
