<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
//use Illuminate\Foundation\Testing\DatabaseTransactions;

use Mockery as m;


/**
 * This test file is written for 'App\Http\Controllers\Api\City' Controller
 * 
 */
class HttpControllerApiCityTest extends TestCase
{
    
   // use WithoutMiddleware;
    
    /**
     * 
     * @return \Mockery\MockInterface
     */
    private function getCityRep()
    {
        return m::mock('App\Contracts\Repository\ICity');        
    }
    
    /**
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getCities()
    {
        return factory(App\City::class, 10)->make();
    }
    
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $app = app();
        
        $cityRepo = $this->getCityRep();    
        
        $cities = $this->getCities();
        
        $cityRepo->shouldReceive('getCitiesHasWeatherDataByFiteringInArray')->andReturn($cities->toArray());              
    
        $cityRepo->shouldReceive('all')->andReturn($cities);
        
        $app['App\Contracts\Repository\ICity'] = $cityRepo;        
                
        $res = $this->action('GET', 'Api\City@index');
        
        $this->assertTrue($res->isFresh());
        
        $content = $res->getContent();   
        
        $toArray = json_decode($content, true);
        
        $this->assertCount($cities->count(), $toArray);
        
        $this->assertResponseOk();
    }
    
    
    
}
