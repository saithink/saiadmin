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
            $info['created_by'] = $adminId;
            $info['updated_by'] = $adminId;
            $this->model->save($info);
            return $info;
        }
    }

    /**
     * 获取上传数据
     * @param Request $request
     * @param string $type
     * @return array
     * @throws ApiException|Exception
     */
    public function uploadInfo(Request $request, string $type = 'image'): array
    {
        $file = current($request->file());
        if (!$file || !$file->isValid()) {
            throw new ApiException('未找到上传文件', 400);
        }

        $relative_dir = '/upload/'.$type.'/'.date('Ymd');
        $full_dir = public_path() . $relative_dir;
        if (!is_dir($full_dir)) {
            mkdir($full_dir, 0777, true);
        }

        $ext = $file->getUploadExtension() ?: null;
        $mime_type = $file->getUploadMimeType();
        $file_name = $file->getUploadName();
        $file_size = $file->getSize();

        if (!$ext && $file_name === 'blob') {
            [$___image, $ext] = explode('/', $mime_type);
            unset($___image);
        }
        $ext = strtolower($ext);
        $upload_config = getConfigGroup('upload_config');
        $ext_forbidden_map = config('plugin.saiadmin.saithink.upload.fileExt');
        $upload_max_size = config('plugin.saiadmin.saithink.upload.filesize');
        if ($type == 'image') {
            $config = Arr::getArrayByColumn($upload_config, 'key', 'upload_allow_image');
            $ext_forbidden_map = explode(',', $config['value']);
        }
        if ($type == 'file') {
            $config = Arr::getArrayByColumn($upload_config, 'key', 'upload_allow_file');
            $ext_forbidden_map = explode(',', $config['value']);
        }
        if (!in_array($ext, $ext_forbidden_map)) {
            throw new ApiException('不支持该格式的文件上传', 400);
        }
        $upload_column = Arr::getArrayByColumn($upload_config, 'key', 'upload_size');
        if ($upload_column && count($upload_column) > 0) {
            $upload_max_size = $upload_column['value'];
        }
        if ($file_size > $upload_max_size) {
            throw new ApiException('文件大小超过限制', 400);
        }
        $object_name = bin2hex(pack('Nn',time(), random_int(1, 65535))) . ".$ext";
        $relative_path = $relative_dir . '/' . $object_name;
        $full_path = public_path() . $relative_path;
        $file->move($full_path);
        $image_with = $image_height = 0;
        if ($img_info = getimagesize($full_path)) {
            [$image_with, $image_height] = $img_info;
            $mime_type = $img_info['mime'];
        }
        return [
            'url'     => $relative_path,
            'name'     => $file_name,
            'object_name' => $object_name,
            'realpath' => $full_path,
            'storage_path' => $relative_dir,
            'size'     => $file_size,
            'mime_type' => $mime_type,
            'image_with' => $image_with,
            'image_height' => $image_height,
            'ext' => $ext,
        ];
    }

}
