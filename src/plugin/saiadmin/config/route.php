<?php

use Webman\Route;

Route::group('/core', function () {

    Route::get('/install', [plugin\saiadmin\app\controller\InstallController::class, 'index']);
    Route::post('/install/install', [plugin\saiadmin\app\controller\InstallController::class, 'install']);

    Route::get('/captcha', [plugin\saiadmin\app\controller\LoginController::class, 'captcha']);
    Route::post('/login', [plugin\saiadmin\app\controller\LoginController::class, 'login']);

    Route::get("/system/dictAll",[plugin\saiadmin\app\controller\SystemController::class, 'dictAll']);
    Route::get('/system/user', [plugin\saiadmin\app\controller\SystemController::class, 'userInfo']);
    Route::get('/system/statistics', [plugin\saiadmin\app\controller\SystemController::class, 'statistics']);
    Route::get('/system/loginChart', [plugin\saiadmin\app\controller\SystemController::class, 'loginChart']);
    Route::get('/system/notice', [plugin\saiadmin\app\controller\SystemController::class, 'systemNotice']);
	Route::get('/system/clearAllCache', [plugin\saiadmin\app\controller\SystemController::class, 'clearAllCache']);

    Route::get("/system/getResourceList",[plugin\saiadmin\app\controller\SystemController::class, 'getResourceList']);
    Route::post("/system/saveNetworkImage",[plugin\saiadmin\app\controller\SystemController::class, 'saveNetworkImage']);
    Route::post("/system/uploadImage",[plugin\saiadmin\app\controller\SystemController::class, 'uploadImage']);
    Route::post("/system/uploadFile",[plugin\saiadmin\app\controller\SystemController::class, 'uploadFile']);
    Route::get("/system/downloadById",[plugin\saiadmin\app\controller\SystemController::class, 'downloadById']);
    Route::get("/system/downloadByHash",[plugin\saiadmin\app\controller\SystemController::class, 'downloadByHash']);
    Route::get("/system/getUserList",[plugin\saiadmin\app\controller\SystemController::class, 'getUserList']);
    Route::post("/system/getUserInfoByIds",[plugin\saiadmin\app\controller\SystemController::class, 'getUserInfoByIds']);
    Route::get("/system/getLoginLogList",[plugin\saiadmin\app\controller\SystemController::class, 'getLoginLogList']);
    Route::get("/system/getOperationLogList",[plugin\saiadmin\app\controller\SystemController::class, 'getOperationLogList']);

    // 用户管理
    fastRoute("user", \plugin\saiadmin\app\controller\system\SystemUserController::class);
    Route::post("/user/updateInfo",[\plugin\saiadmin\app\controller\system\SystemUserController::class, 'updateInfo']);
    Route::post("/user/modifyPassword",[\plugin\saiadmin\app\controller\system\SystemUserController::class, 'modifyPassword']);
    Route::post("/user/clearCache",[\plugin\saiadmin\app\controller\system\SystemUserController::class, 'clearCache']);
    Route::post("/user/initUserPassword",[\plugin\saiadmin\app\controller\system\SystemUserController::class, 'initUserPassword']);
    Route::post("/user/setHomePage",[\plugin\saiadmin\app\controller\system\SystemUserController::class, 'setHomePage']);

    // 角色管理
    fastRoute('role',\plugin\saiadmin\app\controller\system\SystemRoleController::class);
    Route::get("/role/accessRole",[\plugin\saiadmin\app\controller\system\SystemRoleController::class, 'accessRole']);
    Route::get("/role/getMenuByRole",[\plugin\saiadmin\app\controller\system\SystemRoleController::class,'getMenuByRole']);
    Route::post("/role/menuPermission",[\plugin\saiadmin\app\controller\system\SystemRoleController::class,'menuPermission']);

    // 部门管理
    fastRoute("dept", \plugin\saiadmin\app\controller\system\SystemDeptController::class);
    Route::get("/dept/accessDept",[\plugin\saiadmin\app\controller\system\SystemDeptController::class, 'accessDept']);
    Route::get("/dept/leaders",[\plugin\saiadmin\app\controller\system\SystemDeptController::class, 'leaders']);
    Route::post("/dept/addLeader",[\plugin\saiadmin\app\controller\system\SystemDeptController::class, 'addLeader']);
    Route::delete("/dept/delLeader",[\plugin\saiadmin\app\controller\system\SystemDeptController::class, 'delLeader']);

    // 岗位管理
    fastRoute('post',\plugin\saiadmin\app\controller\system\SystemPostController::class);
    Route::get("/post/accessPost",[\plugin\saiadmin\app\controller\system\SystemPostController::class, 'accessPost']);
    Route::post("/post/downloadTemplate",[plugin\saiadmin\app\controller\system\SystemPostController::class, 'downloadTemplate']);

    // 菜单管理
    fastRoute('menu',\plugin\saiadmin\app\controller\system\SystemMenuController::class);
    Route::get("/menu/accessMenu",[\plugin\saiadmin\app\controller\system\SystemMenuController::class, 'accessMenu']);
    // 字典类型管理
    fastRoute('dictType',\plugin\saiadmin\app\controller\system\SystemDictTypeController::class);
    // 字典数据管理
    fastRoute('dictData',\plugin\saiadmin\app\controller\system\SystemDictDataController::class);
    // 附件管理
    fastRoute('attachment',\plugin\saiadmin\app\controller\system\SystemAttachmentController::class);
    // 通知公告
    fastRoute('notice',\plugin\saiadmin\app\controller\system\SystemNoticeController::class);

    // 系统设置
    fastRoute('configGroup',\plugin\saiadmin\app\controller\system\SystemConfigGroupController::class);
    Route::post("/configGroup/email",[\plugin\saiadmin\app\controller\system\SystemConfigGroupController::class, 'email']);
    fastRoute('config',\plugin\saiadmin\app\controller\system\SystemConfigController::class);
    Route::post("/config/batchUpdate",[\plugin\saiadmin\app\controller\system\SystemConfigController::class, 'batchUpdate']);

    // 日志管理
    Route::get("/system/monitor",[plugin\saiadmin\app\controller\SystemController::class, 'getServerInfo']);
    Route::get("/logs/getLoginLogPageList",[\plugin\saiadmin\app\controller\system\SystemLogController::class, 'getLoginLogPageList']);
    Route::delete("/logs/deleteLoginLog",[\plugin\saiadmin\app\controller\system\SystemLogController::class, 'deleteLoginLog']);
    Route::get("/logs/getOperLogPageList",[\plugin\saiadmin\app\controller\system\SystemLogController::class, 'getOperLogPageList']);
    Route::delete("/logs/deleteOperLog",[\plugin\saiadmin\app\controller\system\SystemLogController::class, 'deleteOperLog']);
    Route::get("/email/index",[\plugin\saiadmin\app\controller\system\SystemMailController::class, 'index']);
    Route::delete("/email/destroy",[\plugin\saiadmin\app\controller\system\SystemMailController::class, 'destroy']);

    // 数据表维护
    Route::get("/database/index",[\plugin\saiadmin\app\controller\system\DataBaseController::class, 'index']);
    Route::get("/database/recycle",[\plugin\saiadmin\app\controller\system\DataBaseController::class, 'recycle']);
    Route::delete("/database/delete",[\plugin\saiadmin\app\controller\system\DataBaseController::class, 'delete']);
    Route::post("/database/recovery",[\plugin\saiadmin\app\controller\system\DataBaseController::class, 'recovery']);
    Route::get("/database/dataSource",[\plugin\saiadmin\app\controller\system\DataBaseController::class, 'source']);
    Route::get("/database/detailed",[\plugin\saiadmin\app\controller\system\DataBaseController::class, 'detailed']);
    Route::post("/database/optimize",[\plugin\saiadmin\app\controller\system\DataBaseController::class, 'optimize']);
    Route::post("/database/fragment",[\plugin\saiadmin\app\controller\system\DataBaseController::class, 'fragment']);

});

Route::group('/tool', function () {

    // 定时任务
    fastRoute('crontab', \plugin\saiadmin\app\controller\tool\CrontabController::class);
    Route::post("/crontab/run",[\plugin\saiadmin\app\controller\tool\CrontabController::class, 'run']);
    Route::get("/crontab/logPageList",[\plugin\saiadmin\app\controller\tool\CrontabController::class, 'logPageList']);
    Route::delete('/crontab/deleteCrontabLog',[\plugin\saiadmin\app\controller\tool\CrontabController::class, 'deleteCrontabLog']);

    // 代码生成
    fastRoute('code',\plugin\saiadmin\app\controller\tool\GenerateTablesController::class);
    Route::post("/code/loadTable",[\plugin\saiadmin\app\controller\tool\GenerateTablesController::class, 'loadTable']);
    Route::get("/code/getTableColumns",[\plugin\saiadmin\app\controller\tool\GenerateTablesController::class, 'getTableColumns']);
    Route::get("/code/preview",[\plugin\saiadmin\app\controller\tool\GenerateTablesController::class, 'preview']);
    Route::post("/code/generate",[\plugin\saiadmin\app\controller\tool\GenerateTablesController::class, 'generate']);
    Route::post("/code/generateFile",[\plugin\saiadmin\app\controller\tool\GenerateTablesController::class, 'generateFile']);
    Route::post("/code/sync",[\plugin\saiadmin\app\controller\tool\GenerateTablesController::class, 'sync']);
});

Route::disableDefaultRoute('saiadmin');