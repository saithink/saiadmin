<?php
return [
    'user.login' => [
        [plugin\saiadmin\app\event\SystemUser::class, 'login'],
    ],
    'user.operateLog' => [
        [plugin\saiadmin\app\event\SystemUser::class, 'operateLog'],
    ]
];