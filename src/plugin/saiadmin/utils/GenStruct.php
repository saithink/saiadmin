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
     * 模板saiadmin 文件生成结构
     * @param $table
     * @return array
     */
    public static function saiadmin($table): array
    {
        $struct = [];
        // php
        $struct[] = [
            'input' => 'php/controller.stub',
            'output' => $table['namespace'].DS.'controller'.DS.$table['package_name'].DS.$table['class_name'].'Controller.php'
        ];
        $struct[] = [
            'input' => 'php/logic.stub',
            'output' => $table['namespace'].DS.'logic'.DS.$table['package_name'].DS.$table['class_name'].'Logic.php'
        ];
        $struct[] = [
            'input' => 'php/model.stub',
            'output' => $table['namespace'].DS.'model'.DS.$table['package_name'].DS.$table['class_name'].'.php'
        ];
        $struct[] = [
            'input' => 'php/route.stub',
            'output' => 'app'.DS.'config'.DS.'route.php'
        ];
        // vue
        $struct[] = [
            'input' => 'js/api.stub',
            'output' => 'src'.DS.'api'.DS.$table['package_name'].DS.$table['business_name'].'.js'
        ];
        $struct[] = [
            'input' => 'vue'.DS.$table['tpl_category'].'.stub',
            'output' => 'src'.DS.'views'.DS.$table['package_name'].DS.$table['business_name'].DS.'index.vue'
        ];
        // sql
        $struct[] = [
            'input' => 'sql/sql.stub',
            'output' => 'sql'.DS.'sql.sql'
        ];
        return $struct;
    }

}