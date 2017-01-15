<?php

return [
    '/callback' => '/callback/detect',
    '/callback-url' => '/callback/detect',
//    '/<controller>/<action>'=>'/<controller>/<action>',
    '/<module>/<controller>/<action>' => '/<module>/<controller>/<action>',
    //
    '/<module>/<characterID:\d+>' => '/<module>/index/index',
    '/<module>/<characterID:\d+>/<controller>/<action>' => '/<module>/<controller>/<action>',
    '/<module1>/<characterID:\d+>/<module2>/<controller>/<action>' => '/<module1>/<module2>/<controller>/<action>'
];