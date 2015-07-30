<?php

namespace App\Libs\Weather\DataType;

use UnexpectedValueException;
use Illuminate\Support\Collection;


/**
 * An converter for  the JSON responses Open Weather Map API
 * 
 * @package WeatherForcast
 */
abstract class Base implements WeatherDataAble
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
     * Not filled elements will be added this array
     *
     * @var \Illuminate\Support\Collection 
     */
    private $notFilledElements;   

        /**
         * Intance a City
         * 
         * @param array $attributes
         */
        public function __construct(array $attributes)
        {
            $this->importAttributes($attributes);
            
            $this->notFilledElements = new Collection();
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
            $name = get_class($this);
            
            if (!$this->isKeyExist($key) ) {
                
                throw new UnexpectedValueException("'$key' element does not belong to '$name' !");                
            }
            
            if ($this->isPassedRequiredElement($key, $value)) {
                
                $this->attributes[$key] = $value;    
                 
                return;
            }                    
            
            throw new UnexpectedValueException("'$key' element is required. It can not be null!");     
           
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
                
                $class = $this->getClassName();
                
                throw new UnexpectedValueException("'$key' element does not belong to '$class' !");                
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
            return in_array($key, $this->required);
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
            foreach ($this->required as $key) {
                
                $value  = $this->getAttribute($key);
            
                if (! $this->isPassedRequiredElement($key, $value)) {                                      
                  
                    $this->addFailedKey($key);                         
                }
                // if it is not object, it is impossible be ant DataType object!
                if( ! is_object($value)) { continue; }                
                
                // if the object is, it is impossible be ant DataType object!                
             
                if ( $value instanceof self && ! $value->isFilledRequiredElements()) {
                    
                    $this->addFailedKey($key);                          
                }            
                  
            }
            
            return $this->isEmptyfailedCollection();
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
           
           $elems = []; 
           
           foreach ((array)$this->attributes as $key => $value) {
               
               if (is_object($value) && $value instanceof self) {
                   
                   $elems[$key] = $value->toArray();
                   
                   continue;
               }
               
               $elems[$key] = $value;
           }
           
           return $elems;

       }
       
       /**
        * To check required elements are filled
        * 
        * @throws UnexpectedValueException
        */
       protected function checkRequiredElements()
       {            
            if (! $this->isFilledRequiredElements()) {

                throw new UnexpectedValueException(
                        "All required element is not filled! "
                        . "The values of required elements must not be null!");                
            }                       
       }
       
        /**
        * To check given element are filled
        * 
        * @param mixed $key element key
        * @param mixed $value element value
        * @return bool if it is passed, return true, or not false 
        */
        protected function isPassedRequiredElement($key, $value)
        {          
            return $this->isRequiredElement($key) && is_null($value) ? false : true;
        }
        
        /**
         * To add failed key to collection
         * 
         * @param mixed $key
         * @return void
         */
        private function addFailedKey($key)
        {
            $this->notFilledElements->push($key);
        }
        
        /**
         * To determine failed element collection is empty
         * 
         * @return bool
         */
        private function isEmptyfailedCollection()
        {
            return $this->notFilledElements->isEmpty();           
        }
        /**
         * To failed elements key in a collection
         * 
         * @return  \Illuminate\Support\Collection 
         */
        public function getFailedElementKeys()
        {
            return $this->notFilledElements;
        }
        
        /**
         * Dynamically retrieve attributes on the object
         * 
         * @param mixed $key
         * @return mixed
         */
        public function __get($key)
        {
           return $this->getAttribute($key);
        }
        
        /**
         * Dynamically set attribute on the object
         * 
         * @param mixed $name
         * @param mixed $value
         */
        public function __set($name, $value)
        {
            $this->setAttribute($name, $value);
        }
        
        /**
         * Determine if the given attribute exists.
         * 
         * @param mixed $name
         */
        public function __isset($name)
        {
            $this->isKeyExist($name);
        }

}

