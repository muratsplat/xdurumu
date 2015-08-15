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