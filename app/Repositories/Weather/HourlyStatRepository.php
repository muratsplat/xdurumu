<?php

namespace App\Repositories\Weather;

use App\WeatherHourlyStat as Hourly;

use App\WeatherCondition as Condition; 
use App\WeatherForeCastResource as Resource;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Config\Repository as Config;
use App\Contracts\Repository\ICityRepository as CityRepo;
use App\Libs\Weather\DataType\WeatherDataAble;
use App\Contracts\Weather\Repository\IListRepository;
use App\Contracts\Weather\Repository\IHourlyRepository;

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
     * @var \App\Repositories\Weather\ListRepository
     */
    private $listRepo;

        /**
         * Constructer
         * 
         * @param \Illuminate\Contracts\Cache\Repository            $cache
         * @param \Illuminate\Contracts\Config\Repository           $config
         * @param \App\Contracts\Repository\ICityRepository         $cityRepo
         * @param \App\WeatherCondition                             $condition
         * @param \App\WeatherForeCastResource                      $resource
         * @param \App\WeatherHourlyStat                            $hourly
         * @param App\Contracts\Weather\Repository\IListRepository  $listRepo
         */
        public function __construct(
                Cache           $cache, 
                Config          $config,
                CityRepo        $cityRepo, 
                Condition       $condition, 
                Resource        $resource, 
                Hourly          $hourly,
                IListRepository $listRepo) {
            
            parent::__construct($cache, $config, $cityRepo, $condition, $resource);
            
            $this->mainModel    = $hourly;    
            
            $this->listRepo     = $listRepo;
        }         
        
        
        /**
         * To start all import proccess
         * 
         * @return \App\WeatherCurrent
         * @throws \ErrorException
         */
        public function startImport()
        {
            $hourlyStat = $this->getHourlyStat();
            
            
            
          
             
           
        }
        
        
        /**
         * To get WeatherHourlyStat model by selected city
         * 
         * @return \App\WeatherHourlyStat
         */
        protected function getHourlyStat()
        {
            $city = $this->getSelectedCity();
            
            return $this->city->firstOrCreateWeatherHouryStat($city);
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