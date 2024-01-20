<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\utils;

use plugin\saiadmin\exception\ApiException;

/**
 * 代码构建 压缩类
 * Class Zip
 * @package plugin\saiadmin\utils
 */
class Zip
{
    private $arrayConfig = [
        'suffix' 		=> '.zip',		//文件后缀
        'compileDir'	=> 'zip',	    //生成目录
        'fromDir'	=> 'saiadmin',	    //目标目录
        'cache_time'    => 7200,		//设置多长时间自动更新
        'cache'			=> true,		//是否需要缓存
    ];

    /**
     * 构造器
     */
    public function __construct()
    {
        $runPath = runtime_path();
        $this->arrayConfig['compileDir'] = $runPath.DIRECTORY_SEPARATOR.$this->arrayConfig['compileDir'];
        $this->arrayConfig['fromDir'] = $runPath.DIRECTORY_SEPARATOR.$this->arrayConfig['fromDir'];
        // 创建压缩目录
        if (!is_dir($this->arrayConfig['compileDir'])) {
            if (strtoupper(substr(PHP_OS,0,3)) === 'WIN') {
                mkdir($this->arrayConfig['compileDir']);
            } else {
                mkdir($this->arrayConfig['compileDir'], 0770, true);
            }
        }
        // 清理源目录
        if (is_dir($this->arrayConfig['fromDir'])) {
            $this->recursiveDelete($this->arrayConfig['fromDir']);
        }
    }

    /**
     * 文件压缩
     */
    public function compress(string $fileName, bool $isDownload = false)
    {
        $zipArc = new \ZipArchive;
        $zipName = $this->arrayConfig['compileDir'].DIRECTORY_SEPARATOR.$fileName;
        $dirPath = $this->arrayConfig['fromDir'];
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