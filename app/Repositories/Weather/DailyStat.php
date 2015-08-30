<?php

namespace App\Repositories\Weather;


use ErrorException;
use App\Weather\DailyStat                                   as Daily;
use App\WeatherForeCastResource                             as Resource;
use Illuminate\Contracts\Cache\Repository                   as Cache;
use Illuminate\Contracts\Config\Repository                  as Config;
use App\Contracts\Repository\ICity                          as CityRepo;
use App\Contracts\Weather\Repository\IList;
use App\Contracts\Weather\Repository\IDaily;
use App\Contracts\Weather\Repository\Condition;

/**
 * Weather Daily Stats Repository Class
 * 
 * @package WeatherForcast
 */
class DailyStat extends Base implements IDaily
{    
    /**
     * @var App\Weather\DailyStat
     */
    private $mainModel;
    
    /**
     * @var \App\Repositories\Weather\List
     */
    private $listRepo;

        /**
         * Create new Instance
         * 
         * @param \Illuminate\Contracts\Cache\Repository        $cache
         * @param \Illuminate\Contracts\Config\Repository       $config
         * @param \App\Contracts\Repository\ICity               $cityRepo
         * @param \App\Contracts\Weather\Repository\Condition   $condition
         * @param \App\WeatherForeCastResource                  $resource
         * @param \App\Weather\DailyStat                        $daily
         * @param \App\Contracts\Weather\Repository\IList       $listRepo
         */
        public function __construct(
                Cache           $cache, 
                Config          $config,
                CityRepo        $cityRepo, 
                Condition       $condition, 
                Resource        $resource, 
                Daily           $daily,
                IList           $listRepo) {
            
            parent::__construct($cache, $config, $cityRepo, $condition, $resource);
            
            $this->mainModel    = $daily;    
            
            $this->listRepo     = $listRepo;
        }       
        
        /**
         * To start all import proccess
         * 
         * @return \App\WeatherHourlyStat
         * @throws \ErrorException
         */
        public function startImport()
        {
            $stat = $this->getDailyStat();
            
            $data = $this->getAccessor()->getWeatherData();            
            
            $lists      = $this->listRepo->createListsByDailyStat($stat, $data);
            
            if ( $lists->isEmpty()) {
                
                throw new ErrorException('There is any lists belongs to Weather DailyStat Model!');                              
            }
            
            $associatedModel = $this->addResource($stat);
            
            if ($associatedModel->save()) {  return $associatedModel; }            
            
            throw new ErrorException('Weather DailyStat model is not saved correctly');                  
         }
        
        
        /**
         * To get Weather DailyStat model by selected city
         * 
         * @return \App\Weather\DailyStat
         */
        protected function getDailyStat()
        {
            $city = $this->getSelectedCity();
            
            return $this->city->firstOrCreateWeatherDailyStat($city);
        }    
        
        /**
         * To add Weather ForeCast Model and Weather Condition model to given Weather Current model
         * via ralationships
         * 
         * 
         * @param   \App\Weather\DailyStat $daily
         * @return  \App\WeatherForeCastResource
         */
        private function addResource(Daily $daily)
        {                
            $resource   = $this->getForcastResource();
          
            return $daily->foreCastResource()->associate($resource);
        }    
        
        /**
         * To get weather forecast resource model and weather condition model
         * 
         * @return   \App\WeatherForeCastResource
         */
        private function getForcastResource()
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
        
        
        public function find($id)
        {
            ;
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