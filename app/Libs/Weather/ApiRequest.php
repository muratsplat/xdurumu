<?php

namespace App\Libs\Weather;

use App\City;
use App\Contracts\Weather\Accessor;
use LogicException;
use InvalidArgumentException;


/**
 * An converter for  the JSON responses Open Weather Map API
 * 
 * @package WeatherForcast
 */
abstract class ApiRequest
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
     * Host url 
     * 
     * @var string
     */
    protected $host;
    
    /**
     * @var \App\City 
     */
    private $selectedCity;
    
    /**
     * @var App\Contracts\Weather\Accessor
     */
    private $accessor;


        /**
         * Create a new Instance
         * 
         * @param App\City
         * @param string $hostname url of api
         */
        public function __construct(Accessor $accessor)
        {
            $this->accessor     = $accessor;             
        }        
        
        /**
         * Create a new Instance
         * 
         * @param  string $hostname url of api
         * @return \static
         */
        public function createNewInstance()
        {
            $accessor  = $this->getAccessor();
            
            return new static($accessor);
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
         * To get JSON Data in pobject
         * 
         * @return \stdClass
         */
        protected function getJSONInObject()
        {            
            return $this->jsonObject;
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
         * To set the url of host
         * 
         * @param string $url
         * @throws InvalidArgumentException
         */
        public function setHost($url)
        {
            if (! is_null($url)) {
                
               $this->host = $url;
            }
            
            throw new InvalidArgumentException('Given value is null');
        }
        
        /**
         * To send request to read source
         * 
         * @return \App\Contracts\Weather\Accessor
         */
        public function sendRequest()
        {
            $json=  '{
                    "coord":{"lon":139,"lat":35},
                    "sys":{"country":"JP","sunrise":1369769524,"sunset":1369821049},
                    "weather":[{"id":804,"main":"clouds","description":"overcast clouds","icon":"04n"}], 
                    "main":{
                                    "temp":289.5,
                                    "humidity":89,
                                    "pressure":1013,
                                    "temp_min":287.04,
                                    "temp_max":292.04
                                    },
                    "wind":{"speed":7.31,"deg":187.002}, 
                    "rain":{"3h":0},
                    "snow":{"3h":1},
                    "clouds":{"all":92},
                    "dt":1369824698,
                    "id":1851632,
                    "name":"Shuzenji",
                    "cod":200
                }';
            
            return $this->createNewAccessor($json);
        }
        
       /**
         * To select city for any crud job
         * 
         * @param   \App\City $city
         * @return  \App\Repositories\Weather\CurrentRepository
         */
        final public function selectCity(City $city)
        {
            $this->selectedCity = $city;            
          
            if ($city->exists) {
                
                return $this;               
            }
            
            throw new UnexpectedValueException("Given App\City model is not saved on db!");
        }
        
        /**
         * To get injected accessor
         * 
         * @return \App\Contracts\Weather\Accessor
         */
        public function getAccessor()
        {            
            return $this->accessor;
        }
        
        /**
         * To create new accessor instance
         * 
         * @return \App\Contracts\Weather\Accessor
         */
        public function createNewAccessor($json)
        {                        
            switch (true) {
                
                case $this->isCurrent() : 
                    
                    return $this->getAccessor()->current()->createNewInstance($json);
                    
                case $this->isDaily()   :
                    
                    return $this->getAccessor()->daily()->createNewInstance($json);
                
                case $this->isHourly()  : 
                    
                    return $this->getAccessor()->hourly()->createNewInstance($json);
            }      
            
            throw new LogicException('It should be select any weather data type!');        
        }
        
        /**
         * To determine any city is selected.
         * 
         * @return bool
         */
        protected function isCitySelected()
        {
            return (! is_null($this->selectedCity)) && (is_object($this->selectedCity));
        }
        
        /**
         * To get City id
         * 
         * @return int
         */
        public function getCityId()
        {
            
        }
}