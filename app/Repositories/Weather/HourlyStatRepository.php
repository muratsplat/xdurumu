<?php

namespace App\Repositories\Weather;

use App\WeatherHourlyStat as Hourly;
use App\City;
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
         * To add Weather ForeCast Model and Weather Condition model to given Weather Current model
         * via ralationships
         * 
         * 
         * @param \App\WeatherHourlyStat $current
         * @return array    includes \App\WeatherHourlyStat 
         */
        private function addResourceAndCondition(Hourly $current)
        {                
            list($resource, $condition) = $this->getForcastResourceAndCondition(); 
            
            return [ 
                
                $current->foreCastResource()->associate($resource),
                $current->conditions()->attach($condition->id),
            ];
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