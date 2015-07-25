<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
//use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\WeatherMain;


class WeatherMainTest extends TestCase
{  
        /**
         * A basic functional test example.
         *
         * @return void
         */
        public function testSimple()
        {           
            $one = new WeatherMain();                     
        }       
        
        public function testWithFakerAttributes() 
        {                                  
            $one = factory(App\WeatherMain::class)->make();                   
            $this->assertNull($one['weather_hourly_id']);            
            $this->assertNotNull($one['temp']);     
            $this->assertNotNull($one['temp_min']);     
        }
        
        
}