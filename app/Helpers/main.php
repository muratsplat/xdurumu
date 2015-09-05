<?php

/**
 * All helpers will be defined into the file
 * 
 * @author Murat Ödünç <murat.asya@gmail.com>
 */


if (!function_exists('createUniqueKeyFromObj')) {
    
    /**
    * To get hashed keys by using class name of given object
    * 
    * @param Object $object
    * @param string dot nation  
    * @return string   hashed class name
    * @throws Exception
    */
    function createUniqueKeyFromObj($object, $dotNation=null) {

        if (is_null($object) || !is_object($object)) {

            throw new Exception('Cache key is not genereted!, Parameter is invalid! Parameter must be Object');
        }

        $className  = get_class($object);
        
        $mixes      = $className . $dotNation;
        
        return md5($mixes);            
    }

}

if (!function_exists('getProperty')) {    
    
    /**
     * To get property on given object
     * 
     * @param \stdClass $object
     * @param string $property
     * @param mixed $default
     * @return mixed
     */
    function getProperty(\stdClass $object, $property="", $default= null)                
    {            
        return isset($object->{$property}) ? $object->{$property} : $default;
    }
}


if (!function_exists('transDirectionFromNumber')) {    
    
    /**
     * To get property on given object
     * 
     * @param \stdClass $object
     * @param string $property
     * @param mixed $default
     * @return mixed
     */
    function transDirectionFromNumber($number)                
    {            
       /**
        * 
        * TODO
        * 
        * 
        * http://stackoverflow.com/questions/11526277/how-to-show-wind-direction-on-a-compass
        * http://climate.umn.edu/snow_fence/components/winddirectionanddegreeswithouttable3.htm
        */
        
    }
}


/**
 * All helpers will be defined into the file
 * 
 * @author Murat Ödünç <murat.asya@gmail.com>
 */

if ( ! function_exists('activeUrl'))
{
    /**
     * To determine given url  and if it is equals to current url
     * return css class name
     * 
     * This helper is useful  for selected "li" element in html.
     *
     * @param  string  $url
     * @param  string  $class default is null
     * @return string  return default class or given class name
     */
    function activeUrl($url, $class = null) {

        $class = is_null($class) ? 'active' : $class;

        return app('request')->url() === $url ? $class : null; 
    }
}
