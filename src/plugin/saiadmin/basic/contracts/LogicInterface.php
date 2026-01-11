<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\basic\contracts;

/**
 * Logic 接口定义
 * 所有 Logic 基类必须实现此接口
 */
interface LogicInterface
{
    /**
     * 初始化
     * @param mixed $user 用户信息
     * @return void
     */
    public function init($user): void;

    /**
     * 添加数据
     * @param array $data
     * @return mixed
     */
    public function add(array $data): mixed;

    /**
     * 修改数据
     * @param mixed $id
     * @param array $data
     * @return mixed
     */
    public function edit($id, array $data): mixed;

    /**
     * 读取数据
     * @param mixed $id
     * @return mixed
     */
    public function read($id): mixed;

    /**
     * 删除数据
     * @param mixed $ids
     * @return bool
     */
    public function destroy($ids): bool;

    /**
     * 搜索器搜索
     * @param array $searchWhere
     * @return mixed
     */
    public function search(array $searchWhere = []): mixed;

    /**
     * 分页查询数据
     * @param mixed $query
     * @return mixed
     */
    public function getList($query): mixed;

    /**
     * 获取全部数据
     * @param mixed $query
     * @return mixed
     */
    public function getAll($query): mixed;

    /**
     * 数据库事务操作
     * @param callable $closure
     * @param bool $isTran
     * @return mixed
     */
    public function transaction(callable $closure, bool $isTran = true): mixed;
}
