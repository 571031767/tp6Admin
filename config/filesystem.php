<?php

return [
    'default' =>  'local',
    'disks'   => [
        'local'  => [
            'type' => 'local',
            'root'   => app()->getRuntimePath() . 'storage',
        ],
        'public' => [
            'type'     => 'local',
            'root'       => app()->getRootPath() . 'public/storage',
            'url'        => '/storage',
            'visibility' => 'public',
        ],
        // 更多的磁盘配置信息
    ],
];