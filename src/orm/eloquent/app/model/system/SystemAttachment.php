<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\system;

use plugin\saiadmin\basic\eloquent\BaseModel;

/**
 * 附件模型
 *
 * sa_system_attachment 附件信息表
 *
 * @property int $id 主键
 * @property int $category_id 文件分类
 * @property int $storage_mode 存储模式
 * @property string $origin_name 原文件名
 * @property string $object_name 新文件名
 * @property string $hash 文件hash
 * @property string $mime_type 资源类型
 * @property string $storage_path 存储目录
 * @property string $suffix 文件后缀
 * @property int $size_byte 字节数
 * @property string $size_info 文件大小
 * @property string $url url地址
 * @property string $remark 备注
 * @property int $created_by 创建者
 * @property int $updated_by 更新者
 * @property string $create_time 创建时间
 * @property string $update_time 修改时间
 */
class SystemAttachment extends BaseModel
{
    /**
     * 数据表主键
     * @var string
     */
    protected $primaryKey = 'id';

    protected $table = 'sa_system_attachment';

    /**
     * 文件名搜索
     */
    public function searchOriginNameAttr($query, $value)
    {
        $query->whereLike('origin_name', '%' . $value . '%');
    }

    /**
     * 文件类型搜索
     */
    public function searchMimeTypeAttr($query, $value)
    {
        $query->whereLike('mime_type', $value . '/%');
    }

}