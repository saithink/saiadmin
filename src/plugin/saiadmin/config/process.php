<?php
return [
    'task'  => [
        'handler'  => plugin\saiadmin\process\Task::class
    ],
    // 异步任务处理定时进程
    'async'  => [
        'handler' => plugin\saiadmin\process\Async::class,
        'listen'  => 'text://127.0.0.1:8900', // 这里用了text协议，也可以用frame或其它协议
        'count'   => 4, // 可以设置多进程
        'reusePort' => true, // 平均分配进程
    ]
];
