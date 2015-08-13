<?php

namespace App\Repositories\Weather;

use App\WeatherHourlyStat as Hourly;
use App\Contracts\Repository\ICityRepository as City;
use App\WeatherCondition as Condition; 
use App\WeatherForeCastResource as Resource;
use App\Libs\Weather\DataType\WeatherDataAble;
use App\Contracts\Weather\Repository\IHourlyRepository;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Config\Repository as Config;
use ErrorException;

/**
 * Weather Hourly Stats Repository Class
 * 
 * @package WeatherForcast
 */
class HourlyStatRepository extends BaseRepository implements IHourlyRepository
{    
    /**
     * @var \App\WeatherHourlyStat 
     */
    private $mainModel;

        /**
         * Constructer
         * 
         * @param \Illuminate\Contracts\Cache\Repository $cache
         * @param \Illuminate\Contracts\Config\Repository $config
         * @param \App\City                     $city
         * @param \App\WeatherCondition         $condition
         * @param \App\WeatherForeCastResource  $resource
         * @param \App\WeatherHourlyStat        $hourly
         */
        public function __construct(
                Cache       $cache, 
                Config      $config,
                City        $city, 
                Condition   $condition, 
                Resource    $resource, 
                Hourly      $hourly) {
            
            parent::__construct($cache, $config, $city, $condition, $resource);
            
            $this->mainModel    = $hourly;                
        }         
        
        
        /**
         * To start all import proccess
         * 
         * @return \App\WeatherCurrent
         * @throws \ErrorException
         */
        public function startImport()
        {     
            
           
        }
        
        /**
         * To get weather list data for cartain WeatherHourly Data
         * 
         * @return array|null
         */
        protected function getListsFromAccessor()
        {
            return $this->getAttributeOnInportedObject('list');            
        }

        
        /**
         * To add Weather ForeCast Model and Weather Condition model to given Weather Current model
         * via ralationships
         * 
         * 
         * @param \App\WeatherHourlyStat $hourly
         * @return array    includes \App\WeatherCurrent 
         */
        private function addResource(Hourly $hourly)
        {                
            $resource   = $this->getForcastResource();
          
            return $hourly->foreCastResource()->associate($resource);
        }    
        
                /**
         * To get weather forecast resource model and weather condition model
         * 
         * @return   \App\Libs\Weather\DataType\WeatherForecastResource
         */
        public function getForcastResource()
        {
            $resource   = $this->getAttributeOnInportedObject('weather_forecast_resource');            
          
            return $this->findOrNewResource($resource);
        }         

     
        
        public function update(array $current)
        {
            
        }
        
        public function delete($cityID)
        {
            
        }        
      
        /**
         * To get Weather Current model
         * 
         * @return \App\WeatherCurrent  
         */
        public function onModel()
        {
            return $this->getMainModel();
        }
        
        /**
         * To get Weather Current model
         * 
         * @return \App\WeatherCurrent 
         */
        public function getMainModel()                 
        {
            return $this->current;            
        }     
        
    
       
}