<?php

use App\Libs\Weather\DataType\WeatherCurrent;
use App\Libs\Weather\DataType\City;
use App\Libs\Weather\DataType\WeatherCondition;
use App\Libs\Weather\DataType\WeatherForecastResource;
use App\Libs\Weather\DataType\WeatherMain;
use App\Libs\Weather\DataType\WeatherHourly;
use App\Libs\Weather\DataType\WeatherList;

/**
 * An converter for  the JSON responses Open Weather Map API
 * 
 * @package WeatherForcast
 */
class HourlyDataTypeTest extends \TestCase
{ 
    
        public function testSimple()
        {
            $current = new WeatherHourly(array());

            $this->assertFalse($current->isFilledRequiredElements());
        }
        
        public function testIsFilledRequiredElements()
        {   
            
            $city       = new City(array());
            $source     = new WeatherForeCastResource(array());
            
            $condition  = new WeatherCondition(array());
            $main       = new WeatherMain(array());
            $data = [      
                'city'                          => $city,             
                'weather_forecast_resource'     => $source,
                'list'                          => [
                    
                        [        
                            'weather_condition'             => $condition,
                            'weather_main'                  => $main,   
                            'weather_wind'                  => null,
                            'weather_rain'                  => null,
                            'weather_snow'                  => null,
                            'weather_clouds'                => null,
                            'source_updated_at'             => 12122,   
                            'dt'                            => "2012-12-1 00:00:00"
                        ],
                        
                        [        
                            'weather_condition'             => $condition,
                            'weather_main'                  => $main,   
                            'weather_wind'                  => null,
                            'weather_rain'                  => null,
                            'weather_snow'                  => null,
                            'weather_clouds'                => null,
                            'source_updated_at'             => 12122,   
                            'dt'                            => "2012-12-1 00:00:00"
                        ],
                    
                        [        
                            'weather_condition'             => $condition,
                            'weather_main'                  => $main,   
                            'weather_wind'                  => null,
                            'weather_rain'                  => null,
                            'weather_snow'                  => null,
                            'weather_clouds'                => null,
                            'source_updated_at'             => 12122,   
                            'dt'                            => "2012-12-1 00:00:00"
                        ],
                    
                        [        
                            'weather_condition'             => $condition,
                            'weather_main'                  => $main,   
                            'weather_wind'                  => null,
                            'weather_rain'                  => null,
                            'weather_snow'                  => null,
                            'weather_clouds'                => null,
                            'source_updated_at'             => 12122,   
                            'dt'                            => "2012-12-1 00:00:00"
                        ],                 
                    ]             
                ];            
            
            $current = new WeatherHourly($data);

            $this->assertFalse($current->isFilledRequiredElements());            
                    
            $failedElements = $current->getFailedElementKeys()->toArray();
            
            $this->assertTrue(in_array('city', $failedElements));       
            $this->assertTrue(in_array('weather_forecast_resource', $failedElements));       
        }
        
        public function testisFilledRequiredElementsWithChildElements()
        { 
            $conditionData = [
                
                'open_weather_map_id'   => 212,             
                'orgin_name'            => 'yağmurlu',
                'orgin_description'     => 'hava açık',   
                ];
            
            $condition  = new WeatherCondition($conditionData);    
            
            
            $mainData   = [
                
                'temp'          => 122,      
                'temp_min'      => 2323.1,
                'temp_max'      => 1212,                
                ];
            
            $main       = new WeatherMain($mainData);
            
            $data = [      
                    'weather_condition'             => $condition,
                    'weather_main'                  => $main,   
                    'weather_wind'                  => null,
                    'weather_rain'                  => null,
                    'weather_snow'                  => null,
                    'weather_clouds'                => null,
                    'source_updated_at'             => 'foo',   
                    'dt'                            => 'bar',     
                ];
            
            
            $current = new WeatherList($data);
      
            $this->assertTrue($current->isFilledRequiredElements());          
        }
        
        public function testisFilledRequiredElementsWithChildElementsEmpty()
        { 
            $conditionData = [
                
                'open_weather_map_id'   => 212,             
                'orgin_name'            => 'yağmurlu',
                'orgin_description'     => 'hava açık',   
                ];
            
            $condition  = new WeatherCondition($conditionData);    
            
            
            $mainData   = [
                
                'temp'          => 122,      
                'temp_min'      => 2323.1,
                'temp_max'      => 1212,                
                ];
            
            $main       = new WeatherMain($mainData);
            
            $data = [      
                    'weather_condition'             => $condition,
                    'weather_main'                  => $main,   
                    'weather_wind'                  => null,
                    'weather_rain'                  => null,
                    'weather_snow'                  => null,
                    'weather_clouds'                => null,
                    'source_updated_at'             => 'foo',                    
                ];            
            
            $current = new WeatherList($data);
      
            $this->assertFalse($current->isFilledRequiredElements());          
        }       
}