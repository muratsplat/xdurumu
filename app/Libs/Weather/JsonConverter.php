<?php

namespace App\Libs\Weather;

use LogicException;
use InvalidArgumentException;


/**
 * An converter for  the JSON responses Open Weather Map API
 * 
 * @package WeatherForcast
 */
abstract class JsonConverter
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
         * 
         * @param string $json JSON Object
         * @param int $type
         */
        public function __construct($json=null)
        {
            $this->setJSONString($json);                
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
         * To call all picker metthods
         * 
         * @return void
         */
        final protected function callAllPickers()
        {
            foreach ($this->getPickerMethods() as $method) {
                
                $value  = $this->callPickerMethod($method);
                
                $key    = $this->parserKeyInPickerMethodName($method);
            
                $this->setAttributeOnCurrentForm($key, $value);               
            }          
        }
        
        /**
         * To recognize 'key' in picker method name
         * 
         * @param string $name
         * @return string
         * @throws InvalidArgumentException
         */
        protected function parserKeyInPickerMethodName($name='fooBar')
        {
            $snake_case     = snake_case($name);
            
            $segments       = explode('_', $snake_case);
            
            if (empty($segments)) {
                
               throw new InvalidArgumentException('Passed argument is not valid !');
            }            
            unset($segments[0]);         
        
            return $this->convertArrayToStingSnakeCase($segments);            
        }
        
        /**
         * To convert array elements to string with snake('_') case
         * 
         * @param array $segments
         * @return string
         */
        private function convertArrayToStingSnakeCase(array $segments)
        {
            if (count($segments) > 1) {
             
                
                return implode('_', $segments);
            }
            
            return last($segments);
        }
        
        
        /**
         * To set CurrentForm property
         * 
         * @param string $key
         * @param mixed $value
         * @return void
         * @throws InvalidArgumentException
         */
        protected function setAttributeOnCurrentForm($key, $value)
        {
            if ($this->isKeyExist($key)) {
                
                $this->currentForm[$key] = $value;                
                
                return;
            }
            
            throw new InvalidArgumentException("Given '$key' is not exist !");        
        }
        
        /**
         * To determine given key on CurrentForm property
         * 
         * @param string $key
         * @return boolen
         */
        protected function isKeyExist($key=null)
        {
            return !is_null($key) && array_key_exists($key, $this->currentForm);
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
            
            throw new InvalidArgumentException('JSON argument is not decoded !');      
        } 
        
        /**
         * To call given methods with parameters
         * 
         * @param string $method
         * @param array $words
         * @return mixed
         */
        protected function callPickerMethod($method) 
        {            
            return call_user_func_array([$this, $method], []);              
        }        
        
     
       /**
         * To get all picker methods in this object
         * 
         * @return array
         */
        protected function getPickerMethods() {
            
            $methods = get_class_methods($this);
            
            return array_filter($methods, function($item) {
                
                if(strpos($item, 'picker') ===0) {
                    
                    return true;
                }                
            });           
        }
        
        /**
         * 
         * @return array
         */
        protected function getCurrentForm()
        {            
            return $this->currentForm;
        }
    
}

