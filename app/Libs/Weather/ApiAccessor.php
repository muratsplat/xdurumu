<?php

namespace App\Libs\Weather;

use InvalidArgumentException;
use App\Contracts\Weather\Accessor;

/**
 * An converter for  the JSON responses Open Weather Map API
 * 
 * @package WeatherForcast
 */
abstract class ApiAccessor implements Accessor
{  
    
     /**
     * Response of the api
     *
     * @var \stdClass
     */
    protected $jsonObject;
    
    /**
     * Weather Data Type
     * 
     * @var int
     */
    protected $type   = 0; 
    
    /**
     * Weather Response Unknown Type
     * 
     * @static
     * @var int
     */
    const UNKNOWN    = 0;
    
    /**
     * Weather Response Current Type
     * 
     * @static
     * @var int
     */
    const CURRENT   = 1;
    
    /**
     * Weather Response Hourly Type
     * 
     * @static
     * @var int
     */
    const HOURLY    = 2;
    
    /**
     * Weather Response Daily Type
     * 
     * @static
     * @var int
     */    
    const DAILY     = 3;
    
    /**
     * Api Name
     *
     * @var string short version 
     */
    protected $apiName;
   

        /**
         * Create a new Instance
         * 
         * @param string $json JSON Object
         */
        public function __construct($json=null)
        {
            if (! is_null($json)) {
                
                $this->setJSONString($json);           
            }                        
        }        
        
        /**
         * To set JSON Object by decoding in string
         * 
         * @param string $string    Raw json in string
         * @return void
         * @throws \InvalidArgumentException
         */
        protected function setJSONString($string=null)
        {            
            $object = json_decode($string, false);
            
            if (is_object($object)) {
                
                $this->jsonObject = $object; 
                
                return;
            }
            
            throw new InvalidArgumentException('JSON argument is not decoded! '
                    . 'It can be invalid format to converting json object');      
        } 
        
        /**
         * Create a new Instance
         * 
         * @param string $json JSON Object
         * @return \static
         */
        public function createNewInstance($json)
        {
            $instance =  new static($json);
            
            switch (true)
            {
                case $this->isCurrent() : return $instance->current();
                case $this->isHourly()  : return $instance->hourly();    
                case $this->isDaily()   : return $instance->daily();    
            }
            
            return $instance;
        }
        
        /**
         * To select JSON data is current
         * 
         * @return \App\Libs\Weather\OpenWeatherMap
         */
        public function current()
        {
            $this->type = static::CURRENT;
            
            return $this;
        }
        
        /**
         * To select JSON data is hourly
         * 
         * @return \App\Libs\Weather\OpenWeatherMap
         */
        public function hourly()
        {
            $this->type = static::HOURLY;
            
            return $this;
        }
    
        /**
         * To select JSON data is daily
         * 
         * @return \App\Libs\Weather\OpenWeatherMap
         */
        public function daily()
        {
            $this->type = static::DAILY;
            
            return $this;
        }
        
        /**
         * To export JSON Object
         * 
         * @return array
         * @throws LogicException
         */
        public function export()
        {
            if ($this->isUnknown()) {                
                
                throw new LogicException('Data type must be selected!');               
            }
            
            $this->callAllPickers();         
         
            return $this->getCurrentForm();
        }
        
            /**
         * To check data is current
         * 
         * @return bool
         */
        public function isCurrent()
        {         
            return $this->type === static::CURRENT;
        }
        
        /**
         * To check data is hourly
         * 
         * @return bool
         */
        public function isHourly()
        {         
            return $this->type === static::HOURLY;
        }
        
        /**
         * To check data is hourly
         * 
         * @return bool
         */
        public function isDaily()
        {         
            return $this->type === static::DAILY;
        }
        
       /**
         * To check data is unknown
         * 
         * @return bool
         */
        public function isUnknown()
        {         
            return $this->type === static::UNKNOWN || $this->type > 3 ;
          
        }
        
        /**
         * To get Api name
         * 
         * @return $string
         */
        public function getApiName()
        {
            return $this->apiName;           
        }
        
        /**
         * To get json object which generates by json_decode
         * 
         * @return \stdClass
         */
        public function getJsonObject()
        {
            return $this->jsonObject;
        }
        
        /**
         * To get WeatherCurrent Data Object
         * 
         * @return \App\Libs\Weather\DataType\WeatherDataAble
         */
        abstract public function getWeatherData();
}

