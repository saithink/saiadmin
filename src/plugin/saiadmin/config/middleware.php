<?php

use plugin\saiadmin\app\middleware\SystemLog;
use plugin\saiadmin\app\middleware\CheckLogin;
use plugin\saiadmin\app\middleware\CheckAuth;

return [
    '' => [
        CheckLogin::class,
        CheckAuth::class,
        SystemLog::class,
    ]
];
