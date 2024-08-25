<?php

use Webman\Route;

Route::group('/core', function () {

    Route::get('/captcha', [plugin\saiadmin\app\controller\LoginController::class, 'captcha']);
    Route::post('/login', [plugin\saiadmin\app\controller\LoginController::class, 'login']);

    Route::get("/system/dictData",[plugin\saiadmin\app\controller\SystemController::class, 'dictData']);
    Route::get("/system/dictAll",[plugin\saiadmin\app\controller\SystemController::class, 'dictAll']);
    Route::get('/system/user', [plugin\saiadmin\app\controller\SystemController::class, 'userInfo']);
	Route::get('/system/clearAllCache', [plugin\saiadmin\app\controller\SystemController::class, 'clearAllCache']);

    Route::get("/system/getResourceList",[plugin\saiadmin\app\controller\SystemController::class, 'getResourceList']);
    Route::post("/system/saveNetworkImage",[plugin\saiadmin\app\controller\SystemController::class, 'saveNetworkImage']);
    Route::post("/system/uploadImage",[plugin\saiadmin\app\controller\SystemController::class, 'uploadImage']);
    Route::post("/system/uploadFile",[plugin\saiadmin\app\controller\SystemController::class, 'uploadFile']);
    Route::get("/system/downloadById/{id}",[plugin\saiadmin\app\controller\SystemController::class, 'downloadById']);
    Route::get("/system/downloadByHash/{hash}",[plugin\saiadmin\app\controller\SystemController::class, 'downloadByHash']);
    Route::get("/system/getFileInfoById/{id}",[plugin\saiadmin\app\controller\SystemController::class, 'getFileInfoById']);
    Route::get("/system/getFileInfoByHash/{hash}",[plugin\saiadmin\app\controller\SystemController::class, 'getFileInfoByHash']);
    Route::get("/system/getUserList",[plugin\saiadmin\app\controller\SystemController::class, 'getUserList']);
    Route::post("/system/getUserInfoByIds",[plugin\saiadmin\app\controller\SystemController::class, 'getUserInfoByIds']);
    Route::get("/system/getLoginLogList",[plugin\saiadmin\app\controller\SystemController::class, 'getLoginLogList']);
    Route::get("/system/getOperationLogList",[plugin\saiadmin\app\controller\SystemController::class, 'getOperationLogList']);
    Route::get("/system/monitor",[plugin\saiadmin\app\controller\SystemController::class, 'getServerInfo']);
    Route::get("/system/getPlugin",[plugin\saiadmin\app\controller\SystemController::class, 'getPlugin']);

    Route::get("/logs/getLoginLogPageList",[\plugin\saiadmin\app\controller\system\SystemLogController::class, 'getLoginLogPageList']);
    Route::delete("/logs/deleteLoginLog",[\plugin\saiadmin\app\controller\system\SystemLogController::class, 'deleteLoginLog']);
    Route::get("/logs/getOperLogPageList",[\plugin\saiadmin\app\controller\system\SystemLogController::class, 'getOperLogPageList']);
    Route::delete("/logs/deleteOperLog",[\plugin\saiadmin\app\controller\system\SystemLogController::class, 'deleteOperLog']);
    Route::get("/email/index",[\plugin\saiadmin\app\controller\system\SystemMailController::class, 'index']);
    Route::delete("/email/destroy",[\plugin\saiadmin\app\controller\system\SystemMailController::class, 'destroy']);

    fastRoute('notice',\plugin\saiadmin\app\controller\system\SystemNoticeController::class);
    fastRoute('post',\plugin\saiadmin\app\controller\system\SystemPostController::class);
    Route::get("/post/accessPost",[\plugin\saiadmin\app\controller\system\SystemPostController::class, 'accessPost']);
    Route::post("/post/downloadTemplate",[plugin\saiadmin\app\controller\system\SystemPostController::class, 'downloadTemplate']);

    fastRoute('menu',\plugin\saiadmin\app\controller\system\SystemMenuController::class);
    fastRoute('dictType',\plugin\saiadmin\app\controller\system\SystemDictTypeController::class);
    fastRoute('dictData',\plugin\saiadmin\app\controller\system\SystemDictDataController::class);
    fastRoute('attachment',\plugin\saiadmin\app\controller\system\SystemUploadfileController::class);

    fastRoute('role',\plugin\saiadmin\app\controller\system\SystemRoleController::class);
    Route::get("/role/accessRole",[\plugin\saiadmin\app\controller\system\SystemRoleController::class, 'accessRole']);
    Route::get("/role/getMenuByRole/{id}",[\plugin\saiadmin\app\controller\system\SystemRoleController::class,'getMenuByRole']);
    Route::get("/role/getDeptByRole/{id}",[\plugin\saiadmin\app\controller\system\SystemRoleController::class,'getDeptByRole']);
    Route::post("/role/menuPermission/{id}",[\plugin\saiadmin\app\controller\system\SystemRoleController::class,'menuPermission']);
    Route::post("/role/dataPermission/{id}",[\plugin\saiadmin\app\controller\system\SystemRoleController::class,'dataPermission']);

    fastRoute("dept", \plugin\saiadmin\app\controller\system\SystemDeptController::class);
    Route::get("/dept/accessDept",[\plugin\saiadmin\app\controller\system\SystemDeptController::class, 'accessDept']);
    Route::get("/dept/leaders",[\plugin\saiadmin\app\controller\system\SystemDeptController::class, 'leaders']);
    Route::post("/dept/addLeader",[\plugin\saiadmin\app\controller\system\SystemDeptController::class, 'addLeader']);
    Route::delete("/dept/delLeader",[\plugin\saiadmin\app\controller\system\SystemDeptController::class, 'delLeader']);

    fastRoute("user", \plugin\saiadmin\app\controller\system\SystemUserController::class);
    Route::post("/user/updateInfo",[\plugin\saiadmin\app\controller\system\SystemUserController::class, 'updateInfo']);
    Route::post("/user/modifyPassword",[\plugin\saiadmin\app\controller\system\SystemUserController::class, 'modifyPassword']);
    Route::post("/user/clearCache",[\plugin\saiadmin\app\controller\system\SystemUserController::class, 'clearCache']);
    Route::post("/user/initUserPassword",[\plugin\saiadmin\app\controller\system\SystemUserController::class, 'initUserPassword']);
    Route::post("/user/setHomePage",[\plugin\saiadmin\app\controller\system\SystemUserController::class, 'setHomePage']);

    fastRoute('configGroup',\plugin\saiadmin\app\controller\system\SystemConfigGroupController::class);
    Route::post("/configGroup/email",[\plugin\saiadmin\app\controller\system\SystemConfigGroupController::class, 'email']);
    fastRoute('config',\plugin\saiadmin\app\controller\system\SystemConfigController::class);
    Route::post("/config/batchUpdate",[\plugin\saiadmin\app\controller\system\SystemConfigController::class, 'batchUpdate']);

    fastRoute('crontab',\plugin\saiadmin\app\controller\system\SystemCrontabController::class);
    Route::post("/crontab/run",[\plugin\saiadmin\app\controller\system\SystemCrontabController::class, 'run']);
    Route::get("/crontab/logPageList",[\plugin\saiadmin\app\controller\system\SystemCrontabController::class, 'logPageList']);
    Route::delete('/crontab/deleteCrontabLog',[\plugin\saiadmin\app\controller\system\SystemCrontabController::class, 'deleteCrontabLog']);

    Route::get("/dataMaintain/index",[plugin\saiadmin\app\controller\tool\DataMaintainController::class, 'index']);
    Route::get("/dataMaintain/dataSource",[plugin\saiadmin\app\controller\tool\DataMaintainController::class, 'source']);
    Route::get("/dataMaintain/detailed",[plugin\saiadmin\app\controller\tool\DataMaintainController::class, 'detailed']);
    Route::post("/dataMaintain/optimize",[plugin\saiadmin\app\controller\tool\DataMaintainController::class, 'optimize']);
    Route::post("/dataMaintain/fragment",[plugin\saiadmin\app\controller\tool\DataMaintainController::class, 'fragment']);

});

Route::group('/tool', function () {
    fastRoute('code',\plugin\saiadmin\app\controller\tool\GenerateTablesController::class);
    Route::post("/code/loadTable",[\plugin\saiadmin\app\controller\tool\GenerateTablesController::class, 'loadTable']);
    Route::get("/code/getTableColumns",[\plugin\saiadmin\app\controller\tool\GenerateTablesController::class, 'getTableColumns']);
    Route::get("/code/preview/{id}",[\plugin\saiadmin\app\controller\tool\GenerateTablesController::class, 'preview']);
    Route::post("/code/generate",[\plugin\saiadmin\app\controller\tool\GenerateTablesController::class, 'generate']);
    Route::post("/code/generateFile",[\plugin\saiadmin\app\controller\tool\GenerateTablesController::class, 'generateFile']);
    Route::post("/code/sync/{id}",[\plugin\saiadmin\app\controller\tool\GenerateTablesController::class, 'sync']);
});

Route::disableDefaultRoute('saiadmin');