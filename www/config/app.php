<?php

return [
    //0关闭调试 1打开调试 2打印部分调试信息 3 打印全部调试信息
    'debug' => 0,

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY', 'YUNFRAMEWORK_APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */
    'lang' => 'en',
    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */
    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),
    'domain' => 'DayTradingNotes.com',
    'file_version' => date('Ymd',time()),
    'gzip' => true,
    //URL格式 （PATH_INFO，NATIVE）
    'url_format' => 'PATH_INFO',
    'config' => [
        'config1'=>1,
        'config2'=>[
            'config3'=>'RANDOM STRING',
            'config4'=>'config4',
        ],
    ],
    //资源文件配置
    'resource' =>[
        'type'=>'host',//host,local
        'host'=>'http://www.yun.org/',
    ],
];
