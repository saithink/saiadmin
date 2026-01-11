<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\model\system;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * 用户岗位关联模型
 *
 * sa_system_user_post 用户与岗位关联表
 *
 * @property  $id 主键
 * @property  $user_id 用户主键
 * @property  $post_id 岗位主键
 */
class SystemUserPost extends Pivot
{
    protected $primaryKey = 'id';

    protected $table = 'sa_system_user_post';
}