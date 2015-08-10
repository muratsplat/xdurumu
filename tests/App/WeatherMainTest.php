<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\WeatherMain;


class WeatherMainTest extends TestCase
{  
    
    use DatabaseMigrations, DatabaseTransactions;    

    
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
        
        /**
         * 
         * @param array $attributes
         * @return App\WeatherMain
         */
        public function createNewWeatherMain(array $attributes=[])
        {
            return factory(App\WeatherMain::class)->make($attributes);            
        }
        
        public function testRelationSimple()
        {            
            $one = $this->createNewWeatherMain();
            
            $this->assertInstanceOf('App\WeatherCurrent', $one->current()->getRelated());
                  
            $this->assertInstanceOf('App\WeatherHourlyStat', $one->hourlyStat()->getRelated());
        }
        
        public function testSimpleCRUD()
        {
            $one = $this->createNewWeatherMain();
            
            $this->assertTrue($one->save());
            
        }
        
}