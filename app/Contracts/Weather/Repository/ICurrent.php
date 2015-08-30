<?php

namespace App\Contracts\Weather\Repository;


use App\Contracts\Weather\Repository\IBase;

/**
 * Current Repository Interface
 * 
 * @package WeatherForcast
 */
interface ICurrent extends IBase
{         
     
        /**
         * To get items randomly passed amount
         * 
         * @param int $count
         * @return array
         */
        public function takeRandomOnAll($count);
        
        /**
         * To get randomly items
         * 
         * @param int $amount
         * @return array
         */
        public function random($amount);
    
}