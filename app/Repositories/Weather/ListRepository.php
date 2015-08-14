<?php

namespace App\Repositories\Weather;

use App\Libs\Weather\DataType\WeatherHourly     as HourlyData;
use App\WeatherHourlyStat                       as HourlyStatModel;
use App\WeatherList;
use App\Libs\Weather\DataType\WeatherList       as ListData;
use App\Repositories\CacheAbleRepository        as CacheAble;
use Illuminate\Contracts\Cache\Repository       as Cache;
use Illuminate\Contracts\Config\Repository      as Config;


//use ErrorException;

/**
 * Weather Hourly Stats Repository Class
 * 
 * @package WeatherForcast
 */
class ListRepository extends CacheAble
{    
    /**
     * @var \App\WeatherList
     */
    private $mainModel;    
    
        /**
         * Create new Instance
         * 
         * @param \Illuminate\Contracts\Cache\Repository $cache
         * @param \Illuminate\Contracts\Config\Repository $config
         * @param \App\WeatherList; 
         */
        public function __construct(Cache $cache, Config $config, WeatherList $list)
        {
            parent::__construct($cache, $config);
            
            $this->mainModel    = $list;            
        }    
    
        /**
         * To get main model which is injected
         * 
         * @return \Illuminate\Database\Eloquent\Model
         */
        public function onModel()
        {
            return $this->mainModel;            
        }        
        
        
        //    ["weather_conditions"]=>
//    array(6) {
//    ["open_weather_map_id"]=>
//    int(212)
//    ["name"]=>
//    NULL
//    ["description"]=>
//    NULL
//    ["orgin_name"]=>
//    string(9) "yağmurlu"
//    ["orgin_description"]=>
//    string(11) "hava açık"
//    ["icon"]=>
//    NULL
//    }
//    ["weather_main"]=>
//    array(11) {
//    ["temp"]=>
//    int(122)
//    ["temp_min"]=>
//    float(2323.1)
//    ["temp_max"]=>
//    int(1212)
//    ["temp_eve"]=>
//    NULL
//    ["temp_night"]=>
//    NULL
//    ["temp_morn"]=>
//    NULL
//    ["pressure"]=>
//    NULL
//    ["humidity"]=>
//    NULL
//    ["sea_level"]=>
//    NULL
//    ["grnd_level"]=>
//    NULL
//    ["temp_kf"]=>
//    NULL
//    }
//    ["weather_wind"]=>
//    NULL
//    ["weather_rain"]=>
//    NULL
//    ["weather_snow"]=>
//    NULL
//    ["weather_clouds"]=>
//    NULL
//    ["source_updated_at"]=>
//    string(3) "foo"
//    ["dt"]=>
//    int(2308)
        
        
        /**
         * To create many list by given hourly model via the relationships
         * 
         * @param   \App\WeatherHourlyStat                    $hourly
         * @param   \App\Libs\Weather\DataType\WeatherHourly    $data
         * @return  \Illuminate\Support\Collection    created WeatherList instances
         */
        public function createListsByHourlyStat(HourlyStatModel $hourly ,  HourlyData $data)
        {     
                        
            $results = $data->getList()->map(function(ListData $item) use($hourly) {                
                
                $list = $this->createNewListByWeatherHourlyStat($hourly);                     
                  
                $this->createWeatherMain($list, $item);                   
              
                $this->createWeatherConditions($list,$item );                
                  
                $this->createWeatherRain($list, $item);                   
               
                $this->createWeatherSnow($list, $item);                
                
                $this->createWeatherWind($list, $item);                                
                
                $this->createWeatherClouds($list, $item);        
                
                $list->date_time = $item->getSourceUpdatedAt();
                
                $list->dt = $item->getDt();
                
                if (!  $list->save()) {                    
                    
                    throw new \RuntimeException('WeatherList Model is not saved!');                  
                }
                
                return $list;
            });                 
            
            return $results;
            
           
        }
            
        /**
         * To create WeatherMain Model via given WeatherList model
         * 
         * @param \App\WeatherList $list
         * @param \App\Libs\Weather\DataType\WeatherMain
         * @return \App\WeatherMain
         */
        private function createWeatherMain(WeatherList $list, ListData $data)
        {        
            $main       = $data->getMain();
            
            $attributes = ! is_null($main)  && $main->isFilledRequiredElements() ? $main->toArray() : null;           
            
            if ( is_null($attributes) ) { return; }            
            
            return $list->main()->create($attributes);                 
        } 
        
        /**
         * To create WeatherCondition Model via given WeatherList model
         * 
         * @param \App\WeatherList $list
         * @param array  includes \App\Libs\Weather\DataType\WeatherCondition Object
         * @return \App\WeatherCondition
         */
        private function createWeatherConditions(WeatherList $list, ListData $data)
        {               
            $conditions = $data->getConditions();
            
            if ( $conditions->isEmpty()) { return; }   
            
            return $list->conditions()->createMany($conditions->toArray());                 
        }
        
        /**
         * To create WeatherRain Model via given WeatherList model
         * 
         * @param \App\WeatherList $list
         * @param \App\Libs\Weather\DataType\WeatherRain
         * @return \App\WeatherRain
         */
        private function createWeatherRain(WeatherList $list, ListData $data)
        {           
            $rain = $data->getMain();
            
            $attributes = ! is_null($rain) && $rain->isFilledRequiredElements() ? $rain->toArray() : null;           
            
            if ( is_null($attributes) ) { return; }            
            
            return $list->rain()->create($attributes);                 
        } 
        
        /**
         * To create WeatherSnow Model via given WeatherList model
         * 
         * @param \App\WeatherList $list
         * @param \App\Libs\Weather\DataType\WeatherSnow
         * @return \App\WeatherSnow
         */
        private function createWeatherSnow(WeatherList $list, ListData $data)
        {            
            $snow  = $data->getSnow();
            
            $attributes = ! is_null($snow) && $snow->isFilledRequiredElements() ? $snow->toArray() : null;           
            
            if ( is_null($attributes) ) { return; }            
            
            return $list->snow()->create($attributes);                 
        } 
        
        /**
         * To create WeatherWind Model via given WeatherList model
         * 
         * @param \App\WeatherList $list
         * @param \App\Libs\Weather\DataType\WeatherSnow
         * @return \App\WeatherWind
         */
        private function createWeatherWind(WeatherList $list, ListData $data)
        {            
            $wind       = $data->getWind();
            
            $attributes = ! is_null($wind) && $data->isFilledRequiredElements() ? $wind->toArray() : null;        
        
            if ( is_null($attributes) ) { return; }            
            
            return $list->wind()->create($attributes);                 
        } 
        
        /**
         * To create WeatherClouds Model via given WeatherList model
         * 
         * @param \App\WeatherList $list
         * @param \App\Libs\Weather\DataType\WeatherClouds
         * @return \App\WeatherClouds
         */
        private function createWeatherClouds(WeatherList $list, ListData $data)
        {           
            $clouds = $data->getClouds();
            
            $attributes = ! is_null($clouds) && $clouds->isFilledRequiredElements() ? $clouds->toArray() : null;           
            
            if ( is_null($attributes) ) { return; }            
            
            return $list->clouds()->create($attributes);                 
        }         
        
        /**
         * To create new WeatherList model belongs to given WeatherHourlyStat Model
         * 
         * @param \App\WeatherHourlyStat  $hourly
         * @return \App\WeatherList
         */
        private function createNewListByWeatherHourlyStat(HourlyStatModel $hourly)
        {
            return $hourly->weatherLists()->create(array());          
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
}