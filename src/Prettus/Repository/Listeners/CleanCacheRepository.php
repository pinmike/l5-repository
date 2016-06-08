<?php

namespace Prettus\Repository\Listeners;

use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Events\RepositoryEventBase;
use Prettus\Repository\Helpers\CacheKeys;
use Predis\Connection\Aggregate\SentinelReplication;

/**
 * Class CleanCacheRepository
 * @package Prettus\Repository\Listeners
 */
class CleanCacheRepository
{

    /**
     * @var CacheRepository
     */
    protected $cache = null;

    /**
     * @var RepositoryInterface
     */
    protected $repository = null;

    /**
     * @var Model
     */
    protected $model = null;

    /**
     * @var string
     */
    protected $action = null;

    /**
     *
     */
    public function __construct()
    {
        $this->cache = app(config('repository.cache.repository', 'cache'));
    }

    /**
     * @param RepositoryEventBase $event
     */
    public function handle(RepositoryEventBase $event)
    {
        try {
            $cleanEnabled = config("repository.cache.clean.enabled", true);

            if ($cleanEnabled) {
                $this->repository = $event->getRepository();
                $this->model = $event->getModel();
                $this->action = $event->getAction();

                if (config("repository.cache.clean.on.{$this->action}", true)) {

                	if (!config("repository.cache.clean.redis", false)) {
						//The implementation of CacheKeys uses a local file and is slow so accelerate for redis
	                    $cacheKeys = CacheKeys::getKeys(get_class($this->repository));

	                    if (is_array($cacheKeys)) {
    	                    foreach ($cacheKeys as $key) {
        	                    $this->cache->forget($key);
            	            }
                	    }
                    } else {
						$cacheId = $this->repository->getCacheId();
    	                $redisClient = $this->cache->__call('getRedis', []);
    	                $prefix = config("cache.prefix", "laravel");
                        $connection = config("cache.stores.redis.connection", "default");
                        $redis = $redisClient->connection($connection);
                        $keys = call_user_func_array([$redis, 'keys'], [$prefix.':' . $cacheId . '*']);
                        if (is_array($keys) && count($keys) > 0) {
                        	$deleteCount = call_user_func_array([$redis, 'del'], $keys);
                        }
            	    }
                }
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
