<?php

namespace App\Libs\Weather\Convertors\OpenWeatherMap;

use ErrorException;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Libs\Weather\JsonConverter;
use App\Libs\Weather\DataType\City;
use App\Libs\Weather\DataType\WeatherMain;
use App\Libs\Weather\DataType\WeatherWind;
use App\Libs\Weather\DataType\WeatherRain;
use App\Libs\Weather\DataType\WeatherSnow;
use App\Libs\Weather\DataType\WeatherDaily;
use App\Libs\Weather\DataType\WeatherList;
use App\Libs\Weather\DataType\WeatherClouds;
use App\Libs\Weather\DataType\WeatherCondition;
use App\Libs\Weather\DataType\WeatherForecastResource;

/**
 * An converter for  the JSON responses Open Weather Map API
 * 
 * @package WeatherForcast
 */
class Daily extends JsonConverter
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
    protected $convertedData   = [
   
        'city'                          => null,      
        'weather_forecast_resource'     => null,
        'list'                          => null,      
    ];
    
    /**
     * @var \Illuminate\Support\Collection
     */
    private $list;       
    
        /*
         * Create new instance
         * 
         * @param
         */
        public function __construct($json = null)
        {
            parent::__construct($json);

            $this->list = new Collection();        
        }

        /**
         * To picker city attributes on JSON object
         * 
         * @return \App\Libs\Weather\DataType\WeatherDataAble city
         */
        protected function pickerCity()
        {           
            $city     = $this->getPropertyOnJSONObject('city');
            
            return new City([
                
                'id'        => $city->id,
                'name'      => $city->name,
                'country'   => getProperty($city, 'country'),
                'latitude'  => getProperty($city->coord, 'lat'),
                'longitude' => getProperty($city->coord, 'lon'),                 
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
         * Open Weather Map resource data
         * 
         * @return \Illuminate\Support\Collection
         */
        protected function pickerList()
        {
            $list   = $this->getPropertyOnJSONObject('list');                       
            
            foreach ($list as $one) {
                
                $listOne = $this->createList($one);          
                
                $this->pushOneToList($listOne);
            }
            
            return $this->list;
        }
        
        /**
         * To create WeatherList
         * 
         * @param \stdClass $data
         * @return \App\Libs\Weather\DataType\WeatherList;
         */
        private function createList(\stdClass $data)
        {           
            $conditions = getProperty($data, 'weather');
            $main       = getProperty($data, 'temp');
            $dt         = getProperty($data, 'dt');            
            
            return new WeatherList([
                
                'weather_conditions'    => $this->createConditions($conditions),
                'weather_main'          => $this->createMain($main, $data),   
                'weather_wind'          => $this->createWind($data),
                'weather_rain'          => $this->createRain($data),
                'weather_snow'          => $this->createSnow($data),
                'weather_clouds'        => $this->createClouds($data),
                'source_updated_at'     => $this->createSourceUpdatedAt($dt),   
                'dt'                    => $dt,              
            ]);           
        }
        
        /**
         * To pick weather condition in json data
         * 
         * Example Weather : "weather":[{"id":804,"main":"clouds","description":"overcast clouds","icon":"04n"}]
         * 
         * @param array  $list
         * @return \Illuminate\Support\Collection
         */
        protected function createConditions(array $list)
        {
            $coll = new Collection();
            
            foreach ($list as $one) {
                
                $one = new WeatherCondition([
                
                        'open_weather_map_id'   => $one->id,
                        'name'                  => $one->main,
                        'description'           => $one->description,
                        'orgin_name'            => $one->main,
                        'orgin_description'     => $one->description,  
                        'icon'                  => $one->icon,                   
                    ]);
                
                $coll->push($one);
            }
            
            return $coll;
        }
        
        /**
         * Main Attributes        
         * 
         * @param   \stdClass       $main
         * @param   \stdClass       $list 
         * @return \App\Libs\Weather\DataType\WeatherDataAble 
         */
        protected function createMain(\stdClass $main, \stdClass $list)
        {                  
            return new WeatherMain([
                
                    'temp'          => getProperty($main, 'day'),      
                    'temp_min'      => getProperty($main, 'min'),
                    'temp_max'      => getProperty($main, 'max'),
                    'temp_eve'      => getProperty($main, 'eve'),
                    'temp_night'    => getProperty($main, 'night'),
                    'temp_morn'     => getProperty($main, 'morn'), 
                    'pressure'      => getProperty($list, 'pressure'),
                    'humidity'      => getProperty($list, 'humidity'),
                    'sea_level'     => null,     
                    'grnd_level'    => null,
                    'temp_kf'       => null,   
            ]);                       
        }
        
        /**
         * To pick wind data 
         * 
         * Example Data: 
         *      "wind":{"speed":7.31,"deg":187.002}
         * 
         * @param  mixed    $wind
         * @return \App\Libs\Weather\DataType\WeatherDataAble
         */
        protected function createWind($wind)
        {       
            if ($wind instanceof \stdClass) {
                
                return new WeatherWind([
                    'speed'     => getProperty($wind, 'speed'),
                    'deg'       => getProperty($wind, 'deg'),        
                ]);  
            }
        }
        
        /**
         * Example Data:
         *   "rain":{"3h":0}
         * 
         * @param  mixed    $rain
         * @return \App\Libs\Weather\DataType\WeatherDataAble|null
         */
        protected function createRain($rain)
        {                
            $value  = getProperty($rain, 'rain');
            
            if (! is_null($value)) {
                
                return new WeatherRain([
                    '3h'        => $value,
                    'rain'      => null,  
                    ]);             
            } 
            
            return;           
        }        
        
        /**
         * Example Data: 
         *      snow":{"3h":1}
         * 
         * @param  mixed    $snow
         * @return \App\Libs\Weather\DataType\WeatherDataAble
         */
        protected function createSnow($snow)
        {   
            $value = getProperty($snow, 'snow');
            
            if (! is_null($value)) {
                
                return new WeatherSnow([
                    
                    '3h'        => $value,
                    'snow'      => null,  
                ]);  
            }       
        }
        
        /**
         * Example Data:
         *   "clouds":{"all":92},
         * 
         * @param  mixed    $clouds
         * @return \App\Libs\Weather\DataType\WeatherDataAble
         */
        protected function createClouds($clouds)
        {        
            $value = getProperty($clouds, 'clouds');
            
            if ( ! is_null($value)) {
                
                return new WeatherClouds([

                    'all'       => $value,
                ]);   
            }            
        }    
        
        /**
         * To picker download time 
         * 
         * @param int  $dt  unix data time like as '1439629200'
         * @return string timestamp like 'Y-m-d H:m:s'
         */
        protected function createSourceUpdatedAt($dt)
        {
            return Carbon::createFromTimestamp($dt)->format('Y-m-d H:m:s');    
        }
        
        /**
         * To push list to list collection
         * 
         * @param \App\Libs\Weather\DataType\WeatherList $list
         * @return void
         */
        private function pushOneToList(WeatherList $list)
        {            
            $this->list->push($list);            
        }        
        
        /**
         * To get Converted Weather Data
         * 
         * @return \App\Libs\Weather\DataType\WeatherHourly
         */
        public function getWeatherData()
        {
            // This can throw an exception ıf data is invalid!
            $this->checkDataValid();
            
            $this->callAllPickers();
            
            $data = $this->getConvertedData();
            
            return new WeatherDaily($data);            
        }

}

