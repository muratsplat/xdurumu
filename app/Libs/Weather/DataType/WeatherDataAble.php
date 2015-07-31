<?php

namespace App\Libs\Weather\DataType;

use ArrayAccess;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Weather Data Interface
 * 
 * @package WeatherForcast
 */
interface  WeatherDataAble extends ArrayAccess, Arrayable
{   
   
        /**
         * To set attirbute by given key and value
         * 
         * @param mixed $key
         * @param mixed $value
         * @throws UnexpectedValueException
         */
        public function setAttribute($key, $value=null);       
        
         /**
         * To get attirbute by given key
         * 
         * @param mixed $key
         * @throws UnexpectedValueException
         */
        public function getAttribute($key);     
        
        /**
         * To determine required elements are filled.
         * 
         * @return bool
         */
        public function isFilledRequiredElements();       
 
        /**
         * To failed elements key in a collection
         * 
         * @return  \Illuminate\Support\Collection 
         */
        public function getFailedElementKeys();
        
        /**
         * Dynamically retrieve attributes on the object
         * 
         * @param mixed $key
         * @return mixed
         */
        public function __get($key);
        
        /**
         * Dynamically set attribute on the object
         * 
         * @param mixed $name
         * @param mixed $value
         */
        public function __set($name, $value);
        
        /**
         * Determine if the given attribute exists.
         * 
         * @param mixed $name
         */
        public function __isset($name);
        
        /**
         * To get only values
         * 
         * @return array
         */
        public function getValues();
        
        /**
         * To get only values
         * 
         * @return array
         */
        public function getAttributes();
}