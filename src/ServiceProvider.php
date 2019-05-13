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
use Illuminate\Config\Repository;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
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
     * @param CacheManager $manager
     * @param Repository $config
     * @return void
     */
    public function boot(CacheManager $manager, Repository $config)
    {
        $this->publishes([
            __DIR__ . '/../config/laravel-aws-cache.php' => config_path('laravel-aws-cache.php')
        ]);

        if (config('laravel-aws-cache.enable')) {
            $this->insertCredentialSetting($manager, $config);
        }
    }

    protected function insertCredentialSetting(CacheManager $manager, Repository $config)
    {
        if (!empty(config('laravel-aws-cache.filesystems'))) {
            collect(explode(',', config('laravel-aws-cache.filesystems')))
                ->each(function ($filesystem) use ($manager, $config) {
                    $config->set([
                        'filesystems.disks.' . $filesystem . '.credentials' =>
                            new LaravelCacheAdapter($manager, config('laravel-aws-cache.cache'))
                    ]);
                });
        }

        if (!empty(config('laravel-aws-cache.queues'))) {
            collect(explode(',', config('laravel-aws-cache.queues')))
                ->each(function ($queue) use ($manager, $config) {
                    $config->set([
                        'queue.connections.' . $queue . '.credentials' =>
                            new LaravelCacheAdapter($manager, config('laravel-aws-cache.cache'))
                    ]);
                });
        }
    }
}
