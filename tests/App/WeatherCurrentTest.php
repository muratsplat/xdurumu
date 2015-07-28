<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\WeatherCurrent;


class WeatherCurrentTest extends TestCase
{
        
        /**
         * A basic functional test example.
         *
         * @return void
         */
        public function testSimple()
        {           
            $one = new WeatherCurrent();                     
        }


        public function testSimpleTwo() 
        {            
            /**
             * Todos:
             *    - Model factoring should rewrite again to using models in relation
             */
            $data =  [
                    'city_id'                       => factory(\App\City::class)->make(),
                    'weather_conditions_id'         => factory(\App\WeatherCondition::class)->make(),
                    'weather_forecast_resource_id'  => factory(\App\WeatherForeCastResource::class)->make()->id,        
                    'enable'                        => (boolean) rand(0, 1),
                    'source_update_at'              => \Carbon\Carbon::createFromTimestampUTC(rand(1437814800, 1437914800))->format('Y-m-d H:m:s'),
            ];
            
            $one = $this->createNewWeatherCurrent($data); 
            
            $this->assertEquals($data['city_id'], $one['city_id']);
            $this->assertEquals($data['weather_conditions_id'], $one['weather_conditions_id']);
            $this->assertEquals($data['weather_forecast_resource_id'], $one['weather_forecast_resource_id']);
            $this->assertEquals($data['enable'], $one['enable']);  
            $this->assertEquals($data['source_update_at'], $one['source_update_at']);            
        }
        
        public function testWithFakerAttributes() 
        {            
                       
            $one = factory(App\WeatherCurrent::class)->make();      
        }
        
        public function testRelations() 
        {
            $one = $this->createNewWeatherCurrent();
            
            $this->assertInstanceOf('App\WeatherForeCastResource', $one->weatherForeCastResource()->getRelated());        
            $this->assertInstanceOf('App\City', $one->city()->getRelated());   
            $this->assertInstanceOf('App\WeatherCondition', $one->condition()->getRelated());  
            $this->assertInstanceOf('App\WeatherMain', $one->main()->getRelated());  
            $this->assertInstanceOf('App\WeatherWind', $one->wind()->getRelated());  
            $this->assertInstanceOf('App\WeatherRain', $one->rains()->getRelated());           
            $this->assertInstanceOf('App\WeatherSnow', $one->snows()->getRelated());    
        }
        
        /**
         * 
         * @return \App\WeatherCurrent
         */
        protected function createNewWeatherCurrent(array $attributes=[])
        {            
            return factory(App\WeatherCurrent::class)->make($attributes);
        }       
}