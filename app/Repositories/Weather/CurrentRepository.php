<?php

namespace App\Repositories\Weather;

use App\WeatherCurrent as Current;
use App\City;
use App\WeatherCondition as Condition; 
use App\WeatherForeCastResource as Resource;
use App\Libs\Weather\DataType\WeatherDataAble; 
use LogicException;
use Closure;
use UnexpectedValueException;
use ErrorException;

/**
 * Current Repository Class
 * 
 * @package WeatherForcast
 */
class CurrentRepository 
{    
    /**
     * @var \App\WeatherCurrent 
     */
    private $current;
    
    /**
     * @var \App\City 
     */
    private $city;
    
    /**
     * @var \App\WeatherCondition 
     */
    private $condition;
    
    /**
     * @var \App\WeatherForeCastResource
     */
    private $resource;
    
    /**
     * For selected city
     * @var \App\City  
     */
    private $selectedCity;
    
    /**
     * @var \App\Libs\Weather\DataType\WeatherDataAble
     */
    private $weatherCurrentDataObject;
    
    /**
     * Weather Currnet Data
     * 
     * Example:
     *  
     * array(9) {
     *    'city' =>
     *    array(5) {
     *    'i     *    int(1851632)
     *    'name' =>
     *    string(8) "Shuzenji"
     *    'country' =>
     *    string(2) "JP"
     *    'latitude' =>
     *    int(35)
     *    'longitude' =>
     *    int(139)
     *  }
     *  'weather_condition' =>
     *  array(6) {
     *    'id' =>
     *    int(804)
     *    'name' =>
     *    string(6) "clouds"
     *    'description' =>
     *    string(15) "overcast clouds"
     *    'orgin_name' =>
     *    string(6) "clouds"
     *    'orgin_description' =>
     *    string(15) "overcast clouds"
     *    'icon' =>
     *    string(3) "04n"
     *  }
     *  'weather_forecast_resource' =>
     *  array(7) {
     *    'name' =>
     *    string(14) "openweathermap"
     *    'description' =>
     *    string(51) "Current weather conditions in cities for world wide"
     *    'url' =>
     *    string(18) "openweathermap.org"
     *    'api_url' =>
     *    string(39) "api.openweathermap.org/data/2.5/weather"
     *    'enable' =>
     *    int(1)
     *    'paid' =>
     *    int(0)
     *    'apiable' =>
     *    bool(true)
     *  }
     *  'weather_main' =>
     *  array(11) {
     *    'temp' =>
     *    double(289.5)
     *    'temp_min' =>
     *    double(287.04)
     *    'temp_max' =>
     *    double(292.04)
     *    'temp_eve' =>
     *    NULL
     *    'temp_night' =>
     *    NULL
     *    'temp_morn' =>
     *    NULL
     *    'pressure' =>
     *    int(1013)
     *    'humidity' =>
     *    int(89)
     *    'sea_level' =>
     *    NULL
     *    'grnd_level' =>
     *    NULL
     *    'temp_kf' =>
     *    NULL
     *  }
     *  'weather_wind' =>
     *  array(2) {
     *    'speed' =>
     *    double(7.31)
     *    'deg' =>
     *    double(187.002)
     *  }
     *  'weather_rain' =>
     *  array(2) {
     *    '3h' =>
     *    int(0)
     *    'rain' =>
     *    NULL
     *  }
     *  'weather_snow' =>
     *  array(2) {
     *    '3h' =>
     *    int(1)
     *    'snow' =>
     *    NULL
     *  }
     *  'weather_clouds' =>
     *  array(1) {
     *    'all' =>
     *    int(92)
     *  }
     *  'source_updated_at' =>
     *  string(19) "2013-05-29 13:05:38"
     *}
     *
     * @var array
     */
    private $weatherCurrentRawData;

        /**
         * Constructer
         * 
         * 
         * @param \App\City                     $city
         * @param \App\WeatherCondition         $condition
         * @param \App\WeatherForeCastResource  $resource
         * @param \App\WeatherCurrent           $current
         */
        public function __construct(City $city, Condition $condition, Resource $resource, Current $current) 
        {            
            $this->current      = $current;        
            
            $this->city         = $city;
            
            $this->condition    = $condition;
            
            $this->resource     = $resource;
        }     
        
        /**
         * To add Weather ForeCast Model and Weather Condition model to given Weather Current model
         * via ralationships
         * 
         * 
         * @param \App\WeatherCurrent $current
         * @return array created models
         */
        private function addResourceAndCondition(Current $current)
        {                
            list($resource, $condition) = $this->getForcastResourceAndCondition(); 
            
            return [ 
                
                $current->foreCastResource()->save($resource),
                $current->condition()->save($condition),
            ];
        }
        
        /**
         * To add weather main, wind, rain, snow and clouds models 
         * to given Weather Current model  via ralationships
         * 
         * @param \App\WeatherCurrent $current
         * @return array    created models
         */
        private function addOtherAllRelationships(Current $current)
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
        private function createWeatherMain(Current $current, WeatherDataAble $main)
        {
            $attributes = $main->getAttributes();
            
            $values     = $main->getValues();
            
            return $current->main()->updateOrCreate($attributes, $values);    
        }
        
        /**
         * To create Instance WeatherSys
         * 
         * @param   \App\WeatherCurrent $current
         * @param   \App\Libs\Weather\DataType\WeatherDataAble $sys
         * @return \App\WeatherSys
         */
        private function createWeatherSys(Current $current, WeatherDataAble $sys)
        {
            $attributes = $sys->getAttributes();
            
            $values     = $sys->getValues();
            
            return $current->sys()->updateOrCreate($attributes, $values);    
        }
        
        /**
         * To create Instance WeatherWind
         * 
         * @param   \App\WeatherCurrent $current
         * @param   \App\Libs\Weather\DataType\WeatherDataAble $wind
         * @return \App\WeatherWind
         */
        private function createWeatherWind(Current $current, WeatherDataAble $wind)
        {
            $attributes = $wind->getAttributes();
            
            $values     = $wind->getValues();
            
            return $current->sys()->updateOrCreate($attributes, $values);    
        }
        
        /**
         * To create Instance WeatherCloud
         * 
         * @param   \App\WeatherCurrent $current
         * @param   \App\Libs\Weather\DataType\WeatherDataAble $clouds
         * @return \App\WeatherCloud
         */
        private function createWeatherClouds(Current $current, WeatherDataAble $clouds)
        {
            $attributes = $clouds->getAttributes();
            
            $values     = $clouds->getValues();
            
            return $current->clouds()->updateOrCreate($attributes, $values);    
        }
        
        
       /**
         * To create Instance WeatherRain
         * 
         * @param   \App\WeatherCurrent $current
         * @param   \App\Libs\Weather\DataType\WeatherDataAble $rain
         * @return \App\WeatherRain
         */
        private function createWeatherRain(Current $current, WeatherDataAble $rain)
        {
            $attributes = $rain->getAttributes();
            
            $values     = $rain->getValues();
            
            return $current->clouds()->updateOrCreate($attributes, $values);    
        }      
        
        /**
         * To create Instance WeatherSnow
         * 
         * @param   \App\WeatherCurrent $current
         * @param   \App\Libs\Weather\DataType\WeatherDataAble $snow
         * @return \App\WeatherRain
         */
        private function createWeatherSnow(Current $current, WeatherDataAble $snow)
        {
            $attributes = $snow->getAttributes();
            
            $values     = $snow->getValues();
            
            return $current->clouds()->updateOrCreate($attributes, $values);    
        }   
        
        /**
         * To get weather forecast resource model and weather condition model
         * 
         * @return array    [WeatherForeCastResource, WeatherCondition]
         */
        private function getForcastResourceAndCondition()
        {
            $resource   = $this->getAttributeOnInportedObject('weather_forecast_resource');
            
            $condition  = $this->getAttributeOnInportedObject('weather_condition');
            
            return [$this->findOrNewResource($resource), $this->findOrNewCondition($condition)];
        }
        
//        'city_id'                       => null,
//        'weather_condition_id'          => null,
//        'weather_forecast_resource_id'  => null,
//        'weather_main_id'               => null,   
//        'weather_wind_id'               => null,
//        'weather_rain_id'               => null,
//        'weather_snow_id'               => null,
//        'weather_cloud_id'              => null,
//        'enable'                        => (boolean) rand(0, 1),
//        'source_updated_at'             => \Carbon\Carbon::createFromTimestampUTC(rand(1437814800, 1437914800))->format('Y-m-d H:m:s'),
//        'created_at'                    => $created_at,
        

        
        /**
         * To find condition if it is not exists, create one 
         * and return it. 
         *
         * @param array $columns
         * @return \App\WeatherCondition
         */
        private function findOrNewCondition(array $columns)
        {
            $opeWeatherMapID = array_get($columns, 'id', null);
            
            $model =  $this->getCondition()->OfOpenWetherMapId($opeWeatherMapID)->first();     
            
            if (! is_null($model)) { return $model; }
            
            return $this->getCondition()->create($columns);   
        }        
        
        /**
         * To find WeatherForeCastResource model 
         * if it is not exists, create one and return it.
         * 
         * @param array $columns
         * @return \App\WeatherForeCastResource
         */
        private function findOrNewResource(array $columns)
        {
            $name = array_get($columns, 'name', null);
            
            $model =  $this->getWeatherForecastResource()->OfName($name)->first();     
            
            if (! is_null($model)) { return $model; }
            
            return $this->getWeatherForecastResource()->create($columns);   
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
        public function findByCityID($cityID, $queryScopes=false)
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
        public function findByCitySlug($citySlug)
        {            
            return $this->getCity()->findBySlug($citySlug);                      
        }        
        
        /**
         * To get City model
         * 
         * @return \App\City 
         */
        private function getCity()
        {
            return $this->city;            
        }
        
        /**
         * To apply scopes on query builder for City model
         * 
         * @return \Illuminate\Database\Query\Builder
         */
        private function getCityWithScopes()
        {
            return $this->getCity()->enable();
        }    
        
        /**
         * To get all  of weather current time
         * 
         * @return \Illuminate\Database\Eloquent\Collection|static[]
         */
        public function all() 
        {
            return $this->current->all();            
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
         * To select city for any crud job
         * 
         * @param   \App\City $city
         * @return  \App\Repositories\Weather\CurrentRepository
         */
        public function selectCity(City $city)
        {
            $this->selectedCity = $city;
            
            return $this;
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
         * To determine any city is selected.
         * 
         * @return bool
         */
        private function isCitySelected()
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
         * @param \App\Libs\Weather\DataType\WeatherDataAble $weaterCurrent
         * @return 
         */
        public function import(WeatherDataAble $weaterCurrent)
        {
            $this->weatherCurrentDataObject = $weaterCurrent; 
            
            if ($this->isCitySelected()) {
                
                return $this->startImport();                              
            }
            
            throw new LogicException('Fistly you should select a city via "selectCity()" method');   
        }
        
        /**
         * To start all import proccess
         * 
         * @return App\WeatherCurrent
         * @throws \ErrorException
         */
        protected function startImport()
        {
            $new        = $this->getSelectedCity()->weatherCurrent()->firstOrCreate(array());
            
            $results    = $this->importAllRelationships($new);         
            
            $new->source_updated_at = $this->getWeatherSourceUpdateDate();
            
            if ($new->save()) { return $new; }
            
            throw new ErrorException('Weather Current model can not be created !');   
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
         * To get attributes on imported Weather Data object
         * by given attribute name
         * 
         * @param string $name attribte name
         * @return \App\Libs\Weather\DataType\WeatherDataAble|String
         */
        protected function getAttributeOnInportedObject($name)
        {
            return $this->weatherCurrentDataObject->{$name};
        }
        
        /**
         * To get selected city
         * 
         * @return \App\City
         * @throws \LogicException
         */
        private function getSelectedCity()
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
        protected function getFilterMethods($prefix=null) 
        {
            if (is_null($prefix)) { return array(); }
            
            $methods = get_class_methods($this);
            
            return array_filter($methods, function($item) use ($prefix) {
                
                if(strpos($item, $prefix) ===0) {
                    
                    return true;
                }                
            });           
        }
        
        /**
         * To call given methods with parameters
         * 
         * @param string    $prefix    such as 'foo'Bar() for 'fooBar()'
         * @param array     $arg
         * @param closure   a callback to manipulate passed argument finally
         * @return array    returns of called methods
         */
        protected function callMethodsByPrefix($prefix, Current $current) 
        {   
            $results    = [];       
            
            foreach ($this->getFilterMethods($prefix) as $method) {
                
                $dataObject = $this->getAttributeOnInportedObject($dataName);
                
                if (is_null($dataName)) { continue; }
                
                $dataName   = $this->parserKeyInMethodName($method);              
                
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
        private function convertArrayToStingSnakeCase(array $segments)
        {
            if (count($segments) > 1) {
             
                
                return implode('_', $segments);
            }
            
            return last($segments);
        }
}