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
        
        public function testDeleteAllRelations()
        {
            $list = $this->createNewWeatherList();
            
            $this->assertTrue($list->save());
            
            $conditions = factory(App\WeatherCondition::class, 3)->create();
            
            $ids= [];
            
            foreach ($conditions as $one) {
                
                $ids[] = $one->id;
            }               
                 
            $list->conditions()->sync($ids);
            
            $this->assertCount(3, $list->conditions);
            
            $main = factory(App\WeatherMain::class)->create();
            
            $list->main()->save($main);
            
            $wind = factory(App\WeatherWind::class)->create();
            
            $list->wind()->save($wind);
            
            $rain = factory(App\WeatherRain::class)->create();
            
            $list->rain()->save($rain);
            
            $snow = factory(App\WeatherSnow::class)->create();
            
            $list->snow()->save($snow);
            
            $this->assertCount(1, App\WeatherMain::all());
            $this->assertCount(1, App\WeatherRain::all());
            $this->assertCount(1, App\WeatherSnow::all());
            $this->assertCount(1, App\WeatherWind::all());  
            $this->assertCount(3, App\WeatherCondition::all());
                  
            $this->assertTrue($list->delete());   
            
            $this->assertCount(0, App\WeatherMain::all());
            $this->assertCount(0, App\WeatherRain::all());
            $this->assertCount(0, App\WeatherSnow::all());
            $this->assertCount(0, App\WeatherWind::all());  
            $this->assertCount(0, \DB::table('weather_condition_ables')->get());
        }        
}