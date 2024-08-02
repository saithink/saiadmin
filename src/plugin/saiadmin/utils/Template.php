<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\utils;

use plugin\saiadmin\exception\ApiException;

/**
 * 代码构建 模板类
 * Class
 * @package plugin\saiadmin\utils
 */
class Template
{

    private $arrayConfig = [
        'templateDir' 	=> 'template',  //模板所在的文件夹
        'compileDir'	=> 'template',	//编译后存放的目录
        'genDir'		=> 'saiadmin',	//编译后存放的目录
        'cache_time'    => 7200,		//设置多长时间自动更新
        'cache'			=> true,		//是否需要缓存
    ];

    public $file;					//模板文件名,不带路径
    private $value = [];			//值栈
    private $compileTool;				//编译器


    /**
     * 构造函数
     * @param string $path
     * @throws ApiException
     */
    public function __construct(string $path = 'saithink')
    {
        // 获取模板文件夹
        $this->arrayConfig['templateDir'] = base_path($path);
        if (!is_dir($this->arrayConfig['templateDir'])) {
            // 抛出异常
            throw new ApiException('模板目录不存在！');
        }

        // 运行时目录
        $runPath = runtime_path();
        $this->arrayConfig['compileDir'] = $runPath.DIRECTORY_SEPARATOR.$this->arrayConfig['compileDir'];
        // 创建模板缓存目录
        if (!is_dir($this->arrayConfig['compileDir'])) {
            if (strtoupper(substr(PHP_OS,0,3)) === 'WIN') {
                mkdir($this->arrayConfig['compileDir']);
            } else {
                mkdir($this->arrayConfig['compileDir'], 0770, true);
            }
        }

        $this->arrayConfig['genDir'] = $runPath.DIRECTORY_SEPARATOR.$this->arrayConfig['genDir'];
        // 创建文件生成目录
        if (!is_dir($this->arrayConfig['genDir'])) {
            if (strtoupper(substr(PHP_OS,0,3)) === 'WIN') {
                mkdir($this->arrayConfig['genDir']);
            } else {
                mkdir($this->arrayConfig['genDir'], 0770, true);
            }
        }
    }

    /**
     * 单独设置引擎参数
     * 也支持一次性设置多个参数
     */
    public function setConfig($key, $value = null)
    {
        $this->arrayConfig[$key] = $value;
    }

    /**
     * 注入单个变量
     */
    public function assign($key, $value)
    {
        $this->value[$key] = $value;
    }

    /**
     * 注入数组变量
     */
    public function assignArray($array)
    {
        if (is_array($array)) {
            foreach ($array as $k => $v) {
                $this->value[$k] = $v;
            }
        }
    }

    /**
     * 预览文件
     * @throws ApiException
     */
    public function show($file)
    {
        $this->file = $this->arrayConfig['templateDir'].DIRECTORY_SEPARATOR.$file;
        if (!is_file($this->file)) {
            // 抛出异常
            throw new ApiException('找不到对应模板文件!');
        }

        $compileFile = $this->arrayConfig['compileDir'].DIRECTORY_SEPARATOR.md5($file).'.php';
        $this->compileTool = new Compile($this->file, $compileFile, $this->arrayConfig['genDir']);
        extract($this->value, EXTR_OVERWRITE);
        $this->compileTool->value = $this->value;
        return $this->compileTool->compile();
    }

    /**
     * 生成文件
     * @throws ApiException
     */
    public function gen($file, $outFile)
    {
        $this->file = $this->arrayConfig['templateDir'].DIRECTORY_SEPARATOR.$file;
        if (!is_file($this->file)) {
            // 抛出异常
            throw new ApiException('找不到对应模板文件!');
        }

        $compileFile = $this->arrayConfig['compileDir'].DIRECTORY_SEPARATOR.md5($file).'.php';
        $this->compileTool = new Compile($this->file, $compileFile, $this->arrayConfig['genDir']);
        extract($this->value, EXTR_OVERWRITE);
        $this->compileTool->value = $this->value;
        return $this->compileTool->gen($outFile);
    }

}
