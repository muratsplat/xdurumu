<?php

namespace App\Contracts\Repository;


use App\City;


/**
 * Current Repository Interface
 * 
 * @package WeatherForcast
 */
interface ICityRepository extends ICacheAbleRepository
{   
    
        /**
         * To get first model  or create new instance model
         * 
         * @param \App\City     $city
         * @return \App\WeatherHourlyStat
         */
        public function firstOrCreateWeatherHouryStat(City $city);
        
        /**
         * To get first model or create new instance model
         * 
         * @param \App\City     $city
         * @return \App\WeatherCurrent  
         */
        public function firstOrCreateWeatherCurrent(City $city);
}