<?php

return [
    /**
     * A comma separated list of filesystems defined in `config/filesystems.php` to which the
     * credential cache should be applied.
     */
    'filesystems' => env('LARAVEL_AWS_CACHE_FILESYSTEMS', null),

    /**
     * Whether or not to iterate through the `filesystems` defined and apply the credential cache.
     */
    'enable' => env('LARAVEL_AWS_CACHE_ENABLE', false),

    /**
     * The Laravel cache store defined in `config/cache.php` to use.
     */
    'cache' => env('LARAVEL_AWS_CACHE_CACHE', 'file')
];
