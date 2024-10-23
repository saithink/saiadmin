<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\utils;

/**
 * 帮助类
 */
class Helper
{
    /**
     * 数据树形化
     * @param array $data 数据
     * @param string $childrenname 子数据名
     * @param string $keyName 数据key名
     * @param string $pidName 数据上级key名
     * @return array
     */
    public static function makeTree(array $data, string $childrenname = 'children', string $keyName = 'id', string $pidName = 'parent_id')
    {
        $list = [];
        foreach ($data as $value) {
            $list[$value[$keyName]] = $value;
        }
        $tree = []; //格式化好的树
        foreach ($list as $item) {
            if (isset($list[$item[$pidName]])) {
                $list[$item[$pidName]][$childrenname][] = &$list[$item[$keyName]];
            } else {
                $tree[] = &$list[$item[$keyName]];
            }
        }
        return $tree;
    }

    /**
     * 生成ElementPlus菜单
     * @param array $data 数据
     * @param string $childrenname 子数据名
     * @param string $keyName 数据key名
     * @param string $pidName 数据上级key名
     * @return array
     */
    public static function makeEleMenus(array $data, string $childrenname = 'children', string $keyName = 'id', string $pidName = 'pid')
    {
        $list = [];
        foreach ($data as $value) {
            if ($value['auth_type'] === 1){
                $component = '';
                $path = $value['path'];
                $temp = [
                    $keyName => $value[$keyName],
                    $pidName => $value[$pidName],
                    'name' => self::camelize(str_replace('/','_',$value['path'])),
                    'path' => $path,
                    'component' => $value['component'],
                    'meta' => [
                        'title' => $value['title'],
                        'isLink' => $value['link_url'],
                        'isKeepAlive' => $value['is_keep'] === 1 ? true : false,
                        'isAffix' => $value['is_affix'] === 1 ? true : false,
                        'isIframe' => $value['is_iframe'] === 1 ? true : false,
                        'isHide' => $value['is_hide'] === 1 ? true : false,
                        'icon' => $value['icon'],
                    ],
                ];
                $list[$value[$keyName]] = $temp;
            }
        }
        $tree = []; //格式化好的树
        foreach ($list as $item) {
            if (isset($list[$item[$pidName]])) {
                $list[$item[$pidName]][$childrenname][] = &$list[$item[$keyName]];
            } else {
                $tree[] = &$list[$item[$keyName]];
            }
        }
        return $tree;
    }

    /**
     * 生成Arco菜单
     * @param array $data 数据
     * @param string $childrenname 子数据名
     * @param string $keyName 数据key名
     * @param string $pidName 数据上级key名
     * @return array
     */
    public static function makeArcoMenus(array $data, string $childrenname = 'children', string $keyName = 'id', string $pidName = 'parent_id')
    {
        $list = [];
        foreach ($data as $value) {
            if ($value['type'] === 'M'){
                $path = '/'.$value['route'];
                $layout = isset($value['is_layout']) ? $value['is_layout'] : 1;
                $temp = [
                    $keyName => $value[$keyName],
                    $pidName => $value[$pidName],
                    'name' => $value['route'],
                    'path' => $path,
                    'component' => $value['component'],
                    'redirect' => $value['redirect'],
                    'meta' => [
                        'title' => $value['name'],
                        'type' => $value['type'],
                        'hidden' => $value['is_hidden'] === 1,
                        'layout' => $layout === 1,
                        'hiddenBreadcrumb' => false,
                        'icon' => $value['icon'],
                    ],
                ];
                $list[$value[$keyName]] = $temp;
            }
			if ($value['type'] === 'I' || $value['type'] === 'L'){
                $temp = [
                    $keyName => $value[$keyName],
                    $pidName => $value[$pidName],
                    'name' => $value['code'],
                    'path' => $value['route'],
                    'meta' => [
                        'title' => $value['name'],
                        'type' => $value['type'],
                        'hidden' => $value['is_hidden'] === 1,
                        'hiddenBreadcrumb' => false,
                        'icon' => $value['icon'],
                    ],
                ];
                $list[$value[$keyName]] = $temp;
            }
        }
        $tree = []; //格式化好的树
        foreach ($list as $item) {
            if (isset($list[$item[$pidName]])) {
                $list[$item[$pidName]][$childrenname][] = &$list[$item[$keyName]];
            } else {
                $tree[] = &$list[$item[$keyName]];
            }
        }
        return $tree;
    }

    /**
     * 生成按钮权限数组
     * @param array $data 数据
     * @return array
     */
    public static function makeEleBtns(array $data)
    {
        $list = [];
        foreach ($data as $value) {
            if ($value['type'] === 'B'){
                $str = $value['code'];
                array_push($list, $str);
            }
        }
        return $list;
    }

    /**
     * 下划线转驼峰
     */
    public static function camelize($uncamelized_words,$separator='_')
    {
        $uncamelized_words = $separator. str_replace($separator, " ", strtolower($uncamelized_words));
        return ltrim(str_replace(" ", "", ucwords($uncamelized_words)), $separator );
    }

    /**
     * 驼峰命名转下划线命名
     */
    public static function uncamelize($camelCaps,$separator='_')
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camelCaps));
    }

    /**
     * 转换为驼峰
     * @param string $value
     * @return string
     */
    public static function camel(string $value): string
    {
        static $cache = [];
        $key = $value;

        if (isset($cache[$key])) {
            return $cache[$key];
        }

        $value = ucwords(str_replace(['-', '_'], ' ', $value));

        return $cache[$key] = str_replace(' ', '', $value);
    }

    /**
     * 获取业务名称
     * @param string $tableName
     * @return mixed
     */
    public static function get_business(string $tableName)
    {
        $start = strrpos($tableName,'_');
        if ($start !== false) {
            $result = substr($tableName, $start + 1);
        } else {
            $result = $tableName;
        }
        return static::camelize($result);
    }

    /**
     * 获取业务名称
     * @param string $tableName
     * @return mixed
     */
    public static function get_big_business(string $tableName)
    {
        $start = strrpos($tableName,'_');
        $result = substr($tableName, $start + 1);
        return static::camel($result);
    }

    /**
     * 只替换一次字符串
     * @param $needle
     * @param $replace
     * @param $haystack
     * @return array|mixed|string|string[]
     */
    public static function str_replace_once($needle, $replace, $haystack)
    {
        $pos = strpos($haystack, $needle);
        if ($pos === false) {
            return $haystack;
        }
        return substr_replace($haystack, $replace, $pos, strlen($needle));
    }

    /**
     * 遍历目录
     * @param $template_name
     * @return array
     */
    public static function get_dir($template_name)
    {
        $dir = base_path($template_name);
        $fileDir = [];
        if (is_dir($dir)){
            if ($dh = opendir($dir)){
                while (($file = readdir($dh)) !== false){
                    if($file != "." && $file != ".."){
                        array_push($fileDir, $file);
                    }
                }
                closedir($dh);
            }
        }
        return $fileDir;
    }
}