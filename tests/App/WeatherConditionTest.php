<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\WeatherCondition;


class WeatherConditionTest extends TestCase
{
    
   // use DatabaseMigrations;
    
    
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
                'description'           => 'Sağnak yaağışlı',
                'icon'                  => 'rain',
                'open_weather_map_id'   => 200,              
            ];
            
            $one = factory(App\WeatherCondition::class)->make($condition);       
            
            $this->assertEquals($condition['name'], $one['name']);
            $this->assertEquals($condition['description'], $one['description']);
            $this->assertEquals($condition['icon'], $one['icon']);
            $this->assertEquals($condition['open_weather_map_id'], $one['open_weather_map_id']);         
        }
        
      
        
}