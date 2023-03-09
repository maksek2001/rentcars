<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'yscMAfCXA6VQV5C8R4eWRG4nYfCHWYBU',
        ],
    ],
];

// if (!YII_ENV_TEST) {
//     // configuration adjustments for 'dev' environment
//     $config['bootstrap'][] = 'debug';
//     $config['modules']['debug'] = [
//         'class' => \yii\debug\Module::class,
//     ];
// }

return $config;
