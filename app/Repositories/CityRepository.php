<?php

namespace App\Repositories;

use App\City;
use App\Contracts\Repository\ICityRepository;
use App\Repositories\CacheAbleRepository as CacheAble;
use Illuminate\Contracts\Cache\Repository as Cache;
use \Illuminate\Contracts\Config\Repository as Config;


/**
 * City Repository Class
 * 
 * @package WeatherForcast
 */
class CityRepository extends CacheAble implements ICityRepository
{  
    
    /**
     * 
     * @var \App\City 
     */
    private $mainModel;

        /**
         * Create new Instance
         * 
         * @param \Illuminate\Contracts\Cache\Repository $cache
         * @param \Illuminate\Contracts\Config\Repository $config
         */
        public function __construct(Cache $cache, Config $config, City $city)
        {
            parent::__construct($cache, $config);
            
            $this->mainModel    = $city;
        }
 
        
        public function create(array $current)
        {
            
            
        }        
        
        public function update($cityID, array $current)
        {
            
        }
        
        public function delete($cityID)
        {
            
        }
        
        /**
         * To get first model  or create new instance model
         * 
         * @param \App\City     $city
         * @return \App\WeatherHourlyStat
         */
        public function findOrCreateWeatherHouryStat(City $city)
        {
            return $city->weatherHourlyStat()->firstOrCreate(array());         
        }       
        
        /**
         * To get first model or create new instance model
         * 
         * @param \App\City     $city
         * @return \App\WeatherCurrent  
         */
        public function firstOrCreateWeatherCurrent(City $city)
        {          
            return $city->weatherCurrent()->firstOrCreate(array());
        }
        
        public function findOrCreateWeatherDailyStat()
        {
            
        }
        
        /***
         * To find city by given ID
         * 
         * @return \App\City|null
         */
        public function find($cityID)
        {           
            return $this->onModel()->find($cityID);
        }
        
        /**
         * To get model by given slug
         * 
         * @param string $citySlug
         * @return \App\City|null
         */
        public function findBySlug($citySlug)
        {            
            return $this->onModel()->findBySlug($citySlug);                      
        }        

        /**
         * To get main model which is injected
         * 
         * @return \App\City 
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
            list($key, $time) =  $this->getCachingParameters();
            
            return $this->getCache()->remember($key, $time, function(){
                
                return $this->onModel()->enable()->get();            
            });            
        }
}
