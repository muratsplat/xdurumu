<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\WeatherForeCastResource;


class WeatherForeCastResourceTest extends TestCase
{
    
   // use DatabaseMigrations;
    
        
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
//            $t->string('name', 150);
//            $t->mediumText('description');
//            $t->string('url', 250);
//            $t->string('api_url', 150);
//            $t->timestamp('last_access_on');
//            $t->tinyInteger('enable')->default(0);
//            $t->tinyInteger('paid')->default(0);
//            $t->mediumInteger('api_calls_count')->unsigned();
//            $t->softDeletes();            
//            $t->timestamps();
        
        public function testSimpleTwo() 
        {            
          
        }
        
      
        
}