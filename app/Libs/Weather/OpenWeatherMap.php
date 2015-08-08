<?php

namespace App\Libs\Weather;

use ErrorException;
use Carbon\Carbon;

use App\Contracts\Weather\Accessor;
use App\Libs\Weather\DataType\City;
use App\Libs\Weather\DataType\WeatherMain;
use App\Libs\Weather\DataType\WeatherWind;
use App\Libs\Weather\DataType\WeatherRain;
use App\Libs\Weather\DataType\WeatherSnow;
use App\Libs\Weather\DataType\WeatherClouds;
use App\Libs\Weather\DataType\WeatherCurrent;
use App\Libs\Weather\DataType\WeatherCondition;
use App\Libs\Weather\DataType\WeatherForecastResource;
use App\Libs\Weather\DataType\WeatherSys;



/**
 * An converter for  the JSON responses Open Weather Map API
 * 
 * @package WeatherForcast
 */
class OpenWeatherMap extends JsonConverter implements Accessor
{          
    /**
     * Api Name
     *
     * @var string short version 
     */
    protected $apiName = 'openweathermap';
    
    /**
     * Weather Current Data 
     * 
     * All apies should implement this form !
     *
     * @var array 
     */
    protected $currentForm   = [
   
        'city'                          => null,
        'weather_condition'             => null,
        'weather_forecast_resource'     => null,
        'weather_main'                  => null,   
        'weather_wind'                  => null,
        'weather_rain'                  => null,
        'weather_snow'                  => null,
        'weather_clouds'                => null,
        'weather_sys'                   => null,
        'source_updated_at'             => null,      
    ];

        /**
         * To picker city attributes on JSON object
         * 
         * @return \App\Libs\Weather\DataType\WeatherDataAble city
         */
        protected function pickerCity()
        {           
            $jsonObject     = $this->getJSONInObject();
            
            return new City([
                
                'id'        => $jsonObject->id,
                'name'      => $jsonObject->name,
                'country'   => isset($jsonObject->sys->country) ? $jsonObject->sys->country : null,
                'latitude'  => isset($jsonObject->coord) ? $jsonObject->coord->lat : null,
                'longitude' => isset($jsonObject->coord) ? $jsonObject->coord->lon : null,                 
            ]);     
        }
        
        /**
         * To pick weather condition in json data
         * 
         * Example Weather : "weather":[{"id":804,"main":"clouds","description":"overcast clouds","icon":"04n"}]
         * 
         * @return \App\Libs\Weather\DataType\WeatherDataAble|null
         */
        protected function pickerWeatherCondition()
        {
            $weather     =  $this->getPropertyOnJSONObject('weather');
            
            if (empty($weather)) { return null; }
            
            $first      = head($weather);
            return new WeatherCondition([
                
                'open_weather_map_id'   => $first->id,
                'name'                  => $first->main,
                'description'           => $first->description,
                'orgin_name'            => $first->main,
                'orgin_description'     => $first->description,  
                'icon'                  => $first->icon,                   
            ]);
        }
        
        /**
         * Open Weather Map resource data
         * 
         * @return \App\Libs\Weather\DataType\WeatherDataAble
         */
        protected function pickerWeatherForecastResource()
        {
            return new WeatherForecastResource([        
                
                'name'                  => 'openweathermap',
                'description'           => 'Current weather conditions in cities for world wide',
                'url'                   => 'openweathermap.org',
                'api_url'               => 'api.openweathermap.org/data/2.5/weather',            
                'enable'                => 1,
                'paid'                  => 0,
                'apiable'               => true,
            ]);            
        }
        
        /**
         * Main Attributes        
         * 
         * @return \App\Libs\Weather\DataType\WeatherDataAble 
         */
        protected function pickerWeatherMain()
        {            
            if ( $this->isCurrent() ) {
                
                return new WeatherMain($this->mainForCurrent());           
            }           
         
            throw new ErrorException('It should be selected a data type(currently, hourly, daily)  to get "main" attributes !');
        }
        
        /**
         * Main Attributes for current weather json data
         * 
         * Example Data: 
         *       "main":{"temp":289.5,"humidity":89,"pressure":1013,"temp_min":287.04,"temp_max":292.04}
         * 
         * @return \App\Libs\Weather\DataType\WeatherDataAble|null
         */        
        private function mainForCurrent() 
        {
            $main =  $this->getPropertyOnJSONObject('main');
            
            if (empty($main)) { return null; }
            
            return [
                
                    'temp'          => getProperty($main, 'temp'),      
                    'temp_min'      => getProperty($main, 'temp_min'),            
                    'temp_max'      => getProperty($main, 'temp_max'),
                    'temp_eve'      => null,
                    'temp_night'    => null,
                    'temp_morn'     => null, 
                    'pressure'      => getProperty($main, 'pressure'),       
                    'humidity'      => getProperty($main, 'humidity'),
                    'sea_level'     => null,       
                    'grnd_level'    => null,
                    'temp_kf'       => null,  
            ];       
        }
        
        /**
         * To pick wind data 
         * 
         * Example Data: 
         *      "wind":{"speed":7.31,"deg":187.002}
         * 
         * @return \App\Libs\Weather\DataType\WeatherDataAble|null
         */
        protected function pickerWeatherWind()
        {
            $wind =  $this->getPropertyOnJSONObject('wind');
            
            if (empty($wind)) { return null; }
            
            return new WeatherWind([
                'speed'     => getProperty($wind, 'speed'),
                'deg'       => getProperty($wind, 'deg'),        
            ]);  
        }
        
        /**
         * Example Data:
         *   "rain":{"3h":0}
         * 
         * @return \App\Libs\Weather\DataType\WeatherDataAble
         */
        protected function pickerWeatherRain()
        {
            $rain =  $this->getPropertyOnJSONObject('rain');
            
            if (empty($rain) || $this->arePropertiesUndefined($rain, ['3h', 'rain'])) {
                
                return null;                 
            }
            
            return new WeatherRain([
                '3h'        => getProperty($rain, '3h'),
                'rain'      => null,  
            ]);            
        }        
        
        /**
         * Example Data: 
         *      snow":{"3h":1}
         * 
         * @return \App\Libs\Weather\DataType\WeatherDataAble
         */
        protected function pickerWeatherSnow()
        {
            $snow = $this->getPropertyOnJSONObject('snow');
            
            if (empty($snow) || $this->arePropertiesUndefined($snow, ['3h', 'snow'])) { 
                
                return null;                 
            }
            
            return new WeatherSnow([
                '3h'        => getProperty($snow, '3h'),
                'snow'      => null,  
            ]);   
            
        }
        
        /**
         * Example Data:
         *   "clouds":{"all":92},
         * 
         * @return \App\Libs\Weather\DataType\WeatherDataAble
         */
        protected function pickerWeatherClouds()
        {
            $cloud =  $this->getPropertyOnJSONObject('clouds');
            
            if (empty($cloud)) { return null; }
            
            return new WeatherClouds([
                
                'all'       => $cloud->all,
            ]);          
        }
        
       /**
         * Example Data:
         *   sys: {"country":"JP","sunrise":1369769524,"sunset":1369821049}
         * 
         * @return \App\Libs\Weather\DataType\WeatherDataAble
         */
        protected function pickerWeatherSys()
        {
            $sys =  $this->getPropertyOnJSONObject('sys');
            
            if (empty($sys)) { return null; }
            
            return new WeatherSys([
                
                'country'    => $sys->country,
                'sunrise'    => Carbon::createFromTimestamp($sys->sunrise)->format('Y-m-d H:m:s'),
                'sunset'     => Carbon::createFromTimestamp($sys->sunset)->format('Y-m-d H:m:s'),
            ]);          
        }
        
        /**
         * To picker download time 
         * 
         * @return string timestamp like 'Y-m-d H:m:s'
         */
        protected function pickerSourceUpdatedAt()
        {
            $dt =  $this->getPropertyOnJSONObject('dt');
            
            if (empty($dt)) { return null; }
            
            return Carbon::createFromTimestamp($dt)->format('Y-m-d H:m:s');    
        }
        
        /**
         * To get WeatherCurrent Data Object
         * 
         * @return \App\Libs\Weather\DataType\WeatherDataAble
         */
        public function getWeatherData()
        {            
            $this->callAllPickers();
            
            switch (true) {
                
                case $this->isCurrent() : return new WeatherCurrent($this->currentForm);               
            }            
            
            throw new ErrorException('It should be selected a data type(currently, hourly, daily)'
                    . ' to get certain weather data object !');
            
        }
}

