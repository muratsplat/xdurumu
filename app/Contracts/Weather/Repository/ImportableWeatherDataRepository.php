<?php

namespace App\Contracts\Weather\Repository;

use App\City;
use App\Contracts\Weather\Accessor;
use App\Libs\Weather\DataType\WeatherForecastResource;

/**
 *  An Interface WeatherData importable repository
 * 
 * @package WeatherForcast
 */
interface ImportableWeatherDataRepository
{  
        
        /**
         * To find WeatherForeCastResource model 
         * if it is not exists, create one and return it.
         * 
         * @param  \App\Libs\Weather\DataType\WeatherForecastResource $resource
         * @return \App\WeatherForeCastResource
         */
        public function findOrNewResource(WeatherForecastResource $resource);
        
        /**
         * To find condition if it is not exists, create one 
         * and return it. 
         *
         * @param   array $conditions
         * @return  \App\WeatherCondition
         */
        public function findOrNewConditions(array $conditions);
    
        /**
         * To select city for any crud job
         * 
         * @param   \App\City $city
         * @return  self
         */
        public function selectCity(City $city);       
                
        /**
         * To start all import proccess
         * 
         * @return \Illuminate\Database\Eloquent\Model
         * @throws \ErrorException
         */
        public function startImport();     
   
        /**
         * To import Weather Current data to data base
         * 
         * @param \App\Libs\Weather\DataType\WeatherDataAble $accessor
         * @return \Illuminate\Database\Eloquent\Model
         */
        public function import(Accessor $accessor);    
                
        /**
         * To get accessor
         * 
         * @return \App\Contracts\Weather\Accessor $accessor
         */
        public function getAccessor();
    
}