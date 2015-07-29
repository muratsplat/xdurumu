<?php

namespace App\Libs\Weather;

use ErrorException;
use Carbon\Carbon;
/**
 * An converter for  the JSON responses Open Weather Map API
 * 
 * @package WeatherForcast
 */
class OpenWeatherMap extends JsonConverter
{    
    
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
        'source_updated_at'             => null,      
    ];

        /**
         * To picker city attributes on JSON object
         * 
         * @return array city
         */
        protected function pickerCity()
        {           
            $jsonObject     = $this->getJSONInObject();
            
            return [
                
                'id'        => $jsonObject->id,
                'name'      => $jsonObject->name,
                'country'   => isset($jsonObject->sys->country) ? $jsonObject->sys->country : null,
                'latitude'  => isset($jsonObject->coord) ? $jsonObject->coord->lat : null,
                'longitude' => isset($jsonObject->coord) ? $jsonObject->coord->lon : null,                 
            ];     
        }
        
        /**
         * To pick weather condition in json data
         * 
         * Example Weather : "weather":[{"id":804,"main":"clouds","description":"overcast clouds","icon":"04n"}]
         * 
         * @return array|null
         */
        protected function pickerWeatherCondition()
        {
            $weather     = $this->getJSONInObject()->weather;
            
            if (empty($weather)) { return null; }
            
            $first      = head($weather);
            return  [
                
                'id'                => $first->id,
                'name'              => $first->main,
                'description'       => $first->description,
                'orgin_name'        => $first->main,
                'orgin_description' => $first->description,  
                'icon'              => $first->icon,                   
            ];
        }
        
        /**
         * Open Weather Map resource data
         * 
         * @return array
         */
        protected function pickerWeatherForecastResource()
        {
            return [        
                
                'name'                  => 'openweathermap',
                'description'           => 'Current weather conditions in cities for world wide',
                'url'                   => 'openweathermap.org',
                'api_url'               => 'api.openweathermap.org/data/2.5/weather',            
                'enable'                => 1,
                'paid'                  => 0,
                'apiable'               => true,
            ];            
        }
        
        /**
         * Main Attributes        
         * 
         * @return array 
         */
        protected function pickerWeatherMain()
        {            
            if ( $this->isCurrent() ) {
                
                return $this->mainForCurrent();           
            }           
         
            throw new ErrorException('It should be selected a data type(currently, hourly, daily)  to get "main" attributes !');
        }
        
        /**
         * Main Attributes for current weather json data
         * 
         * Example Data: 
         *       "main":{"temp":289.5,"humidity":89,"pressure":1013,"temp_min":287.04,"temp_max":292.04}
         * 
         * @return array|null
         */        
        private function mainForCurrent() 
        {
            $main = $this->getJSONInObject()->main;
            
            if (empty($main)) { return null; }
            
            return [
                
                    'temp'          => $main->temp,      
                    'temp_min'      => $main->temp_min,            
                    'temp_max'      => $main->temp_max,
                    'temp_eve'      => null,
                    'temp_night'    => null,
                    'temp_morn'     => null, 
                    'pressure'      => $main->pressure,       
                    'humidity'      => $main->humidity,
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
         * @return array
         */
        protected function pickerWeatherWind()
        {
            $wind = $this->getJSONInObject()->wind;
            
            if (empty($wind)) { return null; }
            
            return [
                'speed'     => $wind->speed,
                'deg'       => $wind->deg,        
            ];  
        }
        
        /**
         * Example Data:
         *   "rain":{"3h":0}
         * 
         * @return array
         */
        protected function pickerWeatherRain()
        {
            $rain = $this->getJSONInObject()->rain;
            
            if (empty($rain)) { return null; }
            
            return [
                '3h'        => $rain->{'3h'},
                'rain'      => null,  
            ];            
        }        
        
        /**
         * Example Data: 
         *      snow":{"3h":1}
         * 
         * @return array
         */
        protected function pickerWeatherSnow()
        {
            $snow = $this->getJSONInObject()->snow;
            
            if (empty($snow)) { return null; }
            
            return [
                '3h'        => $snow->{'3h'},
                'snow'      => null,  
            ];   
            
        }
        
        /**
         * Example Data:
         *   "clouds":{"all":92},
         * 
         * @return array
         */
        protected function pickerWeatherClouds()
        {
            $cloud = $this->getJSONInObject()->clouds;
            
            if (empty($cloud)) { return null; }
            
            return [
                
                'all'       => $cloud->all,
            ];          
        }
        
        /**
         * To picker download time 
         * 
         * @return string timestamp like 'Y-m-d H:m:s'
         */
        protected function pickerSourceUpdatedAt()
        {
            $dt = $this->getJSONInObject()->dt;
            
            if (empty($dt)) { return null; }
            
            return Carbon::createFromTimestamp($dt)->format('Y-m-d H:m:s');    
        }
}

