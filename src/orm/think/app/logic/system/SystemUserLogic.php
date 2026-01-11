<?php
// +----------------------------------------------------------------------
// | saiadmin [ saiadmin快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\system;

use plugin\saiadmin\app\cache\UserAuthCache;
use plugin\saiadmin\app\cache\UserInfoCache;
use plugin\saiadmin\app\cache\UserMenuCache;
use plugin\saiadmin\app\model\system\SystemDept;
use plugin\saiadmin\app\model\system\SystemRole;
use plugin\saiadmin\app\model\system\SystemUser;
use plugin\saiadmin\exception\ApiException;
use plugin\saiadmin\basic\think\BaseLogic;
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
     * 分页数据列表
     * @param mixed $where
     * @return array
     */
    public function indexList($where): array
    {
        $query = $this->search($where);
        $query->with(['depts']);
        $query->auth($this->adminInfo['deptList']);
        return $this->getList($query);
    }

    /**
     * 用户列表数据
     * @param mixed $where
     * @return array
     */
    public function openUserList($where): array
    {
        $query = $this->search($where);
        $query->field('id, username, realname, avatar, phone, email');
        return $this->getList($query);
    }

    /**
     * 读取用户信息
     * @param mixed $id
     * @return array
     */
    public function getUser($id): array
    {
        $admin = $this->model->findOrEmpty($id);
        $data = $admin->hidden(['password'])->toArray();
        $data['roleList'] = $admin->roles->toArray() ?: [];
        $data['postList'] = $admin->posts->toArray() ?: [];
        $data['deptList'] = $admin->depts ? $admin->depts->toArray() : [];
        return $data;
    }

    /**
     * 读取数据
     * @param $id
     * @return array
     */
    public function read($id): array
    {
        $data = $this->getUser($id);
        if ($this->adminInfo['id'] > 1) {
            // 部门保护
            if (!$this->deptProtect($this->adminInfo['deptList'], $data['dept_id'])) {
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
                // 部门保护
                if (!$this->deptProtect($this->adminInfo['deptList'], $data['dept_id'])) {
                    throw new ApiException('没有权限操作该部门数据');
                }
                // 越权保护
                if (!$this->roleProtect($this->adminInfo['roleList'], $role_ids)) {
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
            return $user;
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
            // 仅可修改当前部门和子部门的用户
            $query = $this->model->where('id', $id);
            $query->auth($this->adminInfo['deptList']);
            $user = $query->findOrEmpty();
            if ($user->isEmpty()) {
                throw new ApiException('没有权限操作该数据');
            }
            if ($this->adminInfo['id'] > 1) {
                // 部门保护
                if (!$this->deptProtect($this->adminInfo['deptList'], $data['dept_id'])) {
                    throw new ApiException('没有权限操作该部门数据');
                }
                // 越权保护
                if (!$this->roleProtect($this->adminInfo['roleList'], $role_ids)) {
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
                UserInfoCache::clearUserInfo($id);
                UserAuthCache::clearUserAuth($id);
                UserMenuCache::clearUserMenu($id);
            }
            return $result;
        });
    }

    /**
     * 删除数据
     * @param $ids
     * @return bool
     */
    public function destroy($ids): bool
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
        $query->auth($this->adminInfo['deptList']);
        $user = $query->findOrEmpty();
        if ($user->isEmpty()) {
            throw new ApiException('没有权限操作该数据');
        }
        if ($this->adminInfo['id'] > 1) {
            $role_ids = $user->roles->toArray() ?: [];
            if (!empty($role_ids)) {
                // 越权保护
                if (!$this->roleProtect($this->adminInfo['roleList'], array_column($role_ids, 'id'))) {
                    throw new ApiException('没有权限操作该角色数据');
                }
            }
        }
        UserInfoCache::clearUserInfo($ids);
        UserAuthCache::clearUserAuth($ids);
        UserMenuCache::clearUserMenu($ids);
        return parent::destroy($ids);
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
            Event::emit('user.login', compact('username', 'status', 'message'));
            throw new ApiException($message);
        }
        $adminInfo->login_time = date('Y-m-d H:i:s');
        $adminInfo->login_ip = request()->getRealIp();
        $adminInfo->save();

        $access_exp = config('plugin.saiadmin.saithink.access_exp', 3 * 3600);
        $token = JwtToken::generateToken([
            'access_exp' => $access_exp,
            'id' => $adminInfo->id,
            'username' => $adminInfo->username,
            'type' => $type,
            'plat' => 'saiadmin',
        ]);
        // 登录事件
        $admin_id = $adminInfo->id;
        Event::emit('user.login', compact('username', 'status', 'message', 'admin_id'));
        return $token;
    }

    /**
     * 更新资料
     * @param mixed $id
     * @param mixed $data
     * @return bool
     */
    public function updateInfo($id, $data): bool
    {
        $this->model->update($data, ['id' => $id], ['realname', 'gender', 'phone', 'email', 'avatar', 'signed']);
        return true;
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
            $query->auth($this->adminInfo['deptList']);
            $user = $query->findOrEmpty();
            if ($user->isEmpty()) {
                throw new ApiException('没有权限操作该数据');
            }
        }
        parent::edit($id, $data);
    }

    /**
     * 部门保护
     * @param $dept
     * @param $dept_id
     * @return bool
     */
    public function deptProtect($dept, $dept_id): bool
    {
        // 部门保护
        $deptIds = [$dept['id']];
        $deptLevel = $dept['level'] . $dept['id'] . ',';
        $dept_ids = SystemDept::whereLike('level', $deptLevel . '%')->column('id');
        $deptIds = array_merge($deptIds, $dept_ids);
        if (!in_array($dept_id, $deptIds)) {
            return false;
        }
        return true;
    }

    /**
     * 越权保护
     * @param $roleList
     * @param $role_ids
     * @return bool
     */
    public function roleProtect($roleList, $role_ids): bool
    {
        // 越权保护
        $levelArr = array_column($roleList, 'level');
        $maxLevel = max($levelArr);
        $currentLevel = SystemRole::whereIn('id', $role_ids)->max('level');
        if ($currentLevel >= $maxLevel) {
            return false;
        }
        return true;
    }

}
