<?php

namespace App\Contracts\Weather;

use App\Contracts\ICacheAbleRepository as Cacheable;

/**
 * Weather ForeCast Resource Repository Interface
 * 
 */
interface IForecastResourceRepository extends Cacheable
{       
        /**
         * To get main model which is injected
         * 
         * @return \App\WeatherForeCastResource
         */
        public function onModel();
      
        /**
         * To get models from cache drive
         * 
         * return \Illuminate\Database\Eloquent\Collection|static[]
         */
        public function onCache();
        
        /**
         * To get all models
         * 
         * @param bool $cache
         * @return \Illuminate\Database\Eloquent\Collection|static[]
         */
        public function all();     
        
        /**
         * To find model by primary key
         * 
         * @param string $name
         * @return \App\WeatherForeCastResource|null
         */
        public function findByName($name);
}