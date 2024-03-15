<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\system;

use Exception;
use plugin\saiadmin\app\model\system\SystemUploadfile;
use plugin\saiadmin\basic\BaseLogic;
use plugin\saiadmin\exception\ApiException;
use plugin\saiadmin\utils\Arr;
use plugin\saiadmin\utils\Helper;
use support\Request;

/**
 * 角色逻辑层
 */
class SystemUploadfileLogic extends BaseLogic
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->model = new SystemUploadfile();
    }

    /**
     * 保存网络图片
     * @param $url
     * @param $relative_dir
     * @param $adminId
     * @return array
     * @throws ApiException|Exception
     */
    public function saveNetworkImage($url, $relative_dir, $adminId): array
    {
        $image_data = file_get_contents($url);
        if ($image_data === false) {
            throw new ApiException('获取文件资源失败');
        }
        $image_resource = imagecreatefromstring($image_data);
        if (!$image_resource) {
            throw new ApiException('创建图片资源失败');
        }
        $filename = basename($url);
        $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
        $full_dir = runtime_path() . '/resource/';
        if (!is_dir($full_dir)) {
            mkdir($full_dir, 0777, true);
        }
        $save_path = $full_dir . $filename;
        $mime_type = 'image/';
        switch($file_extension) {
            case 'jpg':
            case 'jpeg':
                $mime_type = 'image/jpeg';
                $result = imagejpeg($image_resource, $save_path);
                break;
            case 'png':
                $mime_type = 'image/png';
                $result = imagepng($image_resource, $save_path);
                break;
            case 'gif':
                $mime_type = 'image/gif';
                $result = imagegif($image_resource, $save_path);
                break;
            default:
                imagedestroy($image_resource);
                throw new ApiException('文件格式错误');
        }
        imagedestroy($image_resource);
        if (!$result) {
            throw new ApiException('文件保存失败');
        }

        $hash = md5_file($save_path);
        $size = filesize($save_path);

        $model = $this->model->where('hash', $hash)->find();
        if ($model) {
            unlink($save_path);
            return $model->toArray();
        } else {
            $full_dir = public_path() . $relative_dir;
            if (!is_dir($full_dir)) {
                mkdir($full_dir, 0777, true);
            }
            $object_name = bin2hex(pack('Nn',time(), random_int(1, 65535))) . ".$file_extension";
            $relative_path = $relative_dir . '/' . $object_name;
            $newPath = $full_dir.'/' . $object_name;
            copy($save_path, $newPath);
            unlink($save_path);

            $info['storage_mode'] = 1;
            $info['origin_name'] = $filename;
            $info['object_name'] = $object_name;
            $info['hash'] = $hash;
            $info['mime_type'] = $mime_type;
            $info['storage_path'] = $relative_dir;
            $info['suffix'] = $file_extension;
            $info['size_byte'] = $size;
            $info['size_info'] = formatBytes($size);
            $info['url'] = $relative_path;
            $this->model->save($info);
            return $info;
        }
    }

}
