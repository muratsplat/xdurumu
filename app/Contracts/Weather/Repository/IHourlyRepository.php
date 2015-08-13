<?php

namespace App\Contracts\Weather\Repository;

/**
 * Current Repository Interface
 * 
 * @package WeatherForcast
 */
interface IHourlyRepository extends IBaseRepository
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
         * To get Weather Current model
         * 
         * @return \App\WeatherHourlyStat
         */
        public function getMainModel();        
    
}