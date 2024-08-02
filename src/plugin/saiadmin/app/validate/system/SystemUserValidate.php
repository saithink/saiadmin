<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\validate\system;

use think\Validate;
use plugin\saiadmin\app\model\system\SystemUser;

/**
 * 用户信息验证器
 */
class SystemUserValidate extends Validate
{
    /**
     * 定义验证规则
     */
    protected $rule =   [
        'username' => 'require|max:16|unique:'.SystemUser::class,
        'password' => 'require|min:6|max:16',
        'role_ids' => 'require',
    ];

    /**
     * 定义错误信息
     */
    protected $message  =   [
        'username.require' => '用户名必须填写',
        'username.max'     => '用户名最多不能超过16个字符',
        'username.unique' => '用户名不能重复',
        'password.require' => '密码必须填写',
        'password.min' => '密码最少为6位',
        'password.max' => '密码长度不能超过16位',
        'role_ids' => '角色必须填写',
    ];

    /**
     * 定义场景
     */
    protected $scene = [
        'save' => [
            'username',
            'password',
            'role_ids',
        ],
        'update' => [
            'username',
            'role_ids',
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
