<?php

namespace App\Repositories;

use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Config\Repository as Config;

/**
 * Weather ForeCast Resource Repository
 */
abstract class CacheAbleRepository
{    
    /**
     * @var \Illuminate\Contracts\Cache\Repository 
     */
    private $cache;
    
    /**
     * @var \Illuminate\Contracts\Config\Repository
     */
    private $config;     
    
    /**
     * Cache Duration. 
     * Time unit is minute.
     *
     * @var int 
     */
    private $cacheDuration;
    
    /**
     * Cache enable
     *  
     * @var bool 
     */
    private $cacheEnable = false;
        
        /**
         * Create a new Instance
         * 
         * @param \Illuminate\Contracts\Cache\Repository    $cache
         * @param \Illuminate\Contracts\Config\Repository   $config
         */
        public function __construct(Cache $cache, Config $config)
        {            
            $this->cache        = $cache;
            
            $this->config       = $config;     
            
            $this->cacheDuration= $config->get('cache.duration', 30);
        }
        
        /**
        * To get hashed keys by using class name of given object
        * 
        * @param Object $object
        * @return string   hashed class name
        * @throws Exception
        */
        final protected function makeUniqueKey($object) 
        {                       
            return createUniqueKeyFromObj($object);            
        }
        
       /**
         * Getter for remember time
         * 
         * @return int
         */
        final private function getRememberTime() {
            
            $time  = $this->cacheDuration;
            
            return is_null($time) ? 5 : $time;
        }
        
        /**
         * To get caching parameter
         * 
         * @return array   first one is key, other one is time
         */
        final protected function getCachingParameters() 
        {            
            $model      = $this->onModel();
            
            $key        = $this->makeUniqueKey($model);
            
            $minitues   = $this->getRememberTime();
            
            return [$key, $minitues];
        }  
        
        /**
         * To get main model which is injected
         * 
         * @return \Illuminate\Database\Eloquent\Model
         */
        abstract public function onModel();  
        
        /**
         * To get all models from cache drive
         * 
         * return \Illuminate\Database\Eloquent\Collection|static[]
         */
        abstract public function onCache();      
        
        /**
         * To set enable caching
         * 
         * @return \App\Repositories\Weather\CacheAbleRepository
         */
        final public function enableCache()
        {
            $this->cacheEnable = true;
            
            return $this;            
        }
        
        /**
         * To set disable caching
         * 
         * @return \App\Repositories\Weather\CacheAbleRepository
         */
        final public function disableCache()
        {
            $this->cacheEnable = false;
            
            return $this;            
        }
        
        /**
         * Determine if caching is enable
         * 
         * @return bool
         */
        final public function isEnabledCache()
        {
            return (boolean) $this->cacheEnable;
        }    
        
        /**
         * To get all models
         * 
         * @param bool $cache
         * @return \Illuminate\Database\Eloquent\Collection|static[]
         */
        abstract public function all();     
        
        /**
         * To get cache repository
         * 
         * @return \Illuminate\Contracts\Cache\Repository
         */
        final public function getCache()
        {
            return $this->cache;            
        }
}