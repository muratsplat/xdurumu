<?php

namespace App\Repositories;

use App\City                                    as Model;
use App\Repositories\CacheAble;
use App\Contracts\Repository\ICity;
use Illuminate\Contracts\Cache\Repository       as Cache;
use Illuminate\Contracts\Config\Repository      as Config;
use Illuminate\Database\Eloquent\Collection;

/**
 * City Repository Class
 * 
 * @package WeatherForcast
 */
class City extends CacheAble implements ICity
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
        public function __construct(Cache $cache, Config $config, Model $city)
        {
            parent::__construct($cache, $config);
            
            $this->mainModel    = $city;
        }
 
        
        public function create(array $attributes)
        {
         
            throw new \Exception('This method is under constructer! ');            
        }        
        
        /**
         * To update City
         * 
         * @param int $cityID
         * @param array $attributes
         * @return bool|int
         * @throws \InvalidArgumentException
         */
        public function update($cityID, array $attributes)
        {
            $model = $this->find($cityID);
                    
            if ($model) {

               return $model->update($attributes);
            }
            
            throw new \InvalidArgumentException('Model is not found by passed primary key !');           
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
        public function firstOrCreateWeatherHouryStat(Model $city)
        {
            return $city->weatherHourlyStat()->firstOrCreate(array());         
        }      
        
        /**
         * To get first model  or create new instance model
         * 
         * @param \App\City     $city
         * @return \App\Weather\DailyStat
         */
        public function firstOrCreateWeatherDailyStat(Model $city)
        {
            return $city->weatherDailyStat()->firstOrCreate(array());         
        }  
        
        /**
         * To get first model or create new instance model
         * 
         * @param \App\City     $city
         * @return \App\WeatherCurrent  
         */
        public function firstOrCreateWeatherCurrent(Model $city)
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
          
                return $this->onModel()->all();    
            });            
        }  
        
        /**
         * To delete old hourly weather lists belongs to given City  model
         * 
         * @param \App\City $city $city
         * @return int|null
         */
        public function deleteOldHourlyLists(Model $city)
        {
            $lists = $this->getAllHourlyListByCity($city);
            
            if ( $lists->isEmpty() ) { return; }
            
            $numberOflist = $lists->count();
            
            /*
             * 37 number weather list models creates foreach a city at least
             */
            if ( $numberOflist > 37) {
                
                $length = $numberOflist - 37;
                
                $lists->slice(0, $length)->each(function($item){
                    
                    $item->delete();
                });
                
                return $length; // Number of delected models
            }    
        }
        
        /**
         * To get WeatherList model belongs to Weather HourlyStat by given city model
         * 
         * @param \App\City $city
         * @return \Illuminate\Database\Eloquent\Collection
         */
        public function getAllHourlyListByCity(Model $city)
        {
            $hourlyStat = $this->getHourlyStatByCity($city);
            
            if (is_null($hourlyStat)) {
                
                return new Collection();
            }
            
            return $hourlyStat->weatherLists()->getResults();            
        }   

        /**
         * To get Weather Hourly Stat model belengs to given model
         * 
         * @param  \App\City $city
         * @return \App\WeatherHourlyStat
         */
        public function getHourlyStatByCity(Model $city)
        {
            return $city->weatherHourlyStat;      
        }
        
        /**
         * To get Weather Daily Stat model belengs to given model
         * 
         * @param  \App\City $city
         * @return \App\WeatherDailyStat
         */
        public function getDailyStatByCity(Model $city)
        {
            return $city->weatherDailyStat;     
        }
        
        
         /**
         * To get WeatherList model belongs to Weather Daily Stat by given city model
         * 
         * @param \App\City $city
         * @return \Illuminate\Database\Eloquent\Collection
         */
        public function getAllDailyListByCity(Model $city)
        {
            $dailyStat = $this->getDailyStatByCity($city);
            
            if (is_null($dailyStat)) { return new Collection(); }
            
            return $dailyStat->weatherLists()->getResults();            
        } 
        
        /**
         * To delete old  daily weather lists belongs to given City  model
         * 
         * @param \App\City $city $city
         * @return int|null
         */
        public function deleteOldDailyLists(Model $city)
        {
            $lists = $this->getAllDailyListByCity($city);
            
            if ( $lists->isEmpty() ) { return; }
            
            $numberOflist = $lists->count();
            
            /*
             * 16 number weather list models creates foreach a city at least
             */
            if ( $numberOflist > 16) {
                
                $length = $numberOflist - 16;
                
                $lists->slice(0, $length)->each(function($item){
                    
                    $item->delete();
                });
                
                return $length; // Number of delected models
            }    
        }        
        
        /**
         * To deletes old  hourly and daily weather list models
         * 
         * @param App\City $city
         * @return int  deletes records
         */
        public function deleteOldListsByCity(Model $city)
        {            
            return (int) $this->deleteOldDailyLists($city)  + (int) $this->deleteOldHourlyLists($city);            
        }        
        
        /**
         * To get all cities has weather data
         * 
         * @return \Illuminate\Database\Eloquent\Collection
         */
        public function getAllOnlyOnesHasWeatherData()
        {
            $time = 30;
            
            $key  = createUniqueKeyFromObj($this->onModel(), 'all.onesHasWeatherData');
            
            $enableCities = $this->getEnableAllCities();            
            
            $callback = function() use ($enableCities) {
                
                return $enableCities->filter(function($one){
                    
                    return $one->weatherDataIsReady();
                    
                });               
            };   
           
            return $this->remember($key, $time, $callback);
        }        
        
        /**
         * To get only enabled cities
         * 
         * @return \Illuminate\Database\Eloquent\Collection
         */
        protected function getEnableAllCities()
        {          
            return $this->onModel()->enable()->get();
        }        
}
