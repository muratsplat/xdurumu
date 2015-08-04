<?php

namespace App\Contracts\Weather\Repository;

/**
 * Current Repository Interface
 * 
 * @package WeatherForcast
 */
interface ICurrentRepository
{        
      
        /**
         * To get weather forecast resource model and weather condition model
         * 
         * @return array    [\App\Libs\Weather\DataType\WeatherForecastResource, \App\Libs\Weather\DataType\WeatherCondition]
         */
        public function getForcastResourceAndCondition();
        
        
        public function update(array $current);
        
        public function delete($cityID);
        
        /**
         * To get all  of weather current time
         * 
         * @return \Illuminate\Database\Eloquent\Collection|static[]
         */
        public function all();
        
        /**
         * To get Weather Current model
         * 
         * @return \App\WeatherCurrent 
         */
        public function getMainModel();        
    
}