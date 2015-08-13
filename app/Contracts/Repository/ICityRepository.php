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
         * To find model by primary key or create new instance model
         * 
         * @param \App\City     $city
         * @return \App\WeatherHourlyStat
         */
        public function findOrNewWeatherHouryStatByCity(City $city);
        
        /**
         * To find model by primary key or create new instance model
         * 
         * @param \App\City     $city
         * @return \App\WeatherCurrent  
         */
        public function findOrNewWeatherCurrent(City $city);
}