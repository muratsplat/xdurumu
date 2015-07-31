<?php

namespace App\Repositories\Weather;

use App\WeatherCurrent as Current;
use App\City;
use App\WeatherCondition as Condition; 
use App\WeatherForeCastResource as Resource;
use LogicException;
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
         * To set raw data to use inside of this object
         * 
         * @param array $attributes
         * @return void
         */
        protected function setRawData(array $attributes)
        {
            $this->weatherCurrentRawData = $attributes;
        }
        
        public function create(array $current)
        {
            if (! $this->isCitySelected()) {                
                
                throw new LogicException('Fistly you should select a city via "selectCity()" method');         
            }       
            
            $existed = $this->selectedCity->weatherCurrent;
            
            if (! is_null($existed)) {
                
                return $this->update($existed);
            }  
            
            return $this->insert($current);
            
        }
        
        /**
         * To insert Weather Current Model
         * 
         * @param array $current
         * @return array
         */
        protected function insert(array $current)
        {
            $this->setRawData($current);
            
            $new = $this->getCity()->weatherCurrent()->create();           
            
            $results    = $this->addResourceAndCondition($new);
            $results2   = $this->addOtherAllRelationships($new);            
            $merged     = array_merge($results, $results2);
            
            $new->source_updated_at = $this->getWeatherSourceUpdateDate();
            
            if (!in_array(null, $merged) && $new->save()) {
                
                return $new;            
            }
            
            throw new ErrorException('Weather Current model can not be created !');       
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
            list($main, $wind, $rain, $snow, $clouds ) = $this->getMainAndWindAndRainAndSnowAndClouds();
            
            return [
                
                $current->main()->create($main),
                $current->wind()->create($wind),
                $current->rains()->create($rain),
                $current->snows()->create($snow),
                $current->cloud()->create($clouds),
                $current->main()->create($main),     
            ];
            
        }
        
        
        
        /**
         * To get weather forecast resource model and weather condition model
         * 
         * @return array    [WeatherForeCastResource, WeatherCondition]
         */
        private function getForcastResourceAndCondition()
        {
            $resource   = $this->getWeatherForeCastResourceAttributes();
            
            $condition  = $this->getWeatherConditionAttributes();
            
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
         * To get Weather ForeCast Resource Raw Attributes
         * 
         * @return array|null
         */
        private function getWeatherForeCastResourceAttributes()
        {
            $key = 'weather_forecast_resource';

            $array =  $this->getKeyInWeatherCurrentRawData($key);
            
            if (!is_null($array) && is_array($array) && ! empty($array)) { return $array; }
            
            throw new UnexpectedValueException('Wather ForeCast Resource data is empty or null !'); 
        }
        
        /**
         * To get Weather Condition Raw Attributes
         * 
         * @return array|null
         * @throws \UnexpectedValueException
         */
        private function getWeatherConditionAttributes()
        {
            $key = 'weather_condition';

            $array =  $this->getKeyInWeatherCurrentRawData($key);        
            
            if ( !is_null($array) && is_array($array) && ! empty($array)) { return $array; }
            
            throw new UnexpectedValueException('Wather Condition data is empty or null !'); 
        } 
        
        /**
         * To get Weather Main Raw Attributes
         * 
         * @return array|null 
         */
        private function getWeatherMainAttributes()
        {          
            return $this->getKeyInWeatherCurrentRawData('weather_main');                            
        }  
        
        /**
         * To get Weather Wind Raw Attributes
         * 
         * @return array|null 
         */
        private function getWeatherWindAttributes()
        {          
            return $this->getKeyInWeatherCurrentRawData('weather_wind');                            
        }  
        
        /**
         * To get Weather Rain Raw Attributes
         * 
         * @return array|null 
         */
        private function getWeatherRainAttributes()
        {          
            return $this->getKeyInWeatherCurrentRawData('weather_rain');                            
        } 
        
        /**
         * To get Weather Snow Raw Attributes
         * 
         * @return array|null 
         */
        private function getWeatherSnowAttributes()
        {          
            return $this->getKeyInWeatherCurrentRawData('weather_snow');                            
        }  
        
        /**
         * To get Weather Clouds Raw Attributes
         * 
         * @return array|null 
         */
        private function getWeatherCloudsAttributes()
        {          
            return $this->getKeyInWeatherCurrentRawData('weather_clouds');                            
        }
        
        /**
         * To get Weather Current Source Update Date
         * 
         * @return string|null mysql timestamp format
         */
        private function getWeatherSourceUpdateDate()
        {          
            return $this->getKeyInWeatherCurrentRawData('source_updated_at');                            
        }
        
        
        /**
         * To get main, wind, rain, snow, clouds attributes in one array
         * 
         * @return array
         */
        protected function getMainAndWindAndRainAndSnowAndClouds()
        {
            return [
                
                $this->getWeatherMainAttributes(),
                $this->getWeatherWindAttributes(),
                $this->getWeatherRainAttributes(),
                $this->getWeatherSnowAttributes(),
                $this->getWeatherCloudsAttributes(),                
            ];
        }
                
        
        /**
         * To get value in WeatherCurrent Raw Data by given key
         * 
         * @param string $key
         * @param mixed $default
         * @return mixed|null
         */
        private function getKeyInWeatherCurrentRawData($key, $default=null)
        {
            return array_get($this->weatherCurrentRawData, $key, $default);             
        }

}