<?php

namespace App\Repositories\Weather;

use App\Repositories\CacheAble as CacheAble;
use App\WeatherForeCastResource as Resource;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Config\Repository as Config;
use App\Contracts\Weather\Repository\IForecastResource;

/**
 * Weather ForeCast Resource Repository
 */
class ForecastResource extends CacheAble implements IForecastResource
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
         * @param \App\WeatherForeCastResource
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
        
        /**
         * To get models from cache drive
         * 
         * return \Illuminate\Database\Eloquent\Collection|static[]
         */
        public function onCache()
        {
            list($key, $minitues) = $this->getCachingParameters();
          
            return $this->getCache()->remember($key, $minitues, function() {
               
                return $this->onModel()->enable()->priority()->get();
            }); 
        }     
        
        /**
         * To find model by primary key
         * 
         * @param int $id
         * @return \App\WeatherForeCastResource|null
         */
        public function find($id)
        {
            return $this->onModel()->newQuery()->find($id);    
        }
        
        /**
         * To find model by primary key
         * 
         * @param string $name
         * @return \App\WeatherForeCastResource|null
         */
        public function findByName($name)
        {
            return $this->onModel()->ofName($name)->first();             
        }
}