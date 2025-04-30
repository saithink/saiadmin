<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\utils\code;

use plugin\saiadmin\exception\ApiException;

/**
 * 代码构建 压缩类
 */
class CodeZip
{

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
     * 构造器
     */
    public function __construct()
    {
        // 读取配置文件
        $config = self::_getConfig();

        // 清理源目录
        if (is_dir($config['generate_path'])) {
            $this->recursiveDelete($config['generate_path']);
        }

        // 清理压缩文件
        $zipName = $config['generate_path'].'.zip';
        if (is_file($zipName)) {
            unlink($zipName);
        }
    }

    /**
     * 文件压缩
     */
    public function compress(bool $isDownload = false)
    {
        // 读取配置文件
        $config = self::_getConfig();
        $zipArc = new \ZipArchive;
        $zipName = $config['generate_path'].'.zip';
        $dirPath = $config['generate_path'];
        if ($zipArc->open($zipName, \ZipArchive::OVERWRITE | \ZipArchive::CREATE) !== true) {
            throw new ApiException('无法打开文件，或者文件创建失败');
        }
        $this->addFileToZip($dirPath, $zipArc);
        $zipArc->close();
        // 是否下载
        if ($isDownload) {
            $this->toBinary($zipName);
        } else {
            return $zipName;
        }
    }

    /**
     * 文件解压
     */
    public function deCompress(string $file, string $dirName)
    {
        if (!file_exists($file)) {
            return false;
        }
        // zip实例化对象
        $zipArc = new \ZipArchive();
        // 打开文件
        if (!$zipArc->open($file)) {
            return false;
        }
        // 解压文件
        if (!$zipArc->extractTo($dirName)) {
            // 关闭
            $zipArc->close();
            return false;
        }
        return $zipArc->close();
    }

    /**
     * 将文件加入到压缩包
     */
    public function addFileToZip($rootPath, $zip)
    {
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($rootPath),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );
        foreach ($files as $name => $file)
        {
            // Skip directories (they would be added automatically)
            if (!$file->isDir())
            {
                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);

                // Add current file to archive
                $zip->addFile($filePath, $relativePath);
            }
        }
    }

    /**
     * 递归删除目录下所有文件和文件夹
     */
    public function recursiveDelete($dir)
    {
        // 打开指定目录
        if ($handle = @opendir($dir)) {
            while (($file = readdir($handle)) !== false) {
                if (($file == ".") || ($file == "..")) {
                    continue;
                }
                if (is_dir($dir . '/' . $file)) {
                    // 递归
                    self::recursiveDelete($dir . '/' . $file);
                } else {
                    unlink($dir . '/' . $file); // 删除文件
                }
            }
            @closedir($handle);
        }
        rmdir($dir);
    }

    /**
     * 下载二进制流文件
     */
    public function toBinary(string $fileName)
    {
        try {
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header('Content-disposition: attachment; filename=' . basename($fileName)); //文件名
            header("Content-Type: application/zip"); //zip格式的
            header("Content-Transfer-Encoding: binary"); //告诉浏览器，这是二进制文件
            header('Content-Length: ' . filesize($fileName)); //告诉浏览器，文件大小
            if(ob_get_length() > 0) {
                ob_clean();
            }
            flush();
            @readfile($fileName);
            @unlink($fileName);
        } catch (\Throwable $th) {
            throw new ApiException('系统生成文件错误');
        }
    }
}