<?php

namespace App\Libs\Weather\DataType;

use UnexpectedValueException;
use ArrayAccess;
use Illuminate\Contracts\Support\Arrayable;


/**
 * An converter for  the JSON responses Open Weather Map API
 * 
 * @package WeatherForcast
 */
abstract class Base implements ArrayAccess, Arrayable
{    
    
    /**
     * Required Elements
     *
     * @var array
     */
    protected $required; 
    
    /**
     * All attributes
     * 
     * @var array 
     */
    protected $attributes;
    

        /**
         * Intance a City
         * 
         * @param array $attributes
         */
        public function __construct(array $attributes)
        {
            $this->importAttributes($attributes);
        }
        
        
        /**
         * To import array element to this object
         * 
         * @param array $attributes
         */
        protected function importAttributes(array $attributes)
        {
            foreach ($attributes as $key => $value) {
                
                $this->setAttribute($key, $value);
            }
            
        }        
        
        /**
         * To set attirbute by given key and value
         * 
         * @param mixed $key
         * @param mixed $value
         * @throws UnexpectedValueException
         */
        public function setAttribute($key, $value=null)
        {
            if (!$this->isKeyExist($key) ) {
                
                throw new UnexpectedValueException("'$key' element does not belong to City!");                
            }
            
            $this->checkRequiredElement($key, $value);                     
            
            $this->attributes[$key] = $value;
        }
        
        
         /**
         * To get attirbute by given key
         * 
         * @param mixed $key
         * @throws UnexpectedValueException
         */
        public function getAttribute($key)
        {
            if (!$this->isKeyExist($key) ) {
                
                throw new UnexpectedValueException("'$key' element does not belong to City!");                
            }              
            return $this->attributes[$key];
        }
        
        /**
         * To determine given key is required
         * 
         * @param mixed $key
         * @return bool
         */
        private function isRequiredElement($key)
        {
            return array_key_exists($key, $this->required);
        }
        
        /**
         * To determine given key is exist in city attributes
         * 
         * @param mixed $key
         * @return bool
         */
        private function isKeyExist($key)
        {
            return array_key_exists($key, $this->attributes);
        }
        
        /**
         * To determine required elements are filled.
         * 
         * @return bool
         */
        public function isFilledRequiredElements() 
        {
            $nullElements = array_filter($this->required, function($elem) {
                
                $value  = $this->getAttribute($elem);
                
                return is_null($value);                
            });            
            
            return empty($nullElements);            
        }
        
        /**
	 * Whether a offset exists
	 *
	 * @param mixed $offset	  An offset to check for.
	 *
	 * @return boolean <b>TRUE</b> on success or <b>FALSE</b> on failure.
	 *.
	 */
	public function offsetExists ($offset) 
        {
            return $this->isKeyExist($offset);
        }

	/** 
	 * Offset to retrieve
	 *
	 * @param mixed $offset <p>The offset to retrieve.
	 * @return mixed Can return all value types.
	 */
	public function offsetGet ($offset)
        {
            return $this->getAttribute($offset);
        }

	/**
	 * Offset to set
         * 
	 * @param mixed $offset  The offset to assign the value to.	
	 * @param mixed $value   The value to set.
	 * @return void No value is returned.
	 */
	public function offsetSet ($offset, $value) 
        {            
            $this->setAttribute($offset, $value);            
        }

	/**
	 * Offset to unset
         * 
	 * @param mixed $offset  The offset to unset.
	 * @return void No value is returned.
	 */
	public function offsetUnset ($offset) 
        {
            if ($this->isKeyExist($offset)) {
                
                $this->attributes[$offset] =null;   
            }
        }
        
        /**
        * Get the instance as an array.
        *
        * @return array
        */
       public function toArray()
       {
           $this->checkRequiredElements();

           return $this->attributes;
       }
       
       /**
        * To check required elements are filled
        * 
        * @throws UnexpectedValueException
        */
       protected function checkRequiredElements()
       {           
            foreach($this->required as $key => $value) {
               
                if ($this->checkRequiredElement($key, $value)) {
                
                    throw new UnexpectedValueException("'$key' element is required! Given value must not be null!");                
                }
           }
           
       }
       
        /**
        * To check given element are filled
        * 
        * @throws UnexpectedValueException
        */
        protected function checkRequiredElement($key, $value)
        {               
            if ($this->isRequiredElement($key) && is_null($value)) {

                throw new UnexpectedValueException("'$key' element is required! Given value must not be null!");                
            }
        }
}

