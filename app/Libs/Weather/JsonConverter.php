<?php

namespace App\Libs\Weather;

use LogicException;
use InvalidArgumentException;
use RuntimeException;


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
     * Api Name
     *
     * @var string short version 
     */
    protected $apiName;    
    
    /**
     * The data what converting from stdObject will save in the property
     * 
     * @var array
     */
    protected $convertedData = [];


        /**
         * Create a new Instance
         * 
         * @param string $json JSON Object
         */
        public function __construct($json=null)
        {           
            $this->jsonObject = $json;
        }    
      
        /**
         * To export JSON Object
         * 
         * @return array
         * @throws LogicException
         */
        public function export()
        {           
            $this->callAllPickers();         
         
            return $this->getConvertedData();
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
            
                $this->setAttributeOnConvertedData($key, $value);               
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
         * To set convertedData property
         * 
         * @param string $key
         * @param mixed $value
         * @return void
         * @throws InvalidArgumentException
         */
        protected function setAttributeOnConvertedData($key, $value)
        {
            if ($this->isKeyExist($key)) {
                
                $this->convertedData[$key] = $value;                
                
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
            return !is_null($key) && array_key_exists($key, $this->convertedData);
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
         * To get converted data 
         * 
         * @return array
         */
        protected function getConvertedData()
        {            
            return $this->convertedData;
        }
        
        /**
         * To get given property value
         * 
         * @param string $property
         * @return mixed|null
         */
        protected function getPropertyOnJSONObject($property)
        {
            return  isset($this->getJSONInObject()->{$property}) ? $this->getJSONInObject()->{$property} : null ;
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
         * Determine If given properties  are undefined.
         * 
         * @param \stdClass $object
         * @param array $properties
         * @return boolean
         */
        protected function arePropertiesUndefined(\stdClass $object, array $properties)
        {        
            foreach ($properties as $property)
            {
                if ( isset($object->$property)) {
                    
                    return false;          
                }                
            }           
            
            return true;
        }
        
        /**
         * To get Weather data object
         * 
         * 
         * @return \App\Libs\Weather\DataType\DataAble
         */
        abstract public function getWeatherData();     
        
        /**
         * To check what wanted json data to converts
         * 
         * @throws \RuntimeException
         */
        public function checkDataValid()
        {
            $cod = $this->getPropertyOnJSONObject('cod');
            
            if ( is_null($cod) || (integer) $cod !== 200) {
                
                throw new RuntimeException('JSON data is empty or the resource is not found! ');                
            }       
        }

}