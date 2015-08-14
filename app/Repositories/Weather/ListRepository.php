<?php

namespace App\Repositories\Weather;

use App\WeatherHourlyStat as Hourly;
//use App\WeatherCondition as Condition; 
use App\Libs\Weather\DataType\WeatherHourly as WeatherHourlyData;
use App\Libs\Weather\DataType\WeatherDataAble;

use App\WeatherList;
use App\Repositories\CacheAbleRepository as CacheAble;
use App\Libs\Weather\DataType\WeatherList as WeatherListData;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Config\Repository as Config;

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
         * @return  \App\WeatherList    created instances
         */
        public function createListByHourlyStat(Hourly $hourly , WeatherHourlyData $data)
        {            
            $list   = $this->createListByWeatherHourlyStat($hourly);     
            
            $records= [];
            
            $data->getList()->each(function(App\Libs\Weather\DataType\WeatherList $item) use($list, $records) {                
                
                $records[] = $this->createWearherMain($list, $item->getWeatherMain());   
                
                $records[] = $this->createWearherCondition($list, $item->getWatherConditions);
                
            });
            
            return $records;        
           
        }
            
        /**
         * To create WeatherMain Model via given WeatherList model
         * 
         * @param \App\WeatherList $list
         * @param \App\Libs\Weather\DataType\WeatherMain
         * @return \App\WeatherMain
         */
        private function createWearherMain(WeatherList $list, \App\Libs\Weather\DataType\WeatherMain $data)
        {            
            $attributes = $data->isFilledRequiredElements() ? $data->toArray() : null;           
            
            if ( is_null($attributes) ) { return; }            
            
            return $list->main()->create($attributes);                 
        } 
        
        /**
         * To create WeatherCondition Model via given WeatherList model
         * 
         * @param \App\WeatherList $list
         * @param \App\Libs\Weather\DataType\WeatherCondition
         * @return \App\WeatherCondition
         */
        private function createWearherCondition(WeatherList $list, \App\Libs\Weather\DataType\WeatherCondition $data)
        {            
            $attributes = $data->isFilledRequiredElements() ? $data->toArray() : null;           
            
            if ( is_null($attributes) ) { return; }            
            
            return $list->main()->createMany($attributes);                 
        } 
        
        /**
         * To create new WeatherList model belongs to given WeatherHourlyStat Model
         * 
         * @param \App\WeatherHourlyStat  $hourly
         * @return \App\WeatherList
         */
        private function createListByWeatherHourlyStat(Hourly $hourly)
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