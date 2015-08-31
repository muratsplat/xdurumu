<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\WeatherCondition;


class WeatherConditionTest extends TestCase
{
    
   use DatabaseMigrations, DatabaseTransactions;
    
    
//        $t->increments('id');
//        $t->integer('open_weather_map_id')->unsigned()->nullable();            
//        $t->string('name', 50);
//        $t->string('description', 150);
//        $t->string('icon', 50)->nullable(); 
//        $t->boolean('enable')->default(true);
//        $t->string('slug', 200)->nullable()->unique()->index();
//        $t->integer('sort_order')->unsigned()->default(0);            
//        $t->softDeletes();                       
//        $t->timestamps();
    
        
        /**
         * A basic functional test example.
         *
         * @return void
         */
        public function testSimple()
        {           
            $weatherCondition = new WeatherCondition();                     
        }

        public function testSimpleTwo() 
        {            
            $condition =  [
                
                'name'                  => 'Yağmurlu',
                'orgin_name'            => 'Rain',                
                'description'           => 'Sağnak yağışlı',
                'orgin_description'     => 'moderate rain',
                'icon'                  => 'ra',
                'open_weather_map_id'   => 200,              
            ];
            
            $one = factory(App\WeatherCondition::class)->make($condition);       
            
            $this->assertEquals($condition['orgin_name'], $one['orgin_name']);
            $this->assertEquals($condition['name'], $one['name']);
            $this->assertEquals($condition['description'], $one['description']);
            $this->assertEquals($condition['orgin_description'], $one['orgin_description']);
            $this->assertEquals($condition['icon'], $one['icon']);
            $this->assertEquals($condition['open_weather_map_id'], $one['open_weather_map_id']);         
        }        
        
        /**
         * 
         * @param array Attributes
         * @return \App\WeatherCondition
         */
        public function createNewWeatherCondition(array $attributes=[])
        {            
            return factory(App\WeatherCondition::class)->make($attributes);
        }
        
        public function testSimpleRelations()
        {
            $one = $this->createNewWeatherCondition();
            
           // $this->assertInstanceOf('App\WeatherCurrent', $one->currents()->getRelated());    
            
           // $this->assertInstanceOf('App\WeatherHourlyStat', $one->hourlyStats()->getRelated());
        }
        
        public function testSimpleCRUD()
        {
            $one = $this->createNewWeatherCondition();
            
            $this->assertTrue($one->save());
        }
        
        
        public function testIconAccessor()
        {
            $one = factory(App\WeatherCondition::class)->make();
            
            $one->icon = '01n';
            
            $this->assertTrue($one->save());
            
            $this->assertEquals('01', $one->icon);           
        }       
}