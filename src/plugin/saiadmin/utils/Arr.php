<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\utils;

/**
 * Array操作类
 * Class Arr
 * @package plugin\saiadmin\utils
 */
class Arr
{
    /**
     * 获取数组中指定的列
     * @param array $source
     * @param string $column
     * @return array
     */
    public static function getArrayColumn($source, $column): array
    {
        $columnArr = [];
        foreach ($source as $item) {
            $columnArr[] = $item[$column];
        }
        return $columnArr;
    }

    /**
     * 批量获取数组中指定的列
     * @param array $source
     * @param array $column
     * @return array
     */
    public static function getArrayColumns($source, $columns): array
    {
        $columnArr = [];
        foreach ($source as $item) {
            $tempArr = [];
            foreach ($columns as $key) {
                $temp = explode('.', $key);
                if (count($temp) > 1) {
                    $tempArr[$key] = $item[$temp[0]][$temp[1]];
                } else {
                    $tempArr[$key] = $item[$key];
                }
            }
            $columnArr[] = $tempArr;
        }
        return $columnArr;
    }

    /**
     * 把二维数组中某列设置为key返回
     * @param array $array 输入数组
     * @param string $field 要作为键的字段名
     * @param bool $unique 要做键的字段是否唯一(该字段与记录是否一一对应)
     * @return array
     */
    public static function fieldAsKey($array, $field, $unique = false) {
        $result = [];
        foreach ($array as $item) {
            if (isset($item[$field])) {
                if (!$unique && isset($result[$item[$field]])) {
                    $unique = true;
                    $result[$item[$field]] = [($result[$item[$field]])];
                    $result[$item[$field]][] = $item;
                } elseif ($unique) {
                    $result[$item[$field]][] = $item;
                } else {
                    $result[$item[$field]] = $item;
                }
            }
        }
        return $result;
    }

    /**
     * 数组转字符串去重复
     * @param array $data
     * @return false|string[]
     */
    public static function unique(array $data)
    {
        return array_unique(explode(',', implode(',', $data)));
    }

    /**
     * 获取数组中去重复过后的指定key值
     * @param array $list
     * @param string $key
     * @return array
     */
    public static function getUniqueKey(array $list, string $key)
    {
        return array_unique(array_column($list, $key));
    }

    /**
     * 合并二维数组，并且指定key去重, 第一个覆盖第二个
     * @param array $arr1
     * @param array $arr2
     * @param string $key
     * @return array
     */
    public static function mergeArray(array $arr1, array $arr2, string $key)
    {
        $arr = array_merge($arr1,$arr2);
        $tmp_arr = [];
        foreach($arr as $k => $v) {
            if(in_array($v[$key], $tmp_arr)) {
                unset($arr[$k]);
            } else {
                $tmp_arr[] = $v[$key];
            }
        }
        return $arr;
    }

    /**
     * 相同键值的合并作为键生成新数组
     * @param array $data
     * @param string $field
     * @return array
     */
    public static function groupSameField(array $data, string $field)
    {
        $result= [];
        foreach ($data as $key => $info) {
            $result[$info[$field]][] = $info;
        }
        return $result;
    }

    /**
     * 生成无限级树算法
     * @param  array  $arr                输入数组
     * @param  number $pid                根级的pid
     * @param  string $column_name        列名,id|pid父id的名字|children子数组的键名
     * @return array  $ret
     */
    public static function makeTree($arr, $pid = 0, $column_name = 'id|pid|children') {
        list($idname, $pidname, $cldname) = explode('|', $column_name);
        $ret = array();
        foreach ($arr as $k => $v) {
            if ($v [$pidname] == $pid) {
                $tmp = $arr [$k];
                unset($arr [$k]);
                $tmp [$cldname] = self::makeTree($arr, $v [$idname], $column_name);
                $ret [] = $tmp;
            }
        }
        return $ret;
    }

    /**
     * 二位数组按某个键值排序
     * @param array $arr
     * @param string $key
     * @param int $sort
     * @return array
     */
    public static function sortArray($arr, $key, $sort = SORT_ASC)
    {
        array_multisort(array_column($arr,$key),$sort,$arr);
        return $arr;
    }

    /**
     * 数组中根据某一列中某个字段的值来查询这一列数据
     * @param $array
     * @param $column
     * @param $value
     * @return array
     */
    public static function getArrayByColumn($array, $column, $value): array
    {
        $result = [];
        foreach ($array as $key => $item) {
            if ($item[$column] == $value) {
                $result = $item;
            }
        }
        return $result;
    }

}
