<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\WeatherWind;


class WeatherWindTest extends TestCase
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
    
    
        public function setUp()
        {
            parent::setUp();               
            
           \Config::set('database.default', 'sqlite');  
        }
        
        /**
         * A basic functional test example.
         *
         * @return void
         */
        public function testSimple()
        {           
            $one = new WeatherWind();                     
        }


        public function testSimpleTwo() 
        {            
            $data =  [
                
                'weather_current_id'    => null,
                'weather_hourly_id'     => null,                 
                'speed'                 => 40.5,
                'deg'                   => 98.001,
            ];
            
            $one = factory(App\WeatherWind::class)->make($data);       
            
            $this->assertEquals($data['weather_current_id'], $one['weather_daily_id']);
            $this->assertEquals($data['weather_hourly_id'], $one['weather_hourly_id']);         
            $this->assertEquals($data['speed'], $one['speed']);
            $this->assertEquals($data['deg'], $one['deg']);
        }       
        
        
        public function testWithFakerAttributes() 
        {            
                       
            $one = factory(App\WeatherWind::class)->make();       
            
            $this->assertNull($one['weather_hourly_id']);
            
            $this->assertNotNull($one['speed']);     
            $this->assertNotNull($one['deg']);     
        }
        
        /**
         * 
         * @param array $attributes
         * @return App\WeatherWind
         */
        public function createNewWeatherWind(array $attributes=[])
        {
            return  factory(App\WeatherWind::class)->make($attributes);            
        }
        
        public function testRelationSimle()
        {
            $one = $this->createNewWeatherWind();
            
           // $this->assertInstanceOf('App\WeatherCurrent', $one->current()->getRelated());            
           // $this->assertInstanceOf('App\WeatherHourlyStat', $one->hourlyStat()->getRelated());  
        }
        
        public function testSimpleCRUD()
        {
            $wind = $this->createNewWeatherWind();
            
            $this->assertTrue($wind->save());
        }
        
      
        
}