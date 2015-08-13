<?php

namespace App\Repositories\Weather;

use App\WeatherCurrent as Current;
use App\City;
use App\WeatherCondition as Condition; 
use App\WeatherForeCastResource as Resource;
use App\Libs\Weather\DataType\WeatherDataAble;
use App\Contracts\Weather\Repository\ICurrentRepository;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Config\Repository as Config;
use ErrorException;

/**
 * Current Repository Class
 * 
 * @package WeatherForcast
 */
class CurrentRepository extends BaseRepository implements ICurrentRepository
{    
    /**
     * @var \App\WeatherCurrent 
     */
    private $current;

        /**
         * Constructer
         * 
         * @param \Illuminate\Contracts\Cache\Repository $cache
         * @param \Illuminate\Contracts\Config\Repository $config
         * @param \App\City                     $city
         * @param \App\WeatherCondition         $condition
         * @param \App\WeatherForeCastResource  $resource
         * @param \App\WeatherCurrent           $current
         */
        public function __construct(
                Cache       $cache, 
                Config      $config,
                City        $city, 
                Condition   $condition, 
                Resource    $resource, 
                Current     $current) {
            
            parent::__construct($cache, $config, $city, $condition, $resource);
            
            $this->current      = $current;                
        }     
        
        /**
         * To add Weather ForeCast Model and Weather Condition model to given Weather Current model
         * via ralationships
         * 
         * 
         * @param \App\WeatherCurrent $current
         * @return array    includes \App\WeatherCurrent 
         */
        private function addResourceAndCondition(Current $current)
        {                
            $resource   = $this->getForcastResource();
            
            $conditions = $this->getConditions();
            
            $ids        = array_map(function($one){ return $one->id; }, $conditions);
            
            return [ 
                
                $current->foreCastResource()->associate($resource),
                $current->conditions()->sync($ids, false),
            ];
        }

        
        /**
         * To add weather main, wind, rain, snow and clouds models 
         * to given Weather Current model  via ralationships
         * 
         * @param \App\WeatherCurrent $current
         * @return array    created models
         */
        public function addOtherAllRelationships(Current $current)
        {           
            return $this->callMethodsByPrefix('create', $current);      
        }    
        
        /**
         * To create Instance WeatherMain
         * 
         * @param   \App\WeatherCurrent $current
         * @param   \App\Libs\Weather\DataType\WeatherDataAble $main
         * @return  \App\WeatherMain
         */
        protected function createWeatherMain(Current $current, WeatherDataAble $main)
        {           
            $attributes = $main->toArray();        
            
            $first = $current->main()->firstOrCreate(array());
            
            $first->update($attributes);
            
            return  $first;
        }
        
        /**
         * To create Instance WeatherSys
         * 
         * @param   \App\WeatherCurrent $current
         * @param   \App\Libs\Weather\DataType\WeatherDataAble $sys
         * @return \App\WeatherSys
         */
        protected function createWeatherSys(Current $current, WeatherDataAble $sys)
        {
            $attributes = $sys->toArray();
            
            $first = $current->sys()->firstOrCreate(array());    
          
            $first->update($attributes);
            
            return $first; 
        }
        
        /**
         * To create Instance WeatherWind
         * 
         * @param   \App\WeatherCurrent $current
         * @param   \App\Libs\Weather\DataType\WeatherDataAble $wind
         * @return \App\WeatherWind
         */
        protected function createWeatherWind(Current $current, WeatherDataAble $wind)
        {
            $attributes = $wind->toArray();
            
            $first      = $current->wind()->firstOrCreate(array());
            
            $first->update($attributes);            
            
            return $first;
        }
        
        /**
         * To create Instance WeatherCloud
         * 
         * @param   \App\WeatherCurrent $current
         * @param   \App\Libs\Weather\DataType\WeatherDataAble $clouds
         * @return \App\WeatherCloud
         */
        protected function createWeatherClouds(Current $current, WeatherDataAble $clouds)
        {
            $attributes = $clouds->toArray(); 
            
            $first      = $current->clouds()->firstOrCreate(array());
            
            $first->update($attributes);
            
            return $first;    
        }        
        
       /**
         * To create Instance WeatherRain
         * 
         * @param   \App\WeatherCurrent $current
         * @param   \App\Libs\Weather\DataType\WeatherDataAble $rain
         * @return \App\WeatherRain
         */
        protected function createWeatherRain(Current $current, WeatherDataAble $rain)
        {
            $attributes = $rain->toArray();  
            
            $first      = $current->rain()->firstOrCreate(array());
            
            $first->update($attributes);
            
            return $first;            
        }
        
        /**
         * To create Instance WeatherSnow
         * 
         * @param   \App\WeatherCurrent $current
         * @param   \App\Libs\Weather\DataType\WeatherDataAble $snow
         * @return \App\WeatherRain
         */
        protected function createWeatherSnow(Current $current, WeatherDataAble $snow)
        {
            $attributes = $snow->toArray();
            
            $first      = $current->snow()->firstOrCreate(array());    
            
            $first->update($attributes);
            
            return $first;   
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
        
        /**
         * To get condtions
         * 
         * @return array
         */
        public function getConditions()
        {            
            $conditions = $this->getAttributeOnInportedObject('weather_condition');
            
            return $this->findOrNewConditions($conditions);
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
        
        /**
         * To start all import proccess
         * 
         * @return \App\WeatherCurrent
         * @throws \ErrorException
         */
        public function startImport()
        {            
            $new        = $this->firstOrCreateWeatherCurrent(array());
            
            $results    = $this->importAllRelationships($new);         
            
            $new->source_updated_at = $this->getAttributeOnInportedObject('source_updated_at');
                        
            if ($new->save()) { return $new; }
            
            throw new ErrorException('Weather Current model can not be created !');   
        }
        
        /**
         * To get first one or if it is not exsits, create one
         * 
         * @param array $attributes
         * @return \App\WeatherCurrent
         */
        private function firstOrCreateWeatherCurrent(array $attributes)
        {          
            return $this->getSelectedCity()->weatherCurrent()->firstOrCreate($attributes);            
        }
        
        /**
         * to attach all childs model to App\WeatherCurrent model
         * 
         * @param App\WeatherCurrent $current
         * @return array    results
         */
        protected function importAllRelationships(Current $current)
        {
            $results    = $this->addResourceAndCondition($current);
            $results2   = $this->addOtherAllRelationships($current);            
            
            return  array_merge($results, $results2);
        }
       
}