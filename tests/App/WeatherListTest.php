<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\WeatherList;


class WeatherListTest extends TestCase
{
        use DatabaseMigrations, DatabaseTransactions;

        /**
         * A basic functional test example.
         *
         * @return void
         */
        public function testSimple()
        {           
            $one = new WeatherList();                     
        }


        public function testRelationSimple()
        {
            $one = $this->createNewWeatherList();                    
            
            $this->assertInstanceOf('App\WeatherCondition', $one->conditions()->getRelated());  
            $this->assertInstanceOf('App\WeatherMain', $one->main()->getRelated());  
            $this->assertInstanceOf('App\WeatherWind', $one->wind()->getRelated());  
            $this->assertInstanceOf('App\WeatherRain', $one->rain()->getRelated());    
            $this->assertInstanceOf('App\WeatherCloud', $one->clouds()->getRelated());    
            $this->assertInstanceOf('App\WeatherSnow', $one->snow()->getRelated());  
            
        } 
        
        public function testcreateSimpleCRUD()
        {
            $one = $this->createNewWeatherList();
            
            $this->assertTrue($one->save());        
        }
        
        /**
         * 
         * @param array $attributes
         * @return \App\WeatherList
         */
        public function createNewWeatherList(array $attributes=[])
        {
            return factory(App\WeatherList::class)->make($attributes);           
        }       
        
}