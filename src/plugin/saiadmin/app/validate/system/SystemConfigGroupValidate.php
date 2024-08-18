<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\validate\system;

use think\Validate;
use plugin\saiadmin\app\model\system\SystemConfigGroup;

/**
 * 字典类型验证器
 */
class SystemConfigGroupValidate extends Validate
{
    /**
     * 定义验证规则
     */
    protected $rule =   [
        'name' => 'require|max:16|chs',
        'code' => 'require|alphaDash|unique:'.SystemConfigGroup::class,
    ];

    /**
     * 定义错误信息
     */
    protected $message  =   [
        'name.require' => '组名称必须填写',
        'name.max'     => '组名称最多不能超过16个字符',
        'name.chs'     => '组名称必须是中文',
        'code.require' => '组标识必须填写',
        'code.alphaDash' => '组标识只能由英文字母组成',
        'code.unique' => '配置组标识不能重复',
    ];

    /**
     * 定义场景
     */
    protected $scene = [
        'save' => [
            'name',
            'code',
        ],
        'update' => [
            'name',
            'code',
        ],
    ];

    /**
     * 验证是否唯一
     * @access public
     * @param mixed  $value 字段值
     * @param mixed  $rule  验证规则 格式：数据表,字段名,排除ID,主键名
     * @param array  $data  数据
     * @param string $field 验证字段名
     * @return bool
     */
    public function unique($value, $rule, array $data = [], string $field = ''): bool
    {
        if (is_string($rule)) {
            $rule = explode(',', $rule);
        }

        if (str_contains($rule[0], '\\')) {
            // 指定模型类
            $db = new $rule[0];
        } else {
            return false;
        }

        $key = $rule[1] ?? $field;
        $map = [];

        if (str_contains($key, '^')) {
            // 支持多个字段验证
            $fields = explode('^', $key);
            foreach ($fields as $key) {
                if (isset($data[$key])) {
                    $map[] = [$key, '=', $data[$key]];
                }
            }
        } elseif (strpos($key, '=')) {
            // 支持复杂验证
            parse_str($key, $array);
            foreach ($array as $k => $val) {
                $map[] = [$k, '=', $data[$k] ?? $val];
            }
        } elseif (isset($data[$field])) {
            $map[] = [$key, '=', $data[$field]];
        }

        $pk = !empty($rule[3]) ? $rule[3] : $db->getPk();

        if (is_string($pk)) {
            if (isset($rule[2])) {
                $map[] = [$pk, '<>', $rule[2]];
            } elseif (isset($data[$pk])) {
                $map[] = [$pk, '<>', $data[$pk]];
            }
        }

        if ($db->where($map)->field($pk)->find()) {
            return false;
        }

        return true;
    }

}
