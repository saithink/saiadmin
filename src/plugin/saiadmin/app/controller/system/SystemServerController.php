<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\controller\system;

use plugin\saiadmin\service\Permission;
use plugin\saiadmin\basic\BaseController;
use plugin\saiadmin\utils\ServerMonitor;
use support\think\Cache;
use support\Request;
use support\Response;

/**
 * 邮件记录控制器
 */
class SystemServerController extends BaseController
{
    /**
     * 构造
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 数据列表
     * @param Request $request
     * @return Response
     */
    #[Permission('服务监控', 'core:server:monitor')]
    public function monitor(Request $request): Response
    {
        $service = new ServerMonitor();
        return $this->success([
            'memory' => $service->getMemoryInfo(),
            'disk' => $service->getDiskInfo(),
            'phpEnv' => $service->getPhpAndEnvInfo(),
        ]);
    }

    /**
     * 数据列表
     * @param Request $request
     * @return Response
     */
    #[Permission('缓存信息', 'core:server:cache')]
    public function cache(Request $request): Response
    {
        $menu_cache = config('plugin.saiadmin.saithink.menu_cache', []);
        $button_cache = config('plugin.saiadmin.saithink.button_cache', []);
        $config_cache = config('plugin.saiadmin.saithink.config_cache', []);
        $dict_cache = config('plugin.saiadmin.saithink.dict_cache', []);
        $reflection_cache = config('plugin.saiadmin.saithink.reflection_cache', []);

        return $this->success([
            'menu_cache' => $menu_cache,
            'button_cache' => $button_cache,
            'config_cache' => $config_cache,
            'dict_cache' => $dict_cache,
            'reflection_cache' => $reflection_cache
        ]);
    }

    /**
     * 删除数据
     * @param Request $request
     * @return Response
     */
    #[Permission('缓存数据清理', 'core:server:clear')]
    public function clear(Request $request) : Response
    {
        $tag = $request->input('tag', '');
        if (empty($tag)) {
            return $this->fail('请选择要删除的缓存');
        }
        Cache::tag($tag)->clear();
        Cache::delete($tag);
        return $this->success('删除成功');
    }

}