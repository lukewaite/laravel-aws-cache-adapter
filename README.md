# laravel-aws-cache-adapter
> Provides an `Aws\CacheInterface\CacheInterface` compliant cache for the
AWS SDK which uses the laravel Cache classes.

### Purpose
When using EC2 Instance IAM Roles or ECS Task IAM Roles the AWS php sdk automatically performs
lookups against the ec2 metadata api (169.254.169.254) to get credentials. These by default
are not cached, and can occasionally be a source of trouble or slowdowns if the metadata api
is slow/not responding.

This package allows you to configure certain laravel filesystems to be automatically loaded
with a `CacheInterface` that will use a laravel cache store to cache the STS tokens returned,
reducing requests to the metadata api.


# Usage

### Direct Usage of the Adapter
The `LaravelCacheAdapter` can be passed directly in to Flysystem your `config/filesystems.php`
```
    's3' => [
        'driver'      => 's3',
        'base-path'   => 'https://s3.amazonaws.com',
        'credentials' => new LaravelCacheAdapter(app('cache'))
        'bucket'      => env('AWS_BUCKET'),
        'region'      => env('AWS_REGION', 'us-east-1'),
    ],
```

### Auto Insertion of the CredentialProvider via ServiceProvider
The default configuration settings are in `/config/laravel-aws-cache.php`. Copy this file to your
own config directory to modify the values. You can publish this config using this command:
```
$ php artisan vendor:publish --provider="LukeWaite\LaravelAwsCacheAdapter\ServiceProvider"
```

#### Configuration
```
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
```
