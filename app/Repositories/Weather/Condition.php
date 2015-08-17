<?php

namespace App\Repositories\Weather;

use App\WeatherCondition                                    as Model;
use App\Repositories\CacheAble                              as CacheAble;
use Illuminate\Contracts\Cache\Repository                   as Cache;
use Illuminate\Contracts\Config\Repository                  as Config;
use App\Contracts\Repository\ICacheAble;
use App\Contracts\Weather\Repository\Condition              as ICondition;

/**
 * Weather Conditions Repository Class
 * 
 * @package WeatherForcast
 */
class Condition extends CacheAble implements ICondition, ICacheAble
{    
    /**
     * @var \App\WeatherCondition 
     */
    private $mainModel;    
    
        /**
         * Create new Instance
         * 
         * @param \Illuminate\Contracts\Cache\Repository $cache
         * @param \Illuminate\Contracts\Config\Repository $config
         * @param \App\WeatherCondition; 
         */
        public function __construct(Cache $cache, Config $config, Model $condition)
        {
            parent::__construct($cache, $config);
            
            $this->mainModel    = $condition;            
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
         * To find models or if they are exists,  
         * create many models 
         * 
         * @param array     $records
         * @return array    Instances
         */
        public function findOrCreateMany(array $records)
        {
            return array_map(function($record) {
                
                $find = $this->findByName($record['name']);
                
                if ( ! is_null($find)) { return $find; }
                
                return $this->onModel()->create($record);
                
            }, $records);            
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
                
                return $this->onModel()->get();
            }); 
            
        }    
        
        /**
         * To find model by primary key
         * 
         * @param int id
         * @return \App\WeatherCondition|null
         */
        public function find($id)
        {
            return $this->onModel()->newQuery()->find($id);
        }        
        
        /**
         * To find model by name attribute
         * 
         * @param string id
         * @return \App\WeatherCondition|null
         */
        public function findByName($name)
        {
            return $this->onModel()->newQuery()->where('name', $name)->first();
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
}