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

use Aws\CacheInterface;
use Illuminate\Cache\CacheManager;

class LaravelCacheAdapter implements CacheInterface
{
    /**
     * @var string
     */
    private $prefix;

    /**
     * @var string
     */
    private $store;

    /**
     * @var CacheManager
     */
    private $manager;

    public function __construct(CacheManager $manager, $store, $prefix = null)
    {
        $this->manager = $manager;
        $this->store = $store;
        $this->prefix = 'aws_credentials_' . $prefix;
    }

    /**
     * @inheritdoc
     */
    public function get($key)
    {
        return $this->getCache()->get($this->generateKey($key));
    }

    /**
     * @inheritdoc
     */
    public function remove($key)
    {
        $this->getCache()->forget($this->generateKey($key));
    }

    /**
     * @inheritdoc
     */
    public function set($key, $value, $ttl = 0)
    {
        $this->getCache()->put($this->generateKey($key), $value, $ttl);
    }

    /**
     * Generate a cache key which incorporates the prefix.
     *
     * @param $key
     * @return string
     */
    protected function generateKey($key)
    {
        return $this->prefix . $key;
    }

    /**
     * Returns the configured Laravel Cache Store
     *
     * @return mixed
     */
    protected function getCache()
    {
        return $this->manager->store($this->store);
    }
}
