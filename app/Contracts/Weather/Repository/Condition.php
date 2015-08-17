<?php

namespace App\Contracts\Weather\Repository;


/**
 * Weather Condition Repository Interface
 * 
 * @package WeatherForcast
 */
interface Condition extends IBase
{ 
    
        /**
         * To find models or if they are exists,  
         * create many models 
         * 
         * @param array     $records
         * @return array    Instances
         */
        public function findOrCreateMany(array $records);
        
        /**
         * To find model by name attribute
         * 
         * @param string id
         * @return \App\WeatherCondition|null
         */
        public function findByName($name);

}