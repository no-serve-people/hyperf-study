<?php
return [
    'consumers' => [
        [
            // 对应消费者类的 $serviceName
            'name'     => 'CaculatorService',
            // 这个消费者要从哪获取节点信息
            'registry' => [
                'protocol' => 'consul',
                'address'  => 'http://127.0.0.1:8500',
            ],
        ]
    ],
];