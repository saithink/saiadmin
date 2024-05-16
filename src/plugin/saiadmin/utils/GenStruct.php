<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\utils;

const DS = DIRECTORY_SEPARATOR;
/**
 * 生成结构类
 */
class GenStruct
{
    /**
     * 模板 文件生成结构
     * @param $table
     * @return array
     */
    public static function app($table): array
    {
        $struct = [];
        // php
        $plugin_path = 'php'.DS.'app'.DS.$table['namespace'].DS;
        if ($table['package_name'] != '') {
            $php_temp = DS.$table['package_name'].DS;
        } else {
            $php_temp = DS;
        }
        $struct[] = [
            'input' => 'php/controller.stub',
            'output' => $plugin_path.DS.'controller'.$php_temp.$table['class_name'].'Controller.php'
        ];
        $struct[] = [
            'input' => 'php/logic.stub',
            'output' => $plugin_path.DS.'logic'.$php_temp.$table['class_name'].'Logic.php'
        ];
        $struct[] = [
            'input' => 'php/model.stub',
            'output' => $plugin_path.DS.'model'.$php_temp.$table['class_name'].'.php'
        ];
        $struct[] = [
            'input' => 'php/validate.stub',
            'output' => $plugin_path.DS.'validate'.$php_temp.$table['class_name'].'Validate.php'
        ];
        $struct[] = [
            'input' => 'php/route.stub',
            'output' => 'php'.DS.'config'.DS.'route.generate.txt'
        ];

        // vue
        if ($table['package_name'] != '') {
            $vue_path = 'src'.DS.'views'.DS.$table['namespace'].DS.$table['package_name'].DS.$table['business_name'].DS;
            $js_path = 'src'.DS.'views'.DS.$table['namespace'].DS.'api'.DS.$table['package_name'].DS.$table['business_name'];
        } else {
            $vue_path = 'src'.DS.'views'.DS.$table['namespace'].DS.$table['business_name'].DS;
            $js_path = 'src'.DS.'views'.DS.$table['namespace'].DS.'api'.DS.$table['business_name'];
        }
        $struct[] = [
            'input' => 'js/api.stub',
            'output' => $js_path.'.js'
        ];
        $struct[] = [
            'input' => 'vue'.DS.$table['tpl_category'].'.stub',
            'output' => $vue_path.'index.vue'
        ];
        // sql
        $struct[] = [
            'input' => 'sql/sql.stub',
            'output' => 'sql'.DS.'sql.sql'
        ];
        return $struct;
    }

    /**
     * 模板 文件生成结构
     * @param $table
     * @return array
     */
    public static function plugin($table): array
    {
        $struct = [];
        // php
        $plugin_path = 'php'.DS.'plugin'.DS.$table['namespace'].DS;
        if ($table['package_name'] != '') {
            $php_temp = DS.$table['package_name'].DS;
        } else {
            $php_temp = DS;
        }
        $struct[] = [
            'input' => 'php/controller.stub',
            'output' => $plugin_path.'app'.DS.'controller'.$php_temp.$table['class_name'].'Controller.php'
        ];
        $struct[] = [
            'input' => 'php/logic.stub',
            'output' => $plugin_path.'app'.DS.'logic'.$php_temp.$table['class_name'].'Logic.php'
        ];
        $struct[] = [
            'input' => 'php/model.stub',
            'output' => $plugin_path.'app'.DS.'model'.$php_temp.$table['class_name'].'.php'
        ];
        $struct[] = [
            'input' => 'php/validate.stub',
            'output' => $plugin_path.'app'.DS.'validate'.$php_temp.$table['class_name'].'Validate.php'
        ];
        $struct[] = [
            'input' => 'php/route.stub',
            'output' => $plugin_path.'config'.DS.'route.generate.txt'
        ];

        // vue
        if ($table['package_name'] != '') {
            $vue_path = 'src'.DS.'views'.DS.$table['namespace'].DS.$table['package_name'].DS.$table['business_name'].DS;
            $js_path = 'src'.DS.'views'.DS.$table['namespace'].DS.'api'.DS.$table['package_name'].DS.$table['business_name'];
        } else {
            $vue_path = 'src'.DS.'views'.DS.$table['namespace'].DS.$table['business_name'].DS;
            $js_path = 'src'.DS.'views'.DS.$table['namespace'].DS.'api'.DS.$table['business_name'];
        }
        $struct[] = [
            'input' => 'js/api.stub',
            'output' => $js_path.'.js'
        ];
        $struct[] = [
            'input' => 'vue'.DS.$table['tpl_category'].'.stub',
            'output' => $vue_path.'index.vue'
        ];
        // sql
        $struct[] = [
            'input' => 'sql/sql.stub',
            'output' => 'sql'.DS.'sql.sql'
        ];
        return $struct;
    }

}