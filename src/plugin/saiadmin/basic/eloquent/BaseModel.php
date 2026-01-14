<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\basic\eloquent;

use support\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use plugin\saiadmin\basic\contracts\ModelInterface;

/**
 * Laravel Eloquent 模型基类
 */
class BaseModel extends Model implements ModelInterface
{
    use SoftDeletes;

    /**
     * 创建时间字段
     */
    const CREATED_AT = 'create_time';

    /**
     * 更新时间字段
     */
    const UPDATED_AT = 'update_time';

    /**
     * 删除时间字段
     */
    const DELETED_AT = 'delete_time';

    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = ['delete_time'];

    /**
     * 不可批量赋值的属性 (为空表示全部可赋值)
     * @var array
     */
    protected $guarded = [];

    /**
     * 类型转换
     * @return array
     */
    protected function casts(): array
    {
        return [
            'create_time' => 'datetime:Y-m-d H:i:s',
            'update_time' => 'datetime:Y-m-d H:i:s',
        ];
    }

    /**
     * 处理时区问题
     * @param \DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date): string
    {
        return $date->format($this->dateFormat ?: 'Y-m-d H:i:s');
    }

    /**
     * 获取表名
     * @return string
     */
    public function getTableName(): string
    {
        return $this->getTable();
    }

    /**
     * 获取主键名
     * @return string
     */
    public function getPrimaryKeyName(): string
    {
        return $this->getKeyName();
    }

    /**
     * 搜索器搜索
     * @param array $fields
     * @param array $data
     * @return mixed
     */
    public function withSearch(array $fields, array $data): mixed
    {
        $query = $this->newQuery();
        foreach ($fields as $field) {
            $method = 'search' . ucfirst($this->toCamelCase($field)) . 'Attr';
            if (method_exists($this, $method) && isset($data[$field]) && $data[$field] !== '') {
                $this->$method($query, $data[$field]);
            } else {
                $query->where($field, $data[$field]);
            }
        }
        return $query;
    }

    /**
     * 将下划线命名转换为驼峰命名
     * @param string $str
     * @return string
     */
    protected function toCamelCase(string $str): string
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $str))));
    }

    /**
     * 添加时间范围搜索
     * @param $query
     * @param $value
     */
    public function searchCreateTimeAttr($query, $value)
    {
        if (is_array($value)) {
            $query->whereBetween('create_time', $value);
        } else {
            $query->where('create_time', '=', $value);
        }
    }

    /**
     * 更新时间范围搜索
     * @param mixed $query
     * @param mixed $value
     */
    public function searchUpdateTimeAttr($query, $value)
    {
        if (is_array($value)) {
            $query->whereBetween('update_time', $value);
        } else {
            $query->where('update_time', '=', $value);
        }
    }

    /**
     * 模型启动事件
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        // 创建前事件
        static::creating(function ($model) {
            $info = getCurrentInfo();
            $schema = $model->getConnection()->getSchemaBuilder();
            if ($info && $schema->hasColumn($model->getTable(), 'created_by')) {
                $model->created_by = $info['id'];
            }
        });

        // 保存前事件
        static::saving(function ($model) {
            $info = getCurrentInfo();
            $schema = $model->getConnection()->getSchemaBuilder();
            if ($info && $schema->hasColumn($model->getTable(), 'updated_by')) {
                $model->updated_by = $info['id'];
            }
        });
    }
}
