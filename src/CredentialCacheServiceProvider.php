<?php
/**
 * Laravel Cache Adapter for AWS Credential Caching.
 *
 * @author    Luke Waite <lwaite@gmail.com>
 * @copyright 2017 Luke Waite
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 *
 * @link      https://github.com/lukewaite/laravel-aws-cache-adapter
 */

namespace LukeWaite\LaravelAwsCacheAdapter;

use Illuminate\Cache\CacheManager;
use Illuminate\Support\ServiceProvider;

class CredentialCacheServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(CacheManager $manager)
    {

        $this->publishes([
            __DIR__ . '/../config/laravel-aws-cache.php' => config_path('laravel-aws-cache.php')
        ]);

        if (config('laravel-aws-cache.enable') && !empty(config('laravel-aws-cache.filesystems'))) {
            $this->insertCredentialSetting($manager);
        }
    }

    protected function insertCredentialSetting(CacheManager $manager)
    {
        collect(explode(',', config('laravel-aws-cache.filesystems')))
            ->each(function ($filesystem) use ($manager) {
                config([
                    'filesystems.disks.' . $filesystem . '.credentials',
                    new LaravelCacheAdapter($manager, config('laravel-aws-cache.cache'), $filesystem)
                ]);
            });
    }
}
