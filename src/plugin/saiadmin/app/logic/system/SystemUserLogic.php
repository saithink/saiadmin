<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\system;

use plugin\saiadmin\app\cache\UserInfoCache;
use plugin\saiadmin\app\model\system\SystemDept;
use plugin\saiadmin\app\model\system\SystemRole;
use plugin\saiadmin\app\model\system\SystemUser;
use plugin\saiadmin\exception\ApiException;
use plugin\saiadmin\basic\BaseLogic;
use Webman\Event\Event;
use Tinywan\Jwt\JwtToken;

/**
 * 用户信息逻辑层
 */
class SystemUserLogic extends BaseLogic
{

    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->model = new SystemUser();
    }

    /**
     * 读取数据
     * @param $id
     * @return array
     */
    public function read($id): array
    {
        $admin = $this->model->findOrEmpty($id);
        $data = $admin->hidden(['password'])->toArray();
        $data['roleList'] = $admin->roles->toArray() ?: [];
        $data['postList'] = $admin->posts->toArray() ?: [];
        $data['deptList'] = $admin->depts ? $admin->depts->toArray() : [];
        if ($this->adminInfo['id'] > 1) {
            // 判断部门id是否有操作权限
            $dept_ids = SystemDept::whereRaw('FIND_IN_SET("'.$this->adminInfo['dept_id'].'", level) > 0')->column('id');
            if (!in_array($admin['dept_id'], $dept_ids)) {
                throw new ApiException('没有权限操作该部门数据');
            }
        }
        return $data;
    }

    /**
     * 添加数据
     * @param $data
     * @return mixed
     */
    public function add($data): mixed
    {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->transaction(function () use ($data) {
            $role_ids = $data['role_ids'] ?? [];
            $post_ids = $data['post_ids'] ?? [];
            if ($this->adminInfo['id'] > 1) {
                // 1、判断部门id是否有操作权限
                $dept_ids = SystemDept::whereRaw('FIND_IN_SET("' . $this->adminInfo['dept_id'] . '", level) > 0')->column('id');
                if (!in_array($data['dept_id'], $dept_ids)) {
                    throw new ApiException('没有权限操作该部门数据');
                }
                // 2、判断角色id是否有操作权限
                $roleIds = [];
                foreach ($this->adminInfo['roleList'] as $item) {
                    $temp = SystemRole::whereRaw('FIND_IN_SET("' . $item['id'] . '", level) > 0')->column('id');
                    $roleIds = array_merge($roleIds, $temp);
                }
                if (count(array_diff($role_ids, $roleIds)) > 0) {
                    throw new ApiException('没有权限操作该角色数据');
                }
            }
            $user = SystemUser::create($data);
            $user->roles()->detach();
            $user->posts()->detach();
            $user->roles()->saveAll($role_ids);
            if (!empty($post_ids)) {
                $user->posts()->save($post_ids);
            }
            return $user->getKey();
        });
    }

    /**
     * 修改数据
     * @param $id
     * @param $data
     * @return mixed
     */
    public function edit($id, $data): mixed
    {
        unset($data['password']);
        return $this->transaction(function () use ($data, $id) {
            $role_ids = $data['role_ids'] ?? [];
            $post_ids = $data['post_ids'] ?? [];
            // 1、判断用户是否可以操作
            $query = $this->model->where('id', $id);
            $query->auth([
                'id' => $this->adminInfo['id'],
                'dept' => $this->adminInfo['deptList']
            ]);
            $user = $query->findOrEmpty();
            if ($user->isEmpty()) {
                throw new ApiException('没有权限操作该数据');
            }
            if ($this->adminInfo['id'] > 1) {
                // 2、判断部门id是否有操作权限
                $dept_ids = SystemDept::whereRaw('FIND_IN_SET("' . $this->adminInfo['dept_id'] . '", level) > 0')->column('id');
                if (!in_array($data['dept_id'], $dept_ids)) {
                    throw new ApiException('没有权限操作该部门数据');
                }
                // 3、判断角色id是否有操作权限
                $roleIds = [];
                foreach ($this->adminInfo['roleList'] as $item) {
                    $temp = SystemRole::whereRaw('FIND_IN_SET("' . $item['id'] . '", level) > 0')->column('id');
                    $roleIds = array_merge($roleIds, $temp);
                }
                if (count(array_diff($role_ids, $roleIds)) > 0) {
                    throw new ApiException('没有权限操作该角色数据');
                }
            }
            $result = parent::edit($id, $data);
            if ($result) {
                $user->roles()->detach();
                $user->posts()->detach();
                $user->roles()->saveAll($role_ids);
                if (!empty($post_ids)) {
                    $user->posts()->save($post_ids);
                }
                $userInfoCache = new UserInfoCache($id);
                $userInfoCache->clearUserInfo();
            }
            return $result;
        });
    }

    /**
     * 删除数据
     * @param $ids
     */
    public function destroy($ids)
    {
        if (is_array($ids)) {
            if (count($ids) > 1) {
                throw new ApiException('禁止批量删除操作');
            }
            $ids = $ids[0];
        }
        if ($ids == 1) {
            throw new ApiException('超级管理员禁止删除');
        }
        $query = $this->model->where('id', $ids);
        $query->auth([
            'id' => $this->adminInfo['id'],
            'dept' => $this->adminInfo['deptList']
        ]);
        $user = $query->findOrEmpty();
        if ($user->isEmpty()) {
            throw new ApiException('没有权限操作该数据');
        }
        $userInfoCache = new UserInfoCache($ids);
        $userInfoCache->clearUserInfo();
        parent::destroy($ids);
    }

    /**
     * 用户登录
     * @param string $username
     * @param string $password
     * @param string $type
     * @return array
     */
    public function login(string $username, string $password, string $type): array
    {
        $adminInfo = $this->model->where('username', $username)->findOrEmpty();
        $status = 1;
        $message = '登录成功';
        if ($adminInfo->isEmpty()) {
            $message = '账号或密码错误，请重新输入!';
            throw new ApiException($message);
        }
        if ($adminInfo->status === 2) {
            $status = 0;
            $message = '您已被禁止登录!';
        }
        if (!password_verify($password, $adminInfo->password)) {
            $status = 0;
            $message = '账号或密码错误，请重新输入!';
        }
        if ($status === 0) {
            // 登录事件
            Event::emit('user.login', compact('username','status','message'));
            throw new ApiException($message);
        }
        $adminInfo->login_time = date('Y-m-d H:i:s');
        $adminInfo->login_ip = request()->getRealIp();
        $adminInfo->save();

        $token = JwtToken::generateToken([
            'id' => $adminInfo->id,
            'username' => $adminInfo->username,
            'type' => $type
        ]);
        // 登录事件
        $admin_id = $adminInfo->id;
        Event::emit('user.login', compact('username','status','message','admin_id'));
        return $token;
    }

    /**
     * 密码修改
     * @param $adminId
     * @param $oldPassword
     * @param $newPassword
     * @return bool
     */
    public function modifyPassword($adminId, $oldPassword, $newPassword): bool
    {
        $model = $this->model->findOrEmpty($adminId);
        if (password_verify($oldPassword, $model->password)) {
            $model->password = password_hash($newPassword, PASSWORD_DEFAULT);
            return $model->save();
        } else {
            throw new ApiException('原密码错误');
        }
    }

    /**
     * 修改数据
     */
    public function authEdit($id, $data)
    {
        if ($this->adminInfo['id'] > 1) {
            // 判断用户是否可以操作
            $query = SystemUser::where('id', $id);
            $query->auth([
                'id' => $this->adminInfo['id'],
                'dept' => $this->adminInfo['deptList']
            ]);
            $user = $query->findOrEmpty();
            if ($user->isEmpty()) {
                throw new ApiException('没有权限操作该数据');
            }
        }
        parent::edit($id, $data);
    }

}
