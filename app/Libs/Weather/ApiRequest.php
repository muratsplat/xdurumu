<?php

namespace App\Libs\Weather;

use App\City;
use App\Contracts\Weather\Accessor;
use App\WeatherForeCastResource as Source;
use LogicException;
use InvalidArgumentException;
use UnexpectedValueException;
use GuzzleHttp\Client;

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
    protected $selectedCity;
    
    /**
     * @var App\Contracts\Weather\Accessor
     */
    protected $accessor;
    
    /**
     *
     * @var type 
     */
    protected $httpClient;
    
    /**
     * Weather Forcast Source Model
     *
     * @var \App\WeatherForeCastResource 
     */
    protected $source;    
    
    /**
     * Timeout value 
     *
     * the unit is second
     * 
     * @var float 
     */
    protected $timeout = 5.0;
    
    /**
     * Float describing the number of seconds 
     * to wait while trying to connect to a server.     
     * 
     * @var float
     */
    protected $connectTimeout = 4.0;    
    
    /**
     * @var \GuzzleHttp\Client 
     */
    protected $client;
    
    /**
     * The number of milliseconds to delay before sending the request.
     *
     * @var integer 
     */
    protected $delay = 500; 
    
    /**
     * a url to access currently weather data from api 
     *
     * @var string 
     */
    protected $currentlyUrl;
    
    /**
     * a url to access hourly weather data from api 
     *
     * @var string 
     */
    protected $hourlyUrl;
    
    /**
     * a url to access daily weather data from api 
     *
     * @var string 
     */
    protected $dailyUrl;   
    
    /**
     * Queries
     * 
     * http://guzzle.readthedocs.org/en/latest/request-options.html#query
     *
     * @var array 
     */
    protected $queries;    
    
    /**
     * Laravel Log Service
     *
     * @var \Illuminate\Contracts\Logging\Log
     */
    protected $log;
    
        /**
         * Create a new Instance
         * 
         * @param \App\City
         * @param \App\Contracts\Weather\Accessor $source
         */
        public function __construct(Accessor $accessor , Source $source)
        {
            $this->accessor     = $accessor;
            
            $this->source       = $source;    
            
            $this->log          = \App::make('log');
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
        abstract public function sendRequest();
        
       /**
         * To select city for any crud job
         * 
         * @param   \App\City $city
         * @return  \App\Libs\Weather\ApiRequest
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
         * @param  string JSON data
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
        abstract public function getCityId();
        
        
        /**
         * To get timeout for waiting a respond
         * 
         * @return float
         */
        protected function getTimeout()
        {            
            if ( is_null($this->timeout)) {
                
                return 0;
            }
            
            return (float) $this->timeout;
        }
        
        /**
         * To get connection timeout for waiting a respond
         * 
         * @return float
         */
        protected function getConnectionTimeout()
        {            
            if ( is_null($this->connectTimeout)) {
                
                return 0;
            }
            
            return (float) $this->connectTimeout;
        }
        
        /**
         * To create Guzzle Client Instance
         * 
         * @param array $config
         * @return GuzzleHttp\Client;
         */
        protected function createNewClient(array $config=array())
        {            
            return new Client($config);
        }        
        
        /**
         * To get the url of api
         * 
         * @return string
         */
        public function getHostName()
        {
            return $this->getSource()->getAttribute('api_url');        
        }
        
        /**
         * To get source model to get the about information of api resource 
         * 
         * @return \App\WeatherForeCastResource 
         */
        public function getSource()
        {
            return $this->source;
        }        
        
        /**
         * To get City
         * 
         * @return \App\City
         * @throws \UnexpectedValueException
         */
        final public function getCity()
        {
            if (! is_null($this->selectedCity)) {
                
                return $this->selectedCity;                
            }
            
            throw new UnexpectedValueException('City model is not setted !');            
        }
        
        /**
         * To get delay time before sending request
         * 
         * @return int|null
         */
        public function getDelay()
        {
            return $this->delay;
        }
        
        /**
         * To get currently url
         * 
         * @return string
         * @throws \UnexpectedValueException
         */
        public function getCurrentlyUrl()
        {
            $url = $this->currentlyUrl;
            
            if (! is_null($url)) {
                
                return $url;
            }
            
            throw new UnexpectedValueException('Invalid url to access currently weather data! ');       
        }
        
        /**
         * To get hourly url
         * 
         * @return string
         * @throws \UnexpectedValueException
         */
        public function getHourlyUrl()
        {
            $url = $this->hourlyUrl;
            
            if (! is_null($url)) {
                
                return $url;
            }
            
            throw new UnexpectedValueException('Invalid url to access hourly weather data! ');       
        }
        
        /**
         * To get daily url
         * 
         * @return string
         * @throws \UnexpectedValueException
         */
        public function getDailyUrl()
        {
            $url = $this->dailyUrl;
            
            if (! is_null($url)) {
                
                return $url;
            }
            
            throw new UnexpectedValueException('Invalid url to access daily weather data! ');       
        }
        
        /**
         * To add query for client request
         * 
         * @param string $key
         * @param mixed $value
         */
        public function addQuery($key, $value = null)
        {            
            $this->queries[$key] = $value;        
        }
        
        /**
         * To get url
         * 
         * @return string
         * @throws \LogicException
         */
        public function getUrl()
        {
            switch(true) {
                
                case $this->isCurrent() : return $this->getCurrentlyUrl();
                    
                case $this->isDaily()   : return $this->getDailyUrl();
                    
                case $this->isHourly()  : return $this->getHourlyUrl();
            }
            
            throw new LogicException('Firsty should be select the type of weather data '
                    . 'like as "currently", "daily" and "hourly" !');
        }
}