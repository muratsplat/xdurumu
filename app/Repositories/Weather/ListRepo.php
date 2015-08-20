<?php

namespace App\Repositories\Weather;

use App\WeatherList;
use App\WeatherHourlyStat                       as HourlyStatModel;
use App\Weather\DailyStat                       as DailyStatModel;
use App\Repositories\CacheAble                  as CacheAble;
use App\Libs\Weather\DataType\WeatherList       as ListData;
use Illuminate\Contracts\Cache\Repository       as Cache;
use Illuminate\Contracts\Config\Repository      as Config;
use App\Libs\Weather\DataType\WeatherHourly     as HourlyData;
use App\Libs\Weather\DataType\WeatherDaily      as DailyData;
use App\Contracts\Weather\Repository\IList;
use App\Contracts\Repository\ICacheAble;
use App\Contracts\Weather\Repository\Condition  as ICondition;


/**
 * Weather Hourly Stats Repository Class
 * 
 * @package WeatherForcast
 */
class ListRepo extends CacheAble implements IList, ICacheAble
{    
    /**
     * @var \App\WeatherList
     */
    private $mainModel;    
    
    /**
     * @var \App\Contracts\Weather\Repository\Condition
     */
    private $condition;
    
        /**
         * Create new Instance
         * 
         * @param \Illuminate\Contracts\Cache\Repository $cache
         * @param \Illuminate\Contracts\Config\Repository $config
         * @param \App\WeatherList; 
         * @param \App\Contracts\Weather\Repository\Condition; 
         * 
         */
        public function __construct(Cache $cache, Config $config, WeatherList $list, ICondition  $condition)
        {
            parent::__construct($cache, $config);
            
            $this->mainModel    = $list;            
            
            $this->condition    = $condition;
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
         * To create many list by given daily model via the relationships
         * 
         * @param   \App\Weather\DailyStat                      $daily
         * @param   App\Libs\Weather\DataType\WeatherDaily      $data
         * @return  \Illuminate\Support\Collection    created WeatherList instances
         */
        public function createListsByDailyStat(DailyStatModel $daily, DailyData $data)
        {                        
            $results = $data->getList()->map(function(ListData $item) use($daily) {                
                
                $list = $this->createNewListByWeatherDailyStat($daily);                     
                  
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
         * @return array created or founded records
         */
        private function createWeatherConditions(WeatherList $list, ListData $data)
        {               
            $conditions = $data->getConditions();
            
            if ( $conditions->isEmpty()) { return; }   
            
            return $this->findOrCreateManyCondition($list, $conditions->toArray());
        }
        
        /**
         * To find or cerate many weather condition records
         * 
         * @param \App\WeatherList $list
         * @param array     $records
         * @return array    Instances         
         */
        private function findOrCreateManyCondition(WeatherList $list, array $records)
        {
            $instances      =  $this->condition->findOrCreateMany($records);      
            
            $conditionIds   = array_map(function($item){ return $item->id; }, $instances); 
            
            return $list->conditions()->sync($conditionIds, false);            
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
            $rain = $data->getRain();
          
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
         * To create new WeatherList model belongs to given WeatherHourlyStat Model
         * 
         * @param \App\Weather\DailyStat  $daily
         * @return \App\WeatherList
         */
        private function createNewListByWeatherDailyStat(DailyStatModel $daily)
        {
            return $daily->weatherLists()->create(array());          
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
        
        public function find($id)
        {
            ;
        }
        
        public function delete($cityID)
        {
            ;
        }
        
        /**
         * To get main model
         * 
         * @return App\WeatherList
         */
        public function getMainModel()
        {
            return $this->onModel();
        }
        
        public function update(array $current)
        {
            ;
        }   
      
        
        /**
         * To get all of model belongs to \App\WeatherHourlyStat
         * 
         * @return \Illuminate\Database\Eloquent\Collection
         */
        public function getAllHourlyList()
        {           
            return $this->onModel()->newQuery()->where('listable_type', 'App\WeatherHourlyStat')->get();
        }
        
        /**
         * To get all of model belongs to \App\WeatherDailyStat
         * 
         * @return \Illuminate\Database\Eloquent\Collection
         */
        public function getAllDailyList()
        {           
            return $this->onModel()->newQuery()->where('listable_type', 'App\Weather\DailyStat')->get();
        }
        
   
}