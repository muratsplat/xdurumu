<?php

namespace App\Repositories\Weather;

use App\WeatherCurrent as Current;

/**
 * Current Repository Class
 * 
 * @package WeatherForcast
 */
class CurrentRepository 
{    
    /**
     * @var \App\WeatherCurrent 
     */
    private $current;
    
    
        /**
         * Constructer
         * 
         * @param App\WeatherCurrent $current
         */
        public function __construct(Current $current)
        {
            $this->current      = $current;        
        }       
        
        public function create(){}        
        
        public function update(){}
        
        public function delete(){}
        
        public function find(){}
        
        public function findByCity(){}
        
        public function all(){}
        
        
        
        
        
    
    
  
}
