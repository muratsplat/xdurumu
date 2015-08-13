<?php

namespace App\Repositories\Weather;

//use App\WeatherHourlyStat as Hourly;
//use App\WeatherCondition as Condition; 
//use App\Libs\Weather\DataType\WeatherDataAble;
use App\WeatherList;
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
         * @param \App\WeatherList; 
         */
        public function __construct(Cache $cache, Config $config, WeatherList $list)
        {
            parent::__construct($cache, $config);
            
            $this->mainModel    = $list;            
        }    
    
        /**
         * To get main model which is injected
         * 
         * @return \Illuminate\Database\Eloquent\Model
         */
        public function onModel()
        {
            return $this->mainModel;            
        }
        
        /**
         * To get all models from cache drive
         * 
         * return \Illuminate\Database\Eloquent\Collection|static[]
         */
        public function onCache()
        {
            list($key, $minitues) = $this->getCachingParameters();
            
            return $this->getCache()->remember($key, $minitues, function() {
                
                return $this->onModel()->enable()->get();
            }); 
            
        }        
}