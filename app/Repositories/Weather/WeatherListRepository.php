<?php

namespace App\Repositories\Weather;

//use App\WeatherHourlyStat as Hourly;
//use App\WeatherCondition as Condition; 
//use App\Libs\Weather\DataType\WeatherDataAble;
use App\Repositories\CacheAbleRepository as CacheAble;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Config\Repository as Config;
//use ErrorException;

/**
 * Weather Hourly Stats Repository Class
 * 
 * @package WeatherForcast
 */
class WeatherListRepository extends CacheAble
{    
    /**
     * @var \App\WeatherList
     */
    private $mainModel;    
    
        /**
         * Create new Instance
         * 
         * @param \Illuminate\Contracts\Cache\Repository $cache
         * @param \Illuminate\Contracts\Config\Repository $config
         */
        public function __construct(Cache $cache, Config $config)
        {
            parent::__construct($cache, $config);
        }    
    
        /**
         * To get main model which is injected
         * 
         * @return \Illuminate\Database\Eloquent\Model
         */
        public function onModel()
        {
            
        }
        
        /**
         * To get all models from cache drive
         * 
         * return \Illuminate\Database\Eloquent\Collection|static[]
         */
        public function onCache()
        {
            
        }
        
        
        
        /**
         * To get all models
         * 
         * @param bool $cache
         * @return \Illuminate\Database\Eloquent\Collection|static[]
         */
        public function all()
        {
            
        }
        
}