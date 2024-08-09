<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\utils;

/**
 * 代码构建 编译类
 * Class
 * @package plugin\saiadmin\utils
 */
class Compile
{

    private $template;				//带编译文件
    private $content; 				//需要替换的文本
    private $comfile;				//编译后的文件
    private $genpath;				//生成目录

    private $value = array();		//值栈

    private $fileName = ""; //当前生成文件名称

    public function __construct($template, $compileFile, $genPath)
    {
        $this->template = $template;
        $this->comfile = $compileFile;
        $this->genpath = $genPath;
        $this->content = file_get_contents($template);
    }

    /**
     * 编译获取文件内容
     */
    public function compile()
    {
        $this->c_all();
        return $this->content;
    }

    /**
     * 编译生成文件
     */
    public function gen($fileName)
    {
        $this->fileName = pathinfo($fileName, PATHINFO_FILENAME);
        $this->c_all();
        $path = $this->genpath.DIRECTORY_SEPARATOR.$fileName;
        if(!is_dir(dirname($path))){
            $flag = mkdir(dirname($path),0777,true);
        }
        file_put_contents($path, $this->content);
    }

    public function c_all()
    {
        $tpl_category = $this->value['tpl_category'];
        $package_name = $this->value['package_name'];
        $menus = explode(',', $this->value['generate_menus']);
        $component_type = $this->value['component_type'];
        $generate_model = $this->value['generate_model'];
        $is_full = $this->value['is_full'];
        $current_file = $this->fileName;

        // Whether变量
        preg_match_all('/#whether[^]]+\]*([\s\S]*?)#\/whether/i', $this->content, $matches);
        for ($i=0; $i < count($matches[0]); $i++) {
            $template = $matches[0][$i];
            $value = $matches[1][$i];
            // 获取判断语句
            preg_match('/#whether\[(.* ?)\]/i', $template, $out);
            $eval = '$result = '.$out[1].';';
            eval($eval);
            if ($result) {
                // 语句成功执行 替换内容
                $strReplace = substr($value,1);
            } else {
                // 语句执行失败 返回空
                $strReplace = "";
            }
            $this->content = str_replace($template."\n", $strReplace, $this->content);
        }

        // 循环之间的内容
        preg_match_all('/#foreach[^)]+\)*([\s\S]*?)#\/foreach/i', $this->content, $matches);
        if (isset($matches[0])) {
            for ($i=0; $i < count($matches[0]); $i++) {
                $template = $matches[0][$i];
                $value = substr($matches[1][$i], 1);
                $strHtml = '';
                // 读取数组名称
                preg_match("/in \\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)/", $template, $array);
                // foreach 循环
                foreach ($this->value[$array[1]] as $element) {
                    $forTemplate = $value;
                    // 获取属性
                    if (isset($element['column_name'])) {
                        $AttrName = Helper::camel($element['column_name']);
                        $forTemplate = str_replace('${AttrName}', $AttrName, $forTemplate);
                    }
                    // 是否有IF条件
                    $ifTemplate = $this->getIfValue($forTemplate, $element);
                    $strHtml .= $ifTemplate;
                }
                $this->content = str_replace($template."\n", $strHtml, $this->content);
            }
        }

        // ${var} 单个变量
        preg_match_all("/\\$\{([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\}/", $this->content, $matches);
        for ($i=0; $i < count($matches[0]); $i++) {
            if (isset($this->value[$matches[1][$i]])){
                $template = $matches[0][$i];
                $value = $this->value[$matches[1][$i]];
                $this->content = str_replace($template, $value, $this->content);
            }
        }
    }

    /**
     * 单个变量 ${var}
     */
    public function compileSingle($strTemplate, $data)
    {
        $result = $strTemplate;
        preg_match_all("/\\$\{([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\}/", $strTemplate, $matches);
        for ($i=0; $i < count($matches[0]); $i++) {
            if (isset($data[$matches[1][$i]])){
                $template = $matches[0][$i];
                $value = $data[$matches[1][$i]];
                $result = str_replace($template, $value, $result);
            }
        }
        return $result;
    }

    /**
     * 处理IF变量
     */
    public function getIfValue($strTemplate, $element)
    {
        $tpl_category = $this->value['tpl_category'];
        if ($tpl_category == 'tree') {
            $tree_id = $this->value['options']['tree_id'] ?? '';
            $tree_parent_id = $this->value['options']['tree_parent_id'] ?? '';
            $tree_name = $this->value['options']['tree_name'] ?? '';
        } else {
            $tree_parent_id = '';
        }
        $current_file = $this->fileName;
        if (isset($element['column_name'])) {
            $default_value = $element['default_value'] ?? '';
            if (strpos($element['column_type'], 'int') !== false) {
                if (empty($element['default_value'])) {
                    $default_value = 'null';
                }
            }
            $dict = $element['dict_type'] ?? '';
            if ($element['view_type'] == 'date') {
                $element['show_time'] = empty($element['options']) ? 'false' : ($element['options']['showTime'] ? 'true' : 'false');
                $element['mode'] = empty($element['options']) ? 'date' : ($element['options']['mode'] ?? 'date');
            }
            if ($element['view_type'] == 'uploadImage' || $element['view_type'] == 'uploadFile') {
                $element['multiple'] = empty($element['options']) ? 'false' : ($element['options']['multiple'] ? 'true' : 'false');
                $element['limit'] = empty($element['options']) ? 3 : ($element['options']['limit'] ?? 3);
            }
            if ($element['view_type'] == 'cityLinkage') {
                $element['type'] = empty($element['options']) ? 'select' : ($element['options']['type'] ?? 'select');
                $element['mode'] = empty($element['options']) ? 'name' : ($element['options']['mode'] ?? 'name');
            }
            if (in_array($element['view_type'], ['editor', 'wangEditor', 'codeEditor'])) {
                $element['height'] = empty($element['options']) ? 400 : ($element['options']['height'] ?? 400);
            }
            $element['is_required'] = ($element['is_required'] == 2) ? 'true' : 'false';
            $element['is_query'] = ($element['is_query'] == 2) ? 'true' : 'false';
            $element['is_insert'] = ($element['is_insert'] == 2) ? 'true' : 'false';
            $element['is_edit'] = ($element['is_edit'] == 2) ? 'true' : 'false';
            $element['is_list'] = ($element['is_list'] == 2) ? 'true' : 'false';
            $element['is_sort'] = ($element['is_sort'] == 2) ? 'true' : 'false';
            $element['dict'] = $dict;
            $element['add_default'] = $default_value;
        }
        extract($element, EXTR_OVERWRITE);
        $return = $strTemplate;
        preg_match_all('/#if[^]]+\]*([\s\S]*?)#\/if/i', $strTemplate, $matches);
        if (count($matches[0]) > 0) {
            for ($i=0; $i < count($matches[0]); $i++) {
                $template = $matches[0][$i];
                $value = $matches[1][$i];

                $hasElse = false;
                // 判断是否有else语句
                preg_match('/#else*([\s\S]*?)#\/if/i', $template, $elseMatches);
                if (isset($elseMatches[0])) {
                    // 包含else
                    $hasElse = true;
                    // 获取 elseTemplate
                    $elseTemplate = $elseMatches[1];
                    // 获取 ifTemplate
                    preg_match('/#if[^]]*([\s\S]*?)#else/i', $template, $ifMatches);
                    $ifTemplate = substr($ifMatches[1],1);
                }
                // 获取if判断语句
                preg_match('/#if\[(.* ?)\]/i', $template, $out);
                $eval = '$result = '.$out[1].';';
                eval($eval);
                if ($result) {
                    // 语句成功执行 替换内容
                    if (!$hasElse) {
                        $ifTemplate = substr($value,1);
                    }
                    $strReplace = $this->compileSingle($ifTemplate, $element);
                } else {
                    // 语句执行失败 如果有else执行else，否则执行空
                    if (!$hasElse){
                        $strReplace = "";
                    } else {
                        $strReplace = $this->compileSingle($elseTemplate, $element);
                    }
                }
                $return = str_replace($template."\n", $strReplace, $return);
            }
            return $return;
        } else {
            return $this->compileSingle($return, $element);
        }
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        if (isset($this->$name)) {
            return $this->$name;
        } else {
            return null;
        }
    }
}
