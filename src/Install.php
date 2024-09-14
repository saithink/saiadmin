<?php
namespace Webman\saiadmin;

class Install
{
    const WEBMAN_PLUGIN = true;

    /**
     * @var array
     */
    protected static $pathRelation = [
        'plugin/saiadmin' => 'plugin/saiadmin'
    ];

    /**
     * Install
     * @return void
     */
    public static function install()
    {
        static::installByRelation();
        static::addMethod();
    }

    /**
     * Uninstall
     * @return void
     */
    public static function uninstall()
    {
        self::uninstallByRelation();
    }

    /**
     * installByRelation
     * @return void
     */
    public static function installByRelation()
    {
        foreach (static::$pathRelation as $source => $dest) {
            if ($pos = strrpos($dest, '/')) {
                $parent_dir = base_path().'/'.substr($dest, 0, $pos);
                if (!is_dir($parent_dir)) {
                    mkdir($parent_dir, 0777, true);
                }
            }
            //symlink(__DIR__ . "/$source", base_path()."/$dest");
            copy_dir(__DIR__ . "/$source", base_path()."/$dest");
            echo "Create $dest";
        }
    }

    /**
     * uninstallByRelation
     * @return void
     */
    public static function uninstallByRelation()
    {
        foreach (static::$pathRelation as $source => $dest) {
            $path = base_path()."/$dest";
            if (!is_dir($path) && !is_file($path)) {
                continue;
            }
            echo "Remove $dest";
            if (is_file($path) || is_link($path)) {
                unlink($path);
                continue;
            }
            remove_dir($path);
        }
    }

    /**
     * addMethod
     * @return void
     */
    public static function addMethod()
    {
        $path = base_path() . '/support/Request.php';
        // 如果Request中没有more方法，则自动添加一个
        $content = file_get_contents($path);
        if ($content !== false) {
            if (stripos($content, "public function more") === false) {
                echo " Request类，已有more方法\n";
                return;
            }
            
            $pattern = '/class\s+(\w+)\s+extends\s+(\\\\?(?:\w+\\\\)*\w+)\s*\{[\s\S]*?\}/';
            if (preg_match($pattern, $content, $matches, PREG_OFFSET_CAPTURE)) {
                $classEnd = $matches[0][1] + strlen($matches[0][0]) - 1;
                // 构造新方法
                $newMethod = <<<EOF
/**
 * 获取参数增强方法
 * @param array \$params
 * @return array
 */
public function more(array \$params): array
{
    \$p = [];
    foreach (\$params as \$param) {
        if (!is_array(\$param)) {
            \$p[\$param] = \$this->input(\$param);
        } else {
            if (!isset(\$param[1])) \$param[1] = '';
            if (is_array(\$param[0])) {
                \$name = \$param[0][0] . '/' . \$param[0][1];
                \$keyName = \$param[0][0];
            } else {
                \$name =  \$param[0];
                \$keyName = \$param[0];
            }
            \$p[\$keyName] = \$this->input(\$name, \$param[1]);
        }
    }
    return \$p;
}


EOF;
                // 在类的末尾插入新方法
                $newContent = substr_replace($content, $newMethod, $classEnd, 0);

                // 将修改后的内容写回文件
                if (file_put_contents($path, $newContent) === false) {
                   echo " 无法写入文件：$path";
                }

                echo " Request类添加more方法成功\n";
            } else {
                echo " Request类添加方法失败，请手动添加more方法";
            }
        }
    }
    
}
