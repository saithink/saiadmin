<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\system;

use plugin\saiadmin\basic\think\BaseModel;

/**
 * 附件模型
 *
 * sa_system_attachment 附件信息表
 *
 * @property  $id 主键
 * @property  $category_id 文件分类
 * @property  $storage_mode 存储模式
 * @property  $origin_name 原文件名
 * @property  $object_name 新文件名
 * @property  $hash 文件hash
 * @property  $mime_type 资源类型
 * @property  $storage_path 存储目录
 * @property  $suffix 文件后缀
 * @property  $size_byte 字节数
 * @property  $size_info 文件大小
 * @property  $url url地址
 * @property  $remark 备注
 * @property  $created_by 创建者
 * @property  $updated_by 更新者
 * @property  $create_time 创建时间
 * @property  $update_time 修改时间
 */
class SystemAttachment extends BaseModel
{
    /**
     * 数据表主键
     * @var string
     */
    protected $pk = 'id';

    protected $table = 'sa_system_attachment';

    /**
     * 原文件名搜索
     */
    public function searchOriginNameAttr($query, $value)
    {
        $query->where('origin_name', 'like', '%' . $value . '%');
    }

    /**
     * 文件类型搜索
     */
    public function searchMimeTypeAttr($query, $value)
    {
        $query->where('mime_type', 'like', $value . '/%');
    }

}