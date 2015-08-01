<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\WeatherCloud;


class WeatherCloudTest extends TestCase
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
            $weatherCondition = new WeatherCloud();                     
        }


        public function testSimpleTwo() 
        {            
            $data =  [
                
                'weather_current_id'    => null,
                'weather_hourly_id'     => null,   
                'weather_daily_id'      => null,        
                'all'                   => rand(1, 100),   
            ];
            
            $one = factory(App\WeatherCloud::class)->make($data);       
            
            $this->assertEquals($data['weather_current_id'], $one['weather_daily_id']);
            $this->assertEquals($data['weather_hourly_id'], $one['weather_hourly_id']);
            $this->assertEquals($data['weather_daily_id'], $one['weather_daily_id']);
            $this->assertEquals($data['all'], $one['all']);         
        }
        
        public function testWithFakerAttributes() 
        {                      
            $one = factory(App\WeatherCloud::class)->make();       
            
            $this->assertNull($one['weather_daily_id']);
            
            $this->assertNotNull($one['all']);        
        }
        
        /**
         * 
         * @param array $attributes
         * @return App\WeatherCloud
         */
        public function createNewWeatherCloud(array $attributes=[])
        {
            return  factory(App\WeatherCloud::class)->make($attributes);            
        }
        
        public function testRelationSimle()
        {
            $one = $this->createNewWeatherCloud();
                        
            $this->assertInstanceOf('App\WeatherCurrent', $one->current()->getRelated());            
        }
        
        public function testSimpleCrud()
        {
            $clouds = $this->createNewWeatherCloud();
            
            $this->assertTrue($clouds->save());
        }      
}