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
         * To find condition if it is not exists, create one 
         * and return it. 
         *
         * @param   array $conditions
         * @return  \App\WeatherCondition
         */
        public function findOrNewConditions(array $conditions);      
      
        /**
         * To get weather forecast resource model and weather condition model
         * 
         * @return   \App\Libs\Weather\DataType\WeatherForecastResource
         */
        public function getForcastResource();
        
        /**
         * To get Weather Conditions
         * 
         * @return array
         */
        public function getConditions();
        
        
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