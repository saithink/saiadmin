<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\system;

use plugin\saiadmin\basic\BaseModel;
/**
 * 附件模型
 * Class SystemUploadfile
 * @package app\model
 */
class SystemUploadfile extends BaseModel
{
    /**
     * 数据表主键
     * @var string
     */
    protected $pk = 'id';

    protected $table = 'eb_system_uploadfile';

    public function searchOriginNameAttr($query, $value)
    {
        $query->where('origin_name', 'like', '%'.$value.'%');
    }

    public function searchMimeTypeAttr($query, $value)
    {
        $query->where('mime_type', 'like', $value.'/%');
    }

}