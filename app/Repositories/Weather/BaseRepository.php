<?php

namespace App\Repositories\Weather;

use App\WeatherCurrent as Current;
use App\City;
use App\Contracts\Repository\ICityRepository as CityRepo;
use App\WeatherCondition as Condition; 
use App\WeatherForeCastResource as Resource;
use App\Libs\Weather\DataType\WeatherDataAble; 
use App\Contracts\Weather\Accessor;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Config\Repository as Config;
use App\Libs\Weather\DataType\WeatherCondition;
use App\Libs\Weather\DataType\WeatherForecastResource;
use App\Repositories\CacheAbleRepository as CacheAble;

use LogicException;
use UnexpectedValueException;


/**
 * Weather Base Repository Class
 * 
 * @package WeatherForcast
 */
abstract class BaseRepository extends CacheAble
{    
    /**
     * @var \App\Contracts\Repository\ICityRepository;
     */
    protected $city;
    
    /**
     * @var \App\WeatherCondition 
     */
    protected $condition;
    
    /**
     * @var \App\WeatherForeCastResource
     */
    protected $resource;
    
    /**
     * For selected city
     * 
     * @var \App\City  
     */
    protected $selectedCity;
    
    /**
     * @var \App\Libs\Weather\DataType\WeatherDataAble
     */
    protected $weatherDataObject;  
    
    /**
     * @var \App\Contracts\Weather\Accessor
     */
    protected $assessor; 
  
        /**
         * Create new Instance
         * 
         * @param \Illuminate\Contracts\Cache\Repository        $cache
         * @param \Illuminate\Contracts\Config\Repository       $config
         * @param \App\Contracts\Repository\ICityRepository     $city
         * @param \App\WeatherCondition                         $condition
         * @param \App\WeatherForeCastResource                  $resource
         * @param \App\WeatherCurrent                           $current
         */
        public function __construct(Cache $cache, Config $config, CityRepo $city, Condition $condition, Resource $resource) 
        {  
            parent::__construct($cache, $config);
            
            $this->city         = $city;
            
            $this->condition    = $condition;
            
            $this->resource     = $resource;
        }   
        
         /**
         * To find weather condition by WeatherCondition Object
         * 
         * @param  \App\Libs\Weather\DataType\WeatherCondition $condition
         * @return \App\WeatherCondition
         */
        protected function findOrCreateCondition(WeatherCondition $condition)
        {
            $model = $this->findConditionByOpenWeatherId($condition['open_weather_map_id']);
            
            if (! is_null($model)) { return $model; }
            
            return $this->getCondition()->create($condition->toArray());
        }        
        
        /**
         * To find weather conditions by given id 
         * 
         * @param int $openWeatherMapID Open Weather Map Condition ID
         * @return \App\WeatherCondition|null
         */
        protected function findConditionByOpenWeatherId($openWeatherMapID)
        {
            return  $this->getCondition()->OfOpenWetherMapId($openWeatherMapID)->first();     
        }
        
        /**
         * To find WeatherForeCastResource model 
         * if it is not exists, create one and return it.
         * 
         * @param  \App\Libs\Weather\DataType\WeatherForecastResource $resource
         * @return \App\WeatherForeCastResource
         */
        public final function findOrNewResource(WeatherForecastResource $resource)
        {
            $name = $resource->name;
            
            $model =  $this->getWeatherForecastResource()->OfName($name)->first();     
            
            if (! is_null($model)) { return $model; }
            
            return $this->getWeatherForecastResource()->create($resource->toArray());   
        }
        
        /**
         * To find condition if it is not exists, create one 
         * and return it. 
         *
         * @param   array $conditions
         * @return  \App\WeatherCondition
         */
        public final function findOrNewConditions(array $conditions)
        {            
            return array_map(function($one) {
                
                return $this->findOrCreateCondition($one);                
                
            }, $conditions);          
        }
        
        public function update(array $current)
        {
            
        }
        
        public function delete($cityID)
        {
            
        }
        
        /***
         * To find city by given ID
         * 
         * @return \App\City|null
         */
        public final function findByCityID($cityID, $queryScopes=false)
        {
           return $queryScopes
                        
                   ? $this->getCityWithScopes()->find($cityID) 
                   
                   : $this->getCity()->all()->find($cityID);            
        }
        
        /**
         * To get model by given slug
         * 
         * @param string $citySlug
         * @return \App\City|null
         */
         public final function findByCitySlug($citySlug)
        {            
            return $this->getCity()->findBySlug($citySlug);                      
        }        
        
        /**
         * To get City model
         * 
         * @return \App\City 
         */
        public final function getCity()
        {
            return $this->city;            
        }
        
        /**
         * To apply scopes on query builder for City model
         * 
         * @return \Illuminate\Database\Query\Builder
         */
        final public function getCityWithScopes()
        {
            return $this->getCity()->enable();
        }    
        
        /**
         * To get all of it
         * 
         * @return \Illuminate\Database\Eloquent\Collection|static[]
         */
        public function all()
        {                      
            if ($this->isEnabledCache()) {
                
                return $this->onCache();
            }
            
            return $this->onModel()->enable->get();        
            
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
        
        /**
         * To get Weather Current model
         * 
         * @return \App\WeatherCurrent 
         */
        public function getMainModel(){}     
        
        /**
         * To select city for any crud job
         * 
         * @param   \App\City $city
         * @return  \App\Repositories\Weather\CurrentRepository
         */
        final public function selectCity(City $city)
        {
            $this->selectedCity = $city;            
          
            if ($city->exists) {
                
                return $this;               
            }
            
            throw new UnexpectedValueException("Given App\City model is not saved on db!");
        }
        
        /**
         * To get Weather Condition
         * 
         * @return \App\WeatherCondition 
         */
        protected function getCondition()
        {
            return $this->condition;            
        }
        
                
        /**
         * To start all import proccess
         * 
         * @return App\WeatherCurrent
         * @throws \ErrorException
         */
        abstract function startImport();
     
     
        
        /**
         * To determine any city is selected.
         * 
         * @return bool
         */
        protected function isCitySelected()
        {
            return (! is_null($this->selectedCity)) && (is_object($this->selectedCity));
        }
        
        /**
         * To get WatherForeCastResource
         * 
         * @return \App\WeatherForeCastResource
         */
        protected function getWeatherForecastResource()
        {
            return $this->resource;
        }
        
        /**
         * To import Weather Current data to data base
         * 
         * @param \App\Libs\Weather\DataType\WeatherDataAble $accessor
         * @return \Illuminate\Database\Eloquent\Model
         */
        public function import(Accessor $accessor)
        {
            $this->setAccessor($accessor);
            
            $this->setWeatherDataObject($accessor->getWeatherData());
            
            if ($this->isCitySelected()) {
                
                return $this->startImport();                              
            }
            
            throw new LogicException('Fistly you should select a city via "selectCity()" method');   
        }        

        /**
         * To get attributes on imported Weather Data object
         * by given attribute name
         * 
         * @param string $name attribte name
         * @return \App\Libs\Weather\DataType\WeatherDataAble|String
         */
        protected function getAttributeOnInportedObject($name)
        {
            return $this->weatherDataObject->{$name};
        }
        
        /**
         * To get selected city
         * 
         * @return \App\City
         * @throws \LogicException
         */
        protected function getSelectedCity()
        {
            if (! is_null($this->selectedCity)) {               
                
                return $this->selectedCity;                       
            }
            
            throw new LogicException('Fistly you should select a city via "selectCity()" method');      
        }
        
        /**
         * To fiter all methods by given prefix
         * 
         * @return array
         */
        public function getFilterMethods($prefix=null) 
        {
            if (is_null($prefix)) { return array(); }
            
            // We interest pnly child class extends this abstract class
            $methods = get_class_methods(get_called_class());                     
           
            return array_filter($methods, function($item) use ($prefix) {
                
                if (strpos($item, $prefix) ===0) { return true;}                
            });           
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
        
        /**
         * To recognize 'key' in picker method name
         * 
         * @param string $name
         * @return string
         * @throws InvalidArgumentException
         */
        protected function parserKeyInMethodName($name='fooBar')
        {
            $snake_case     = snake_case($name);
            
            $segments       = explode('_', $snake_case);
            
            if (empty($segments)) {
                
               throw new InvalidArgumentException('Passed argument is not valid !');
            }  
            
            unset($segments[0]);         
        
            return $this->convertArrayToStingSnakeCase($segments);            
        }
        
       /**
         * To convert array elements to string with snake('_') case
         * 
         * @param array $segments
         * @return string
         */
        protected function convertArrayToStingSnakeCase(array $segments)
        {
            if (count($segments) > 1) {             
                
                return implode('_', $segments);
            }
            
            return last($segments);
        }
        
        /**
         * To set Weather Data Object
         * 
         * @param \App\Libs\Weather\DataType\WeatherDataAble $object
         * @return void
         */
        protected function setWeatherDataObject(WeatherDataAble $object)
        {
            $this->weatherDataObject = $object;
        }
        
        /**
         * To set accessor
         * 
         * @param Accessor $accessor
         */
        protected function setAccessor(Accessor $accessor)
        {
            $this->assessor = $accessor;
        }
}