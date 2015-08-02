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
    * @return string   hashed class name
    * @throws Exception
    */
    function createUniqueKeyFromObj($object) {

        if (is_null($object) || !is_object($object)) {

            throw new Exception('Cache key is not genereted!, Parameter is invalid! Parameter must be Object');
        }

        $className = get_class($object);

        return md5($className);            
    }

}