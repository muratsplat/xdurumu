<?php

namespace App\Repositories\Weather;

use ErrorException;
use App\WeatherCurrent                                      as Model;
use App\WeatherForeCastResource                             as Resource;
use Illuminate\Contracts\Cache\Repository                   as Cache;
use Illuminate\Contracts\Config\Repository                  as Config;
use App\Contracts\Repository\ICity                          as City;
use App\Libs\Weather\DataType\WeatherDataAble;
use App\Contracts\Repository\ICacheAble;
use App\Contracts\Weather\Repository\Condition; 
use App\Contracts\Weather\Repository\ICurrent;
use App\Contracts\Weather\Repository\Importable; 

/**
 * Current Repository Class
 * 
 * @package WeatherForcast
 */
class Current extends Base implements ICurrent, ICacheAble, Importable
{    
    /**
     * @var \App\WeatherCurrent 
     */
    private $current;

        /**
         * Constructer
         * 
         * @param \Illuminate\Contracts\Cache\Repository                $cache
         * @param \Illuminate\Contracts\Config\Repository               $config
         * @param \App\Contracts\Repository\ICityRepository             $city
         * @param \App\Contracts\Weather\Repository\ConditionRepository $condition
         * @param \App\WeatherForeCastResource                          $resource
         * @param \App\WeatherCurrent                                   $current
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
        private function addResourceAndCondition(Model $current)
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
        public function addOtherAllRelationships(Model $current)
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
        protected function createWeatherMain(Model $current, WeatherDataAble $main)
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
        protected function createWeatherSys(Model $current, WeatherDataAble $sys)
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
        protected function createWeatherWind(Model $current, WeatherDataAble $wind)
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
        protected function createWeatherClouds(Model $current, WeatherDataAble $clouds)
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
        protected function createWeatherRain(Model $current, WeatherDataAble $rain)
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
        protected function createWeatherSnow(Model $current, WeatherDataAble $snow)
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
            $new        = $this->firstOrCreateWeatherCurrent();
            
            $results    = $this->importAllRelationships($new);         
            
            $new->source_updated_at = $this->getAttributeOnInportedObject('source_updated_at');
                                  
            if ($new->save()) { return $new; }
            
            throw new ErrorException('Weather Current model can not be created !');   
        }
        
        /**
         * To get first one or if it is not exsits, create one
         * 
         * @return \App\WeatherCurrent
         */
        private function firstOrCreateWeatherCurrent()
        {          
            $city =  $this->getSelectedCity();            
            
            return $this->city->firstOrCreateWeatherCurrent($city);          
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
        
           /**
         * To call given methods with parameters
         * 
         * @param string                $prefix    such as 'foo'Bar() for 'fooBar()'
         * @param \App\WeatherCurrent   $current
         * @return array    returns of called methods
         */
        protected function callMethodsByPrefix($prefix, Current $current) 
        {   
            $results    = [];       
            
            foreach ($this->getFilterMethods($prefix) as $method) {
                
                $dataName   = $this->parserKeyInMethodName($method);   
                
                $dataObject = $this->getAttributeOnInportedObject($dataName);
                
                if (is_null($dataObject)) { continue; }                        
                
                $results[] =  call_user_func_array([$this, $method], [$current, $dataObject]);         
            }
            
            return $results;                       
        }
        
        public function find($id)
        {
            ;
        }
       
}