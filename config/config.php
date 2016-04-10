<?php

return [
    'di' => [
        \Example\Controller\IndexController::class => [
            'inject' => [
                \Example\Model\IndexModel::class
            ]
        ],
        \Example\Model\IndexModel::class => [
            'inject' => [
                \Example\Storage\CsvFileStorage::class
            ]
        ],
        \Example\Storage\CsvFileStorage::class => [
            'inject' => [
                ['file' => 'data/example.csv']
            ]
        ]
    ]
];
