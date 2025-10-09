<?php
namespace plugin\saiadmin\service\storage;

use plugin\saiadmin\app\logic\system\SystemConfigLogic;
use plugin\saiadmin\app\model\system\SystemAttachment;
use plugin\saiadmin\exception\ApiException;
use plugin\saiadmin\utils\Arr;

/**
 * 切片上传服务
 */
class ChunkUploadService
{
    /**
     * 基础配置
     */
    protected $config;

    protected $path;

    protected $folder = "chunk";

    /**
     * 初始化切片上传服务
     */
    public function __construct($folder = "chunk")
    {
        $logic = new SystemConfigLogic();
        $this->folder = $folder;
        $this->config = $logic->getGroup('upload_config');
        $this->path = $this->checkPath();
    }

    /**
     * 检查并创建上传路径
     * @return string
     */
    public function checkPath(): string
    {
        $root = Arr::getConfigValue($this->config,'local_root');
        $path = base_path().DIRECTORY_SEPARATOR.$root.$this->folder.DIRECTORY_SEPARATOR;
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        return $path;
    }

    /**
     * 检查切片文件上传状态
     * @param $data
     * @return array
     */
    public function checkChunk($data): array
    {
        $allow_file = Arr::getConfigValue($this->config,'upload_allow_file');
        if (!in_array($data['ext'], explode(',', $allow_file))) {
            throw new ApiException('不支持该格式的文件上传');
        }
        // 检查已经上传的分片文件
        for ($i = 1; $i <= $data['total']; ++$i) {
            $chunkFile = $this->path . "{$data['hash']}_{$data['total']}_{$i}.chunk";
            if (!file_exists($chunkFile)) {
                if ($i == 1) {
                    return $this->uploadChunk($data);
                } else {
                    return ['chunk' => $i, 'status' => 'resume'];
                }
            }
        }
        // 分片文件已经全部上传
        return ['chunk' => $i, 'status' => 'success'];
    }

    /**
     * 上传切片
     * @param $data
     * @return array
     */
    public function uploadChunk($data): array
    {
        $allow_file = Arr::getConfigValue($this->config,'upload_allow_file');
        if (!in_array($data['ext'], explode(',', $allow_file))) {
            throw new ApiException('不支持该格式的文件上传');
        }
        $uploadFile = current(request()->file());
        $chunkName = $this->path . "{$data['hash']}_{$data['total']}_{$data['index']}.chunk";
        $uploadFile->move($chunkName);
        if ($data['index'] === $data['total']) {
            return $this->mergeChunk($data);
        }
        return ['chunk' => $data['index'], 'status' => 'success'];
    }

    /**
     * 合并切片文件
     * @param $data
     * @return array
     */
    public function mergeChunk($data): array
    {
        $filePath = $this->path . $data['hash'].'.'.$data['ext'];
        $fileHandle = fopen($filePath, 'w');
        for ($i = 1; $i <= $data['total']; ++$i) {
            $chunkFile = $this->path . "{$data['hash']}_{$data['total']}_{$i}.chunk";
            if (!file_exists($chunkFile)) {
                throw new ApiException('切片文件查找失败，请重新上传');
            }
            fwrite($fileHandle, file_get_contents($chunkFile));
            unlink($chunkFile);
        }

        $domain = Arr::getConfigValue($this->config,'local_domain');
        $uri = Arr::getConfigValue($this->config,'local_uri');
        $baseUrl = $domain.$uri.$this->folder.'/';

        $save_path = Arr::getConfigValue($this->config,'local_root').$this->folder.'/';
        $object_name = $data['hash'].'.'.$data['ext'];

        $info['storage_mode'] = 1;
        $info['origin_name'] = $data['name'];
        $info['object_name'] = $object_name;
        $info['hash'] = $data['hash'];
        $info['mime_type'] = $data['type'];
        $info['storage_path'] = $save_path.$object_name;
        $info['suffix'] = $data['ext'];
        $info['size_byte'] = $data['size'];
        $info['size_info'] = formatBytes($data['size']);
        $info['url'] = $baseUrl . $object_name;
        SystemAttachment::create($info);
        return $info;
    }
}