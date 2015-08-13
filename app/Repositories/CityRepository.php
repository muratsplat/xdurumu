<?php

namespace App\Repositories;

use App\City;
use App\Repositories\CacheAbleRepository as CacheAble;
use Illuminate\Contracts\Cache\Repository as Cache;
use \Illuminate\Contracts\Config\Repository as Config;


/**
 * City Repository Class
 * 
 * @package WeatherForcast
 */
class CityRepository extends CacheAble
{  
    
    /**
     * 
     * @var \App\City 
     */
    private $mainModel;
    
    /**
     * @var \Illuminate\Database\Query\Builder
     */
    private $queryBuilder;
    
    /**
     * @var \Illuminate\Database\Eloquent\Collection
     */
    private $all;
    
    

        /**
         * 
         * @param \Illuminate\Contracts\Cache\Repository $cache
         * @param \Illuminate\Contracts\Config\Repository $config
         */
        public function __construct(Cache $cache, Config $config, City $city)
        {
            parent::__construct($cache, $config);
            
            $this->mainModel    = $city;
        }
 
        
        public function create(array $current)
        {
            
            
        }        
        
        public function update($cityID, array $current)
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
        public function find($cityID)
        {           
            return $this->onModel()->find($cityID);
        }
        
        /**
         * To get model by given slug
         * 
         * @param string $citySlug
         * @return \App\City|null
         */
        public function findBySlug($citySlug)
        {            
            return $this->onModel()->findBySlug($citySlug);                      
        }        

        /**
         * To get main model which is injected
         * 
         * @return \App\City 
         */
        public function onModel() {
            
            return $this->mainModel;
        }
        
        /**
         * To get all models from cache drive
         * 
         * return \Illuminate\Database\Eloquent\Collection|static[]
         */
        public function onCache()
        {
            
        }
}
