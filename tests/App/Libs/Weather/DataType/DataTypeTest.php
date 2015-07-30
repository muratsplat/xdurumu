<?php

use App\Libs\Weather\DataType\WeatherCurrent;
use App\Libs\Weather\DataType\City;
use App\Libs\Weather\DataType\WeatherCondition;
use App\Libs\Weather\DataType\WeatherForecastResource;
use App\Libs\Weather\DataType\WeatherMain;

/**
 * An converter for  the JSON responses Open Weather Map API
 * 
 * @package WeatherForcast
 */
class DataTypeTest extends \TestCase
{ 
    
        public function testSimple()
        {
            $current = new WeatherCurrent(array());

            $this->assertFalse($current->isFilledRequiredElements());
        }
        
        public function testIsFilledRequiredElements()
        {   
            
            $city       = new City(array());
            $condition  = new WeatherCondition(array());
            $main       = new WeatherMain(array());
            $source     = new WeatherForeCastResource(array());
            
            $data = [      
                'city'                          => $city,
                'weather_condition'             => $condition,
                'weather_forecast_resource'     => $source,
                'weather_main'                  => $main,   
                'weather_wind'                  => null,
                'weather_rain'                  => null,
                'weather_snow'                  => null,
                'weather_clouds'                => null,       
                'source_updated_at'             => null,   
                ];
            
            
            $current = new WeatherCurrent($data);

           // $this->assertFalse($current->isFilledRequiredElements());
        }
    
    
    
    

}

