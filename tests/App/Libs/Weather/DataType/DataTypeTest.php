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


            $this->assertFalse($current->isFilledRequiredElements());
            
            $failedElements = $current->getFailedElementKeys()->toArray();
            
            $this->assertTrue(in_array('city', $failedElements));
            $this->assertTrue(in_array('weather_condition', $failedElements));
            $this->assertTrue(in_array('weather_forecast_resource', $failedElements));
            $this->assertTrue(in_array('weather_main', $failedElements));
        }
        
        public function testSimpleWithRealData()
        {
            $dataCity   = [
                'id'        => 1, 
                'name'      => 'Gumushane', 
                'country'   => 'RT', 
                'latitude'  => 232.23, 
                'longitude' => 3231.12,
                ];
                        
            $city       = new City($dataCity);                       
         
            $this->assertTrue($city->isFilledRequiredElements());               
        }
        
        public function testisFilledRequiredElementsWithChildElements()
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
                'weather_wind'                  => 'foo',
                'weather_rain'                  => null,
                'weather_snow'                  => null,
                'weather_clouds'                => 'bar',       
                'source_updated_at'             => null,   
                ];
            
            
            $current = new WeatherCurrent($data);
      
            $this->assertFalse($current->isFilledRequiredElements());
            
            $failedElements = $current->getFailedElementKeys()->toArray();            
    
            $this->assertTrue(in_array('city', $failedElements));
            $this->assertTrue(in_array('weather_condition', $failedElements));
            $this->assertTrue(in_array('weather_forecast_resource', $failedElements));
            $this->assertTrue(in_array('weather_main', $failedElements));
            
            $this->assertEquals($data['weather_clouds'], $current->weather_clouds);
            $this->assertEquals($data['weather_clouds'], $current['weather_clouds']);
        }
        
        public function testToArray()
        {
            $cityData = [
                
                'id'        => 1, 
                'name'      => 'Gumushane', 
                'country'   => 'TR', 
                'latitude'  => 122.212, 
                'longitude' => 3332.32323,                
                ];
            
            $city       = new City($cityData);
            
            $this->assertTrue($city->isFilledRequiredElements());
            
            $conditionData = [
                
                'id'                => 212,             
                'orgin_name'        => 'yağmurlu',
                'orgin_description' => 'hava açık',   
                ];
            
            $condition  = new WeatherCondition($conditionData);           
            
            $mainData   = [
                
                'temp'          => 122,      
                'temp_min'      => 2323.1,
                'temp_max'      => 1212,                
                ];
            
            $main       = new WeatherMain($mainData);
            
            $sourceData = [
                'name'                  => 'Bilmem', 
                'url'                   => 'foo.com',
                'api_url'               => 'api.foo.com',                           
                'apiable'               => true,
                ];
            
            $source     = new WeatherForeCastResource($sourceData);
            
            $data = [      
                'city'                          => $city,
                'weather_condition'             => $condition,
                'weather_forecast_resource'     => $source,
                'weather_main'                  => $main,   
                'weather_wind'                  => 'foo',
                'weather_rain'                  => null,
                'weather_snow'                  => null,
                'weather_clouds'                => 'bar',    
                'weather_sys'                   => null,      
                'source_updated_at'             => null,   
                ];            
            
            $current = new WeatherCurrent($data);
            
            $this->assertTrue($current->isFilledRequiredElements());
            
            $toArray = $current->toArray();                  
            
            $this->assertCount(10, $toArray);
        }
        
        public function testGetValuesAndGetAttributes()
        {
            $cityData = [
                
                'id'        => 1, 
                'name'      => 'Gumushane', 
                'country'   => 'TR', 
                'latitude'  => 122.212, 
                'longitude' => 3332.32323,                
                ];
            
            $city       = new City($cityData);
            
            $attributes = $city->getAttributes();
            
            $values     = $city->getValues();
            
            $cityDataKeys = array_keys($cityData);
            
            $cityDataValues= array_values($cityData);
            
            $this->assertEquals($values, $cityDataValues);
            
            $this->assertEquals($attributes, $cityDataKeys);         
        }
        
        
}