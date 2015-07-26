<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\WeatherRain;


class WeatherRainTest extends TestCase
{
        
        /**
         * A basic functional test example.
         *
         * @return void
         */
        public function testSimple()
        {           
            $one = new WeatherRain();                     
        }


        public function testSimpleTwo() 
        {            
            $data =  [
                      'weather_current_id'    => null,
                      'weather_hourly_id'     => null,   
                      'weather_daily_id'      => null,             
                      '3h'                    => null,
                      'rain'                  => null,   
            ];
            
            $one = factory(App\WeatherRain::class)->make($data);       
            
            $this->assertEquals($data['weather_current_id'], $one['weather_daily_id']);
            $this->assertEquals($data['weather_hourly_id'], $one['weather_hourly_id']);
            $this->assertEquals($data['weather_daily_id'], $one['weather_daily_id']);
            $this->assertEquals($data['3h'], $one['3h']);  
            $this->assertEquals($data['rain'], $one['rain']); 
        }
        
        public function testWithFakerAttributes() 
        {                      
            $one = factory(App\WeatherRain::class)->make();       
            
            $this->assertNull($one['weather_daily_id']);
            
            $this->assertNotNull($one['3h']);        
        }
        
        /**
         * 
         * @param array $attributes
         * @return \App\WeatherRain
         */
        public function createNewWeatherRain(array $attributes=[])
        {
            return factory(App\WeatherRain::class)->make($attributes);           
        }
        
        
        public function testRelationSimple()
        {
            $one = $this->createNewWeatherRain();
            
            $this->assertInstanceOf('App\WeatherCurrent', $one->current()->getRelated());
        }     
        
}