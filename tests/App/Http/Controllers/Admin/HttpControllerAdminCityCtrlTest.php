<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
//use Illuminate\Foundation\Testing\DatabaseTransactions;

use Mockery as m;


class HttpControllerAdminCityCtrlTest extends TestCase
{
    
    
    
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
        
        $cityRepo->shouldReceive('enableCache')->andReturnSelf();       
        
        $cities = $this->getCities();
    
        $cityRepo->shouldReceive('all')->andReturn($cities);
        
        $app['App\Contracts\Repository\ICity'] = $cityRepo;        
                
        $res = $this->action('GET', '\App\Http\Controllers\Admin\CityCtrl@index');

        $cityRepo->shouldHaveReceived('enableCache')->times(1);
        
        $cityRepo->shouldHaveReceived('all')->times(1);
        
        $this->assertEquals($res->getContent(), $cities->toJson());
        
        $this->assertResponseOk();
    }
    
   
    
}
