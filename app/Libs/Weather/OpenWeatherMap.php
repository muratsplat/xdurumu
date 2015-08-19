<?php

namespace App\Libs\Weather;

use ErrorException;

use App\Libs\Weather\Convertors\OpenWeatherMap\Daily;
use App\Libs\Weather\Convertors\OpenWeatherMap\Hourly;
use App\Libs\Weather\Convertors\OpenWeatherMap\Current;


/**
 * An converter for  the JSON responses Open Weather Map API
 * 
 * @package WeatherForcast
 */
class OpenWeatherMap extends ApiAccessor
{          
    /**
     * Api Name
     *
     * @var string short version 
     */
    protected $apiName = 'openweathermap';

        /**
         * To get Weather Data Object
         * 
         * @return \App\Libs\Weather\DataType\WeatherDataAble
         */
        public function getWeatherData()
        {            
            $jsonObject = $this->getJsonObject();
            
            switch (true) {
                
                case $this->isCurrent() : return (new Current($jsonObject))->getWeatherData();
                    
                case $this->isHourly()  : return (new Hourly($jsonObject))->getWeatherData();
                
                case $this->isDaily()   : return (new Daily($jsonObject))->getWeatherData();
            }            
            
            throw new ErrorException('It should be selected a data type(currently, hourly, daily)'
                    . ' to get certain weather data object !');
            
        }
}

