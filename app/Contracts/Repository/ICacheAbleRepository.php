<?php

namespace App\Contracts\Repository;

/**
 * Weather ForeCast Resource Repository Interface
 */
interface ICacheAbleRepository
{   
        /**
         * To get main model which is injected
         * 
         * @return \Illuminate\Database\Eloquent\Model
         */
        public function onModel();  
        
        /**
         * To get all models from cache drive
         * 
         * return \Illuminate\Database\Eloquent\Collection|static[]
         */
        public function onCache();      
        
        /**
         * To set enable caching
         * 
         * @return \App\Repositories\CacheAbleRepository
         */
        public function enableCache();
      
        
        /**
         * To set disable caching
         * 
         * @return \App\Repositories\CacheAbleRepository
         */
        public function disableCache();
        
        /**
         * Determine if caching is enable
         * 
         * @return bool
         */
        public function isEnabledCache();
        
        /**
         * To get all models
         * 
         * @param bool $cache
         * @return \Illuminate\Database\Eloquent\Collection|static[]
         */
        public function all();     
        
        /**
         * To get cache repository
         * 
         * @return \Illuminate\Contracts\Cache\Repository
         */
        public function getCache(); 
        
        /**
         * To find model by primary key
         * 
         * @param int $id
         * @return \App\WeatherForeCastResource|null
         */
        public function find($id);
}