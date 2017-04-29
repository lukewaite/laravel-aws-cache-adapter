<?php

return [
    'filesystems' => env('LARAVEL_AWS_CACHE_FILESYSTEMS', null),
    'enable' => env('LARAVEL_AWS_CACHE_ENABLE', false),
    'cache' => env('LARAVEL_AWS_CACHE_CACHE', 'file')
];
