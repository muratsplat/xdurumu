<?php

use App\Libs\Weather\DataType\City;
use App\Libs\Weather\DataType\WeatherCondition;
use App\Libs\Weather\DataType\WeatherForecastResource;
use App\Libs\Weather\DataType\WeatherMain;
use App\Libs\Weather\DataType\WeatherDaily;
use App\Libs\Weather\DataType\WeatherList;

/**
 * An converter for  the JSON responses Open Weather Map API
 * 
 * @package WeatherForcast
 */
class DailyDataTypeTest extends \TestCase
{ 
    
        public function testSimple()
        {
            $current = new WeatherDaily(array());

            $this->assertFalse($current->isFilledRequiredElements());
        }
        
        public function testIsFilledRequiredElements()
        {   
            
            $city       = new City(array());
            $source     = new WeatherForecastResource(array());
            
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
            
            $current = new WeatherDaily($data);

            $this->assertFalse($current->isFilledRequiredElements());            
                    
            $failedElements = $current->getFailedElementKeys()->toArray();
            
            $this->assertTrue(in_array('city', $failedElements));                
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
                
                'temp'      => 293.51,
                'temp_min'  => 293.34,
                'temp_max'  => 293.51,
                'temp_night'=> 293.34,
                'temp_eve'  => 293.51,
                'temp_morn' => 293.51
                ];
            
            $main       = new WeatherMain($mainData);
            
            $data = [      
                    'weather_conditions'             => $condition,
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
                
                'temp'      => 293.51,
                'temp_min'  => 293.34,
                'temp_max'  => 293.51,
                'temp_night'=> 293.34,
                'temp_eve'  => 293.51,
                'temp_morn' => 293.51
                ];
            
            $main       = new WeatherMain($mainData);
            
            $data = [      
                    'weather_conditions'             => $condition,
                    'weather_main'                  => $main,   
                    'weather_wind'                  => null,
                    'weather_rain'                  => null,
                    'weather_snow'                  => null,
                    'weather_clouds'                => null,
                    'source_updated_at'             => 'foo',   
                    //'dt'                            => 'bar',     
                ];            
            
            $current = new WeatherList($data);
            $this->assertFalse($current->isFilledRequiredElements());          
        }       
}