<?php
namespace plugin\saiadmin\service\storage;

use plugin\saiadmin\app\logic\system\SystemConfigLogic;
use plugin\saiadmin\exception\ApiException;
use plugin\saiadmin\utils\Arr;

/**
 * 文件上传服务
 * @method static array uploadFile(array $config = [])  上传文件
 * @method static array uploadBase64(string $base64, string $extension = 'png') 上传Base64文件
 * @method static array uploadServerFile(string $file_path)  上传服务端文件
 */
class UploadService
{
    /**
     * @desc 存储磁盘
     * @param int $type
     * @param string $upload
     * @param bool $_is_file_upload
     * @return mixed
     */
    public static function disk(int $type = 1, string $upload = 'image', bool $_is_file_upload = true)
    {
        $logic = new SystemConfigLogic();
        $uploadConfig = $logic->getGroup('upload_config');

        $file = current(request()->file());
        $ext = $file->getUploadExtension() ?: null;
        $file_size = $file->getSize();
        if ($file_size > Arr::getConfigValue($uploadConfig,'upload_size')) {
            throw new ApiException('文件大小超过限制');
        }
        $allow_file = Arr::getConfigValue($uploadConfig,'upload_allow_file');
        $allow_image = Arr::getConfigValue($uploadConfig,'upload_allow_image');
        if ($upload == 'image') {
            if (!in_array($ext, explode(',', $allow_image))) {
                throw new ApiException('不支持该格式的文件上传');
            }
        } else {
            if (!in_array($ext, explode(',', $allow_file))) {
                throw new ApiException('不支持该格式的文件上传');
            }
        }
        switch ($type) {
            case 1:
                // 本地
                $config = [
                    'adapter' => \Tinywan\Storage\Adapter\LocalAdapter::class,
                    'root' => Arr::getConfigValue($uploadConfig,'local_root'),
                    'dirname' => function () {
                        return date('Ymd');
                    },
                    'domain' => Arr::getConfigValue($uploadConfig,'local_domain'),
                    'uri' => Arr::getConfigValue($uploadConfig, 'local_uri'),
                    'algo' => 'sha1',
                ];
                break;
            case 2:
                // 阿里云
                $config = [
                    'adapter' => \Tinywan\Storage\Adapter\OssAdapter::class,
                    'accessKeyId' => Arr::getConfigValue($uploadConfig,'oss_accessKeyId'),
                    'accessKeySecret' => Arr::getConfigValue($uploadConfig,'oss_accessKeySecret'),
                    'bucket' => Arr::getConfigValue($uploadConfig,'oss_bucket'),
                    'dirname' => Arr::getConfigValue($uploadConfig,'oss_dirname'),
                    'domain' => Arr::getConfigValue($uploadConfig,'oss_domain'),
                    'endpoint' => Arr::getConfigValue($uploadConfig,'oss_endpoint'),
                    'algo' => 'sha1',
                ];
                break;
            case 3:
                // 七牛
                $config = [
                    'adapter' => \Tinywan\Storage\Adapter\QiniuAdapter::class,
                    'accessKey' => Arr::getConfigValue($uploadConfig,'qiniu_accessKey'),
                    'secretKey' => Arr::getConfigValue($uploadConfig,'qiniu_secretKey'),
                    'bucket' => Arr::getConfigValue($uploadConfig,'qiniu_bucket'),
                    'dirname' => Arr::getConfigValue($uploadConfig,'qiniu_dirname'),
                    'domain' => Arr::getConfigValue($uploadConfig,'qiniu_domain'),
                ];
                break;
            case 4:
                // 腾讯云
                $config = [
                    'adapter' => \Tinywan\Storage\Adapter\CosAdapter::class,
                    'secretId' => Arr::getConfigValue($uploadConfig,'cos_secretId'),
                    'secretKey' => Arr::getConfigValue($uploadConfig,'cos_secretKey'),
                    'bucket' => Arr::getConfigValue($uploadConfig,'cos_bucket'),
                    'dirname' => Arr::getConfigValue($uploadConfig,'cos_dirname'),
                    'domain' => Arr::getConfigValue($uploadConfig,'cos_domain'),
                    'region' => Arr::getConfigValue($uploadConfig,'cos_region'),
                ];
                break;
            default:
                throw new ApiException('该上传模式不存在');
        }
        return new $config['adapter'](array_merge(
            $config, ['_is_file_upload' => $_is_file_upload]
        ));
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @author Tinywan(ShaoBo Wan)
     */
    public static function __callStatic($name, $arguments)
    {
        return static::disk()->{$name}(...$arguments);
    }
}
