<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\system;

use plugin\saiadmin\basic\think\BaseModel;

/**
 * 菜单模型
 *
 * sa_system_menu 菜单权限表
 *
 * @property int $id 
 * @property int $parent_id 父级ID
 * @property string $name 菜单名称
 * @property string $code 组件名称
 * @property string $slug 权限标识，如 user:list, user:add
 * @property int $type 类型: 1目录, 2菜单, 3按钮/API
 * @property string $path 路由地址或API路径
 * @property string $component 前端组件路径，如 layout/User
 * @property string $method 请求方式
 * @property string $icon 图标
 * @property int $sort 排序
 * @property string $link_url 外部链接
 * @property int $is_iframe 是否iframe
 * @property int $is_keep_alive 是否缓存
 * @property int $is_hidden 是否隐藏
 * @property int $is_fixed_tab 是否固定标签页
 * @property int $is_full_page 是否全屏
 * @property int $generate_id 生成id
 * @property int $generate_key 生成key
 * @property int $status 状态
 * @property string $remark 
 * @property int $created_by 创建者
 * @property int $updated_by 更新者
 * @property string $create_time 创建时间
 * @property string $update_time 修改时间
 */
class SystemMenu extends BaseModel
{
    // 完整数据库表名称
    protected $table = 'sa_system_menu';
    // 主键
    protected $pk = 'id';

    /**
     * Id搜索
     */
    public function searchIdAttr($query, $value)
    {
        $query->whereIn('id', $value);
    }

    public function searchNameAttr($query, $value)
    {
        $query->where('name', 'like', '%' . $value . '%');
    }

    public function searchPathAttr($query, $value)
    {
        $query->where('path', 'like', '%' . $value . '%');
    }

    public function searchMenuAttr($query, $value)
    {
        if (!empty($value)) {
            $query->whereIn('type', [1, 2]);
        }
    }

    /**
     * Type搜索
     */
    public function searchTypeAttr($query, $value)
    {
        if (is_array($value)) {
            $query->whereIn('type', $value);
        } else {
            $query->where('type', $value);
        }
    }

}