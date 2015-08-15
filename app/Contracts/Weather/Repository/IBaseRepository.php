<?php

namespace App\Contracts\Weather\Repository;

/**
 * Base Repository Interface
 * 
 * @package WeatherForcast
 */
interface IBaseRepository{        
    
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
         * @param int $id
         * @return \App\WeatherForeCastResource|null
         */
        public function find($id); 
        
        
        public function update(array $current);     

        /**
         * To get Weather Current model
         * 
         * @return \Illuminate\Database\Eloquent\Model
         */
        public function getMainModel();         
        
        
        public function delete($cityID);   
    
    
}