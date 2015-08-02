<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\WeatherForeCastResource;


class WeatherForeCastResourceTest extends TestCase
{
    
    use DatabaseMigrations, DatabaseTransactions;
    
        
        /**
         * A basic functional test example.
         *
         * @return void
         */
        public function testSimple()
        {
           
            $resources = factory(WeatherForeCastResource::class)->make();              
                     
        }
        
//              Migration
        
//            $t->increments('id');
//            $t->string('name', 150)->unique();
//            $t->mediumText('description')->nullable();
//            $t->string('url', 250)->unique();
//            $t->string('api_url', 150)->nullable();
//            $t->boolean('apiable')->default(false);                   
//            $t->tinyInteger('enable')->default(0);
//            $t->tinyInteger('priority')->unsigned()->default(10);            
//            $t->tinyInteger('paid')->default(0);
//            $t->bigInteger('api_calls_count')->unsigned()->default(0);
//            $t->timestamp('last_access_on')->nullable();   
//            $t->softDeletes();            
//            $t->timestamps();
        
        /**
         * 
         * @return \App\WeatherForeCastResource
         */
        protected function createNewWeatherForeCastResource(array $attributes=[])
        {            
            return factory(App\WeatherForeCastResource::class)->make($attributes);
        }
        
        public function testRelationsSimple()
        {
            $one = $this->createNewWeatherForeCastResource();
            
            $this->assertInstanceOf('App\WeatherCurrent', $one->currents()->getRelated());            
        }
        
        public function testSimpleCRUD()
        {
            $one = $this->createNewWeatherForeCastResource();
            
            $this->assertTrue($one->save());            
        }
        
        public function testPriorityScope()
        {
            $resources = factory(WeatherForeCastResource::class, 10)->create();
            
            $this->assertCount(10, $resources);
            
            $highestPriority = WeatherForeCastResource::priority()->get();
            
            $this->assertTrue($highestPriority[0]->priority < 5);
        }
        
      
        
}