<?php

namespace App\Repositories\Weather;

use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Config\Repository as Config;
use App\WeatherForeCastResource as Resource;



/**
 * Weather ForeCast Resource Repository
 */
class ForecastResourceRepository extends CacheAbleRepository
{
    
    /**
     * @var \App\WeatherForeCastResource 
     */
    private $resource;
        
        /**
         * Create a new Instance
         * 
         * @param \Illuminate\Contracts\Cache\Repository    $cache
         * @param \Illuminate\Contracts\Config\Repository   $config
         */
        public function __construct(Cache $cache, Config $config, Resource $resource)
        {   
            parent::__construct($cache, $config);
            
            $this->resource     = $resource;               
        }
        
        /**
         * To get main model which is injected
         * 
         * @return \App\WeatherForeCastResource
         */
        public function onModel()
        {
            return $this->resource;
        }
    
    
    
}
