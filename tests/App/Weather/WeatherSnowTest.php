<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\WeatherSnow;


class WeatherSnowTest extends TestCase
{
        use DatabaseMigrations, DatabaseTransactions;

        /**
         * A basic functional test example.
         *
         * @return void
         */
        public function testSimple()
        {           
            $one = new WeatherSnow();                     
        }


        public function testSimpleTwo() 
        {            
            $data =  [
                      'weather_current_id'    => null,
                      'weather_hourly_id'     => null,          
                      '3h'                    => null,
                      'snow'                  => null,   
            ];
            
            $one = factory(App\WeatherSnow::class)->make($data);       
            
            $this->assertEquals($data['weather_current_id'], $one['weather_daily_id']);
            $this->assertEquals($data['weather_hourly_id'], $one['weather_hourly_id']);
            $this->assertEquals($data['3h'], $one['3h']);  
            $this->assertEquals($data['snow'], $one['snow']); 
        }
        
        public function testWithFakerAttributes() 
        {                                   
            $one = factory(App\WeatherSnow::class)->make();           
            $this->assertNull($one['weather_daily_id']);           
            $this->assertNotNull($one['3h']);        
        }
        
        /**
         * 
         * @param array $attributes
         * @return \App\WeatherSnow
         */
        public function createNewWeatherSnow(array $attributes=[])
        {
            return factory(App\WeatherSnow::class)->make($attributes);           
        }        
        
        public function testRelationSimple()
        {
            $one = $this->createNewWeatherSnow();
            
            //$this->assertInstanceOf('App\WeatherCurrent', $one->current()->getRelated());
            //$this->assertInstanceOf('App\WeatherHourlyStat', $one->hourlyStat()->getRelated());            
        } 
        
        public function createSimpleCRUD()
        {
            $one = $this->createNewWeatherSnow();
            
            $this->assertTrue($one->save());            
        }
                
        
}