<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
//use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\WeatherSys;


class WeatherSysTest extends TestCase
{  

    
        public function testSimple()
        {           
            $one = new WeatherSys();                     
        }       
        
        public function testWithFakerAttributes() 
        {                                  
            $one = factory(App\WeatherSys::class)->make();    
            
            $this->assertNotNull($one->sunset);
            $this->assertNotNull($one->sunrise);
            $this->assertNotNull($one->country);
        }    
        
}