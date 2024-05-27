<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\basic;

use plugin\saiadmin\exception\ApiException;
use think\facade\Db;

/**
 * 逻辑层基础类
 * @package app\service
 * @method static where($data) think-orm的where方法
 * @method static find($id) think-orm的find方法
 * @method static hidden($data) think-orm的hidden方法
 * @method static order($data) think-orm的order方法
 * @method static save($data) think-orm的save方法
 * @method static create($data) think-orm的create方法
 * @method static saveAll($data) think-orm的saveAll方法
 * @method static update($data, $where, $allow = []) think-orm的update方法
 * @method static destroy($id) think-orm的destroy方法
 * @method static select() think-orm的select方法
 * @method static count($data) think-orm的count方法
 * @method static max($data) think-orm的max方法
 * @method static min($data) think-orm的min方法
 * @method static sum($data) think-orm的sum方法
 * @method static avg($data) think-orm的avg方法
 */
class BaseLogic
{
    /**
     * @var object 模型注入
     */
    protected $model;

    /**
     * @var object 管理员信息
     */
    protected $adminInfo;

    /**
     * @var bool 数据边界启用状态
     */
    protected $scope = false;

    // 所有数据权限
    public const ALL_SCOPE = 1;
    // 自定义数据权限
    public const CUSTOM_SCOPE = 2;
    // 本部门数据权限
    public const SELF_DEPT_SCOPE = 3;
    // 本部门及子部门数据权限
    public const DEPT_BELOW_SCOPE = 4;
    // 本人数据权限
    public const SELF_SCOPE = 5;

    /**
     * @var array 用户id
     */
    public $userIds = [];

    /**
     * 初始化
     * @param $user
     * @return void
     */
    public function init($user)
    {
        $this->adminInfo = $user;
    }

    /**
     * 数据权限处理
     * @param $query
     * @return mixed
     */
    public function userDataScope($query)
    {
        if (!$this->adminInfo) {
            throw new ApiException('数据权限读取失败');
        }
        foreach ($this->adminInfo['roleList'] as $role) {
            $data_scope = $role['data_scope'];
            $role_id = $role['id'];
            switch ($data_scope) {
                case self::ALL_SCOPE:
                    return $query;
                case self::CUSTOM_SCOPE:
                    $deptIds = Db::name('system_role_dept')->where('role_id', $role_id)->column('dept_id');
                    $userIds = Db::name('system_user')->where('dept_id', 'in', $deptIds)->column('id');
                    $this->userIds = array_merge($this->userIds, $userIds);
                    break;
                case self::SELF_DEPT_SCOPE:
                    $deptId = $this->adminInfo['dept_id'];
                    $userIds = Db::name('system_user')->where('dept_id', $deptId)->column('id');
                    $this->userIds = array_merge($this->userIds, $userIds);
                    break;
                case self::DEPT_BELOW_SCOPE:
                    $deptId = $this->adminInfo['dept_id'];
                    $deptInfo = Db::name('system_dept')->where('id', $deptId)->find();
                    $level = $deptInfo['level'].",".$deptId;
                    $deptIds = Db::name('system_dept')->where(function ($query) use($level) {
                        $query->where('level', $level)
                            ->whereOr('level', 'like', $level . ',%');
                    })->column('id');
                    $deptIds[] = $deptId;
                    $userIds = Db::name('system_user')->where('dept_id', 'in', $deptIds)->column('id');
                    $this->userIds = array_merge($this->userIds, $userIds);
                    break;
                case self::SELF_SCOPE:
                    $this->userIds = array_merge($this->userIds, [$this->adminInfo['id']]);
                    break;
                default:
                    break;
            }
        }
        return $query->where('created_by', 'in', array_unique($this->userIds));
    }

    /**
     * 数据库事务操作
     * @param callable $closure
     * @param bool $isTran
     * @return mixed
     */
    public function transaction(callable $closure, bool $isTran = true)
    {
        return $isTran ? Db::transaction($closure) : $closure();
    }

    /**
     * 获取回收站模型
     * @return mixed
     */
    public function recycle(): BaseLogic
    {
        $this->model = $this->model->onlyTrashed();
        return $this;
    }

    /**
     * 恢复回收站数据
     * @param $ids
     * @return void
     */
    public function restore($ids)
    {
        $list = $this->model->onlyTrashed()->where($this->model->getPk(), 'in', $ids)->select();
        foreach ($list as $item) {
            $item->restore();
        }
    }

    /**
     * 搜索器搜索
     * @param array $searchWhere
     * @return mixed
     */
    public function search(array $searchWhere = [])
    {
        $withSearch = array_keys($searchWhere);
        $data = $searchWhere;
        foreach ($withSearch as $k => $v) {
            if ($data[$v] === '') {
                unset($data[$v]);
                unset($withSearch[$k]);
            }
        }
        return $this->model->withSearch($withSearch, $data);
    }

    /**
     * 分页查询数据
     * @return mixed
     */
    public function getList($query)
    {
        $saiType = request()->input('saiType', 'list');
        $page = request()->input('page', 1);
        $limit = request()->input('limit', 10);
        $orderBy = request()->input('orderBy', $this->model->getPk());
        $orderType = request()->input('orderType', 'ASC');
        if ($this->scope) {
            $query = $this->userDataScope($query);
        }
        $query->order($orderBy, $orderType);
        if ($saiType === 'all') {
            return $query->select()->toArray();
        }
        return $query->paginate($limit, false, ['page' => $page])->toArray();
    }

    /**
     * 获取全部数据
     * @param $query
     * @return mixed
     */
    public function getAll($query)
    {
        $orderBy = request()->input('orderBy', $this->model->getPk());
        $orderType = request()->input('orderType', 'ASC');
        if ($this->scope) {
            $query = $this->userDataScope($query);
        }
        $query->order($orderBy, $orderType);
        return $query->select()->toArray();
    }

    /**
     * 获取上传的导入文件
     * @param $file
     * @return string
     */
    public function getImport($file): string
    {
        $full_dir = runtime_path() . '/resource/';
        if (!is_dir($full_dir)) {
            mkdir($full_dir, 0777, true);
        }
        $ext = $file->getUploadExtension() ?: null;
        $full_path = $full_dir. md5(time()). '.'. $ext;
        $file->move($full_path);
        return $full_path;
    }

    /**
     * 方法调用
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
        return call_user_func_array([$this->model, $name], $arguments);
    }
}
