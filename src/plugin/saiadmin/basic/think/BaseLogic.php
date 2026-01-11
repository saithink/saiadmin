<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\basic\think;

use support\think\Db;
use plugin\saiadmin\basic\AbstractLogic;
use plugin\saiadmin\exception\ApiException;

/**
 * ThinkORM 逻辑层基类
 */
class BaseLogic extends AbstractLogic
{
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
     * @param array $data
     * @return mixed
     */
    public function add(array $data): mixed
    {
        $model = $this->model->create($data);
        return $model->getKey();
    }

    /**
     * 修改数据
     * @param mixed $id
     * @param array $data
     * @return mixed
     */
    public function edit($id, array $data): mixed
    {
        $model = $this->model->findOrEmpty($id);
        if ($model->isEmpty()) {
            throw new ApiException('数据不存在');
        }
        return $model->save($data);
    }

    /**
     * 读取数据
     * @param mixed $id
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
     * @param mixed $ids
     * @return bool
     */
    public function destroy($ids): bool
    {
        return $this->model->destroy($ids);
    }

    /**
     * 搜索器搜索
     * @param array $searchWhere
     * @return mixed
     */
    public function search(array $searchWhere = []): mixed
    {
        $withSearch = array_keys($searchWhere);
        $data = [];
        foreach ($searchWhere as $key => $value) {
            if ($value !== '' && $value !== null && $value !== []) {
                $data[$key] = $value;
            }
        }
        $withSearch = array_keys($data);
        return $this->model->withSearch($withSearch, $data);
    }

    /**
     * 分页查询数据
     * @param mixed $query
     * @return mixed
     */
    public function getList($query): mixed
    {
        $request = request();
        $saiType = $request ? $request->input('saiType', 'list') : 'list';
        $page = $request ? $request->input('page', 1) : 1;
        $limit = $request ? $request->input('limit', 10) : 10;
        $orderField = $request ? $request->input('orderField', '') : '';
        $orderType = $request ? $request->input('orderType', $this->orderType) : $this->orderType;

        if (empty($orderField)) {
            $orderField = $this->orderField !== '' ? $this->orderField : $this->model->getPk();
        }

        $query->order($orderField, $orderType);

        if ($saiType === 'all') {
            return $query->select()->toArray();
        }

        return $query->paginate($limit, false, ['page' => $page])->toArray();
    }

    /**
     * 获取全部数据
     * @param mixed $query
     * @return mixed
     */
    public function getAll($query): mixed
    {
        $request = request();
        $orderField = $request ? $request->input('orderField', '') : '';
        $orderType = $request ? $request->input('orderType', $this->orderType) : $this->orderType;

        if (empty($orderField)) {
            $orderField = $this->orderField !== '' ? $this->orderField : $this->model->getPk();
        }

        $query->order($orderField, $orderType);
        return $query->select()->toArray();
    }
}
