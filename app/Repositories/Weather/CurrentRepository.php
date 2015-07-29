<?php

namespace App\Repositories\Weather;

use App\WeatherCurrent as Current;
use App\City;
use App\WeatherCondition as Condition; 
use LogicException;
use UnexpectedValueException;


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
     * For selected city
     * @var \App\City  
     */
    private $selectedCity;
    
    /**
     * Weather Current Data 
     * 
     * All apies should implement this form !
     *
     * @var array 
     */
    protected $attributesOfWeatherCurrent   = [
        
        // true ones are required...
        'city'                          => true,
        'weather_condition'             => true,
        'weather_forecast_resource'     => true,
        'weather_main'                  => true,   
        'weather_wind'                  => false,
        'weather_rain'                  => false,
        'weather_snow'                  => false,
        'weather_clouds'                => false,       
        'source_updated_at'             => false,      
    ];
    
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
    private $currentWeather;

        /**
         * Constructer
         * 
         * @param \App\WeatherCurrent   $current
         * @param \App\City             $city
         * @param \App\WeatherCondition $condition
         */
        public function __construct(Current $current, City $city, Condition $condition ) 
        {            
            $this->current      = $current;        
            
            $this->city         = $city;
            
            $this->condition    = $condition;
        }     
        
        


        
        public function create(array $current)
        {
            if (! $this->isCitySelected()) {                
                
                throw new LogicException('Fistly you should select a city via "selectCity()" method');         
            }
            
            $current = $this->selectedCity->weatherCurrent;
            
            if (! is_null($current)) {
                
                return $this->update($current);
            }
            
            
            
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
        
        
        protected function findOrCreateCondition($conditions)
        { 
           


        }
        
        /**
         * To find condition
         * 
         * @param int $id
         * @return \App\WeatherCondition|null 
         */
        private function findCondition($id)
        {
            return $this->getCondition()->query()->find($id);            
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
         * To set data for Weather Current Model
         * 
         * @param array $weatherCurrent
         */
        public function setCurrentData(array $weatherCurrent)
        {        
            $this->checkNeededAttributes($weatherCurrent);
            
            $this->currentWeather = $weatherCurrent;
        }        
        
        /**
         * To check needed attributes to store it as Weather Currrent models
         * 
         * @param array $attributes
         * @return void
         * @throws \UnexpectedValueException
         */
        private function checkNeededAttributes(array $attributes)
        {              
            $requiredKeys   = $this->getRequiredKeys();
            
            $notFounds      = array_filter($requiredKeys, function($key) use ($attributes) {
                
                return ! array_key_exists($key, $attributes);               
            });           
            
            if(empty($notFounds)) { return; }          
            
            $string = implode(',', $notFounds);                    
            
            throw new UnexpectedValueException("Required elements are missing: '$string'");    
        }
        
        /**
         * To get only required keys
         * 
         * @return array
         */
        private function getRequiredKeys()
        {            
            $attributes     = $this->attributesOfWeatherCurrent;
            
            $requiredElem   = array_filter($attributes, function($key, $value){
                
                return $value;
                
            });
            
            return array_keys($requiredElem);
        }
        
        
        
        
        
        
        
    
    
  
}
