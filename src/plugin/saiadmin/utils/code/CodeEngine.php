<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\utils\code;

use Twig\TwigFilter;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use plugin\saiadmin\exception\ApiException;

/**
 * 代码生成引擎
 */
class CodeEngine
{
    /**
     * @var array 值栈
     */
    private array $value = [];

    /**
     * 模板名称
     * @var string
     */
    private string $stub = 'saiadmin';

    /**
     * 获取配置文件
     * @return string[]
     */
    private static function _getConfig(): array
    {
        return [
            'template_path' => base_path().DIRECTORY_SEPARATOR.'plugin'.DIRECTORY_SEPARATOR.'saiadmin'.DIRECTORY_SEPARATOR.'utils'.DIRECTORY_SEPARATOR.'code'.DIRECTORY_SEPARATOR.'stub',
            'generate_path' => runtime_path().DIRECTORY_SEPARATOR.'code_engine'.DIRECTORY_SEPARATOR.'saiadmin',
        ];
    }

    /**
     * 初始化
     * @param array $data 数据
     */
    public function __construct(array $data)
    {
        // 读取配置文件
        $config = self::_getConfig();

        // 判断模板是否存在
        if (!is_dir($config['template_path'])) {
            throw new ApiException('模板目录不存在！');
        }
        // 判断文件生成目录是否存在
        if (!is_dir($config['generate_path'])) {
            mkdir($config['generate_path'], 0770, true);
        }
        // 赋值
        $this->value = $data;
    }

    /**
     * 设置模板名称
     * @param $stub
     * @return void
     */
    public function setStub($stub): void
    {
        $this->stub = $stub;
    }

    /**
     * 渲染文件内容
     */
    public function renderContent($path, $filename): string
    {
        $config = self::_getConfig();

        $path = $config['template_path'].DIRECTORY_SEPARATOR.$this->stub.DIRECTORY_SEPARATOR.$path;

        $loader = new FilesystemLoader($path);
        $twig = new Environment($loader);
        $camelFilter = new TwigFilter('camel', function ($value) {
            static $cache = [];
            $key = $value;
            if (isset($cache[$key])) {
                return $cache[$key];
            }
            $value = ucwords(str_replace(['-', '_'], ' ', $value));
            return $cache[$key] = str_replace(' ', '', $value);
        });
        $boolFilter = new TwigFilter('bool', function ($value) {
            if ($value == 1) {
                return 'true';
            } else {
                return 'false';
            }
        });
        $defaultFilter = new TwigFilter('parseNumber', function ($value) {
            if ($value) {
                return $value;
            } else {
                return 'null';
            }
        });
        $containsFilter = new TwigFilter('str_contains', function ($haystack, $needle) {
            return str_contains($haystack ?? '', $needle ?? '');
        });

        $twig->addFilter($camelFilter);
        $twig->addFilter($boolFilter);
        $twig->addFilter($containsFilter);
        $twig->addFilter($defaultFilter);

        return $twig->render($filename, $this->value);
    }

    /**
     * 生成后端文件
     */
    public function generateBackend($action, $content): void
    {
        $outPath = '';
        if ($this->value['template'] == 'app') {
            $rootPath = base_path() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . $this->value['namespace'];

        } else {
            $rootPath = base_path() . DIRECTORY_SEPARATOR . 'plugin' . DIRECTORY_SEPARATOR . $this->value['namespace'] . DIRECTORY_SEPARATOR . 'app';
        }
        $subPath = '';
        if (!empty($this->value['package_name'])) {
            $subPath = DIRECTORY_SEPARATOR . $this->value['package_name'];
        }
        switch ($action) {
            case 'controller':
                $outPath = $rootPath . DIRECTORY_SEPARATOR . 'controller' . $subPath . DIRECTORY_SEPARATOR . $this->value['class_name'] . 'Controller.php';
                break;
            case 'logic':
                $outPath = $rootPath . DIRECTORY_SEPARATOR . 'logic' . $subPath . DIRECTORY_SEPARATOR . $this->value['class_name'] . 'Logic.php';
                break;
            case 'model':
                $outPath = $rootPath . DIRECTORY_SEPARATOR . 'model' . $subPath . DIRECTORY_SEPARATOR . $this->value['class_name'] . '.php';
                break;
            case 'validate':
                $outPath = $rootPath . DIRECTORY_SEPARATOR . 'validate' . $subPath . DIRECTORY_SEPARATOR . $this->value['class_name'] . 'Validate.php';
                break;
            default:
                break;
        }

        if (empty($outPath)) {
            throw new ApiException('文件类型异常，无法生成指定文件！');
        }
        if (!is_dir(dirname($outPath))) {
            mkdir(dirname($outPath), 0777, true);
        }

        file_put_contents($outPath, $content);
    }

    /**
     * 生成前端文件
     */
    public function generateFrontend($action, $content): void
    {
        $rootPath = dirname(base_path()) . DIRECTORY_SEPARATOR . $this->value['generate_path'];
        if (!is_dir($rootPath)) {
            throw new ApiException('前端目录查找失败，必须与后端目录为同级目录！');
        }

        $rootPath = $rootPath . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $this->value['namespace'];
        $subPath = '';
        if (!empty($this->value['package_name'])) {
            $subPath = DIRECTORY_SEPARATOR . $this->value['package_name'];
        }
        switch ($action) {
            case 'index':
                $outPath = $rootPath . $subPath . DIRECTORY_SEPARATOR . $this->value['business_name'] . DIRECTORY_SEPARATOR . 'index.vue';
                break;
            case 'edit':
                $outPath = $rootPath . $subPath . DIRECTORY_SEPARATOR . $this->value['business_name'] . DIRECTORY_SEPARATOR . 'edit.vue';
                break;
            case 'api':
                $outPath = $rootPath . DIRECTORY_SEPARATOR . 'api' . $subPath . DIRECTORY_SEPARATOR . $this->value['business_name'] . '.js';
                break;
            default:
                break;
        }

        if (empty($outPath)) {
            throw new ApiException('文件类型异常，无法生成指定文件！');
        }
        if (!is_dir(dirname($outPath))) {
            mkdir(dirname($outPath), 0777, true);
        }

        file_put_contents($outPath, $content);
    }

    /**
     * 生成临时文件
     */
    public function generateTemp(): void
    {
        $config = self::_getConfig();
        $rootPath = $config['generate_path'];

        $vuePath = $rootPath . DIRECTORY_SEPARATOR . 'vue' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $this->value['namespace'];
        $phpPath = $rootPath . DIRECTORY_SEPARATOR . 'php';
        $sqlPath = $rootPath . DIRECTORY_SEPARATOR . 'sql';
        if ($this->value['template'] == 'app') {
            $phpPath = $phpPath . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . $this->value['namespace'];

        } else {
            $phpPath = $phpPath . DIRECTORY_SEPARATOR . 'plugin' . DIRECTORY_SEPARATOR . $this->value['namespace'] . DIRECTORY_SEPARATOR . 'app';
        }
        $subPath = '';
        if (!empty($this->value['package_name'])) {
            $subPath = DIRECTORY_SEPARATOR . $this->value['package_name'];
        }

        $indexOutPath = $vuePath . $subPath . DIRECTORY_SEPARATOR . $this->value['business_name']. DIRECTORY_SEPARATOR . 'index.vue';
        $this->checkPath($indexOutPath);
        $indexContent = $this->renderContent('vue', 'index.stub');
        file_put_contents($indexOutPath, $indexContent);

        $editOutPath = $vuePath . $subPath . DIRECTORY_SEPARATOR . $this->value['business_name']. DIRECTORY_SEPARATOR . 'edit.vue';
        $this->checkPath($editOutPath);
        $editContent = $this->renderContent('vue', 'edit.stub');
        file_put_contents($editOutPath, $editContent);

        $viewOutPath = $vuePath . DIRECTORY_SEPARATOR . 'api' . DIRECTORY_SEPARATOR . $this->value['business_name'] . '.js';
        $this->checkPath($viewOutPath);
        $viewContent = $this->renderContent('js', 'api.stub');
        file_put_contents($viewOutPath, $viewContent);

        $controllerOutPath = $phpPath . DIRECTORY_SEPARATOR . 'controller' . $subPath . DIRECTORY_SEPARATOR . $this->value['class_name'] . 'Controller.php';
        $this->checkPath($controllerOutPath);
        $controllerContent = $this->renderContent('php', 'controller.stub');
        file_put_contents($controllerOutPath, $controllerContent);

        $logicOutPath = $phpPath . DIRECTORY_SEPARATOR . 'logic' . $subPath . DIRECTORY_SEPARATOR . $this->value['class_name'] . 'Logic.php';
        $this->checkPath($logicOutPath);
        $logicContent = $this->renderContent('php', 'logic.stub');
        file_put_contents($logicOutPath, $logicContent);

        $validateOutPath = $phpPath . DIRECTORY_SEPARATOR . 'validate' . $subPath . DIRECTORY_SEPARATOR . $this->value['class_name'] . 'Validate.php';
        $this->checkPath($validateOutPath);
        $validateContent = $this->renderContent('php', 'validate.stub');
        file_put_contents($validateOutPath, $validateContent);

        $modelOutPath = $phpPath . DIRECTORY_SEPARATOR . 'model' . $subPath . DIRECTORY_SEPARATOR . $this->value['class_name'] . '.php';
        $this->checkPath($modelOutPath);
        $modelContent = $this->renderContent('php', 'model.stub');
        file_put_contents($modelOutPath, $modelContent);

        $sqlOutPath = $sqlPath . DIRECTORY_SEPARATOR . 'sql.sql';
        $this->checkPath($sqlOutPath);
        $sqlContent = $this->renderContent('sql', 'sql.stub');
        file_put_contents($sqlOutPath, $sqlContent);
    }

    /**
     * 检查并生成路径
     * @param $path
     * @return void
     */
    protected function checkPath($path): void
    {
        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }
    }

}