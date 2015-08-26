<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
//use Illuminate\Foundation\Testing\DatabaseTransactions;

use Mockery as m;


class HttpControllerAdminCityCtrlTest extends TestCase
{
    
    use WithoutMiddleware;
    
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
    
    /**
     *
     * @return void
     */
    public function testUpdateCity()
    {
        $app = app();
        
        
        $data = [           
            'name'      => 'FooBar',
            'slug'      => 'foo-bar',
            'enable'    => '1',
            'priority'  => '3',
        ];
        
        $cityRepo = $this->getCityRep();                       
        
        $cityRepo->shouldReceive('update')->andReturn(1);
        
        $app['App\Contracts\Repository\ICity'] = $cityRepo;              
        

        \Validator::shouldReceive('make')->andReturnSelf();
        \Validator::shouldReceive('passes')->andReturn($data);
                
        $res = $this->action('PUT', '\App\Http\Controllers\Admin\CityCtrl@update', 1, $data);
        
        $this->assertEquals('', $res->getContent());
        
        $this->assertResponseStatus(204);      
    }
    
    
    /**
     *
     * @return void
     */
    public function testUpdateCityFail()
    {
        $app = app();
        
        
        $data = [           
            'name'      => 'FooBar',
            'slug'      => 'foo-bar',
            'enable'    => '1',
            'priority'  => '3',
        ];
        
        $cityRepo = $this->getCityRep();                       
        
        $cityRepo->shouldReceive('update')->andReturn(false);
        
        $app['App\Contracts\Repository\ICity'] = $cityRepo;                  

        \Validator::shouldReceive('make')->andReturnSelf();
        \Validator::shouldReceive('passes')->andReturn($data);                
                
        $res = $this->action('PUT', '\App\Http\Controllers\Admin\CityCtrl@update', 1, $data);
        
        $this->assertEquals('{"code":"500","msg":"City is not updated"}', $res->getContent());        
        $this->assertResponseStatus(500);      
    }  
    
}
