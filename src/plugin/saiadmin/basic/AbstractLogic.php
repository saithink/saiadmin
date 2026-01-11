<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\basic;

use plugin\saiadmin\basic\contracts\LogicInterface;

/**
 * 抽象逻辑层基类
 * 定义通用属性和方法签名，具体实现由各 ORM 驱动完成
 */
abstract class AbstractLogic implements LogicInterface
{
    /**
     * 模型注入
     * @var object
     */
    protected $model;

    /**
     * 管理员信息
     * @var array
     */
    protected array $adminInfo;

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
     * @param string $field
     * @return static
     */
    public function setOrderField(string $field): static
    {
        $this->orderField = $field;
        return $this;
    }

    /**
     * 设置排序方式
     * @param string $type
     * @return static
     */
    public function setOrderType(string $type): static
    {
        $this->orderType = $type;
        return $this;
    }

    /**
     * 获取模型实例
     * @return object
     */
    public function getModel(): object
    {
        return $this->model;
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
        $full_path = $full_dir . md5(time()) . '.' . $ext;
        $file->move($full_path);
        return $full_path;
    }

    /**
     * 方法调用代理到模型
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments): mixed
    {
        return call_user_func_array([$this->model, $name], $arguments);
    }
}
