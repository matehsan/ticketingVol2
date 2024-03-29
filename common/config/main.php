<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'jdate' => [
            'class' => 'jDate\DateTime'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
