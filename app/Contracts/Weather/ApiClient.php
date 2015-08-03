<?php

namespace App\Contracts\Weather;

use App\City;


/**
 * Weather Forecast API Interface
 * 
 * @package WeatherForcast
 */
interface  ApiClient
{    
        
        /**
         * Create a new Instance
         * 
         * @param  string $hostname url of api
         * @return \static
         */
        public function createNewInstance();
    
        
        /**
         * To select JSON data is current
         * 
         * @return \App\Contracts\Weather\ApiClient
         */
        public function current();
    
        
        /**
         * To select JSON data is hourly
         * 
         * @return \App\Contracts\Weather\ApiClient
         */
        public function hourly();
      
    
        /**
         * To select JSON data is daily
         * 
         * @return \App\Contracts\Weather\ApiClient
         */
        public function daily();        

        /**
         * To check data is current
         * 
         * @return bool
         */
        public function isCurrent();
        
        /**
         * To check data is hourly
         * 
         * @return bool
         */
        public function isHourly();
        
        /**
         * To check data is hourly
         * 
         * @return bool
         */
        public function isDaily();
        
       /**
         * To check data is unknown
         * 
         * @return bool
         */
        public function isUnknown(); 
        
     
        /**
         * To get Api name
         * 
         * @return $string
         */
        public function getApiName();
        
        /**
         * To set the url of host
         * 
         * @param string $url
         * @throws InvalidArgumentException
         */
        public function setHost($url);
        
        /**
         * To send request to read source
         * 
         * @return \App\Contracts\Weather\Accessor
         */
        public function sendRequest();
        
       /**
         * To select city for any crud job
         * 
         * @param   \App\City $city
         * @return  \App\Repositories\Weather\CurrentRepository
         */
        public function selectCity(City $city);
        
        /**
         * To get injected accessor
         * 
         * @return \App\Contracts\Weather\Accessor
         */
        public function getAccessor();
        
        /**
         * To create new accessor instance
         * 
         * @return \App\Contracts\Weather\Accessor
         */
        public function createNewAccessor($json);
      
        /**
         * To get City id
         * 
         * @return int
         */
        public function getCityId();
}