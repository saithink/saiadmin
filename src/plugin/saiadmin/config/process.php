<?php
return [
    'task'  => [
        'handler'  => plugin\saiadmin\process\Task::class
    ],
    'websocket'  => [
        'handler'  => plugin\saiadmin\process\WebSocket::class,
        'listen'  => 'websocket://0.0.0.0:9527',
        'count'   => 1,
    ],
];
