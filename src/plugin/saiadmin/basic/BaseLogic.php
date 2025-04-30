<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
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
 * @method static findOrEmpty($id) think-orm的findOrEmpty方法
 * @method static hidden($data) think-orm的hidden方法
 * @method static order($data) think-orm的order方法
 * @method static save($data) think-orm的save方法
 * @method static create($data) think-orm的create方法
 * @method static saveAll($data) think-orm的saveAll方法
 * @method static update($data, $where, $allow = []) think-orm的update方法
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
     * 排序字段
     * @var string
     */
    protected string $orderField = '';

    /**
     * 排序方式
     * @var string
     */
    protected string $orderType = 'ASC';

    /**
     * 初始化
     * @param $user
     * @return void
     */
    public function init($user): void
    {
        $this->adminInfo = $user;
    }

    /**
     * 设置排序字段
     * @param $field
     * @return void
     */
    public function setOrderField($field): void
    {
        $this->orderField = $field;
    }

    /**
     * 设置排序方式
     * @param $type
     * @return void
     */
    public function setOrderType($type): void
    {
        $this->orderType = $type;
    }

    /**
     * 数据库事务操作
     * @param callable $closure
     * @param bool $isTran
     * @return mixed
     */
    public function transaction(callable $closure, bool $isTran = true): mixed
    {
        return $isTran ? Db::transaction($closure) : $closure();
    }

    /**
     * 添加数据
     * @param $data
     * @return mixed
     */
    public function add($data): mixed
    {
        $this->model->save($data);
        return $this->model->getKey();
    }

    /**
     * 修改数据
     * @param $id
     * @param $data
     * @return mixed
     */
    public function edit($id, $data): mixed
    {
        $model = $this->model->findOrEmpty($id);
        if ($model->isEmpty()) {
            throw new ApiException('数据不存在');
        }
        return $model->save($data);
    }

    /**
     * 读取数据
     * @param $id
     * @return mixed
     */
    public function read($id): mixed
    {
        $model = $this->model->findOrEmpty($id);
        if ($model->isEmpty()) {
            throw new ApiException('数据不存在');
        }
        return $model;
    }

    /**
     * 删除数据
     * @param $ids
     */
    public function destroy($ids)
    {
        $this->model->destroy($ids);
    }

    /**
     * 搜索器搜索
     * @param array $searchWhere
     * @return mixed
     */
    public function search(array $searchWhere = []): mixed
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
     * @param $query
     * @return mixed
     */
    public function getList($query): mixed
    {
        $saiType = request()->input('saiType', 'list');
        $page = request()->input('page', 1);
        $limit = request()->input('limit', 10);
        $orderBy = request()->input('orderBy', '');
        $orderType = request()->input('orderType', $this->orderType);
        if(empty($orderBy)) {
            $orderBy = $this->orderField !== '' ? $this->orderField : $this->model->getPk();
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
    public function getAll($query): mixed
    {
        $orderBy = request()->input('orderBy', '');
        $orderType = request()->input('orderType', $this->orderType);
        if(empty($orderBy)) {
            $orderBy = $this->orderField !== '' ? $this->orderField : $this->model->getPk();
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
