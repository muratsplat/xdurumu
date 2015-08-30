<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
//use Illuminate\Foundation\Testing\DatabaseTransactions;

use Mockery as m;


/**
 * This test file is written for 'App\Http\Controllers\Weather\Current' Controller
 * 
 */
class HttpControllerWeatherCurrentTest extends TestCase
{
    
    use WithoutMiddleware;
    
    /**
     * 
     * @return \Mockery\MockInterface
     */
    private function getCurrentRep()
    {
        return m::mock('App\Contracts\Weather\Repository\ICurrent');        
    }
    
    /**
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getCurrents()
    {
        return factory(App\WeatherCurrent::class, 10)->make();
    }
    
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $app = app();
        
        $currentRepo = $this->getCurrentRep();
//        
        $currentRepo->shouldReceive('enableCache')->andReturnSelf();       
//        
        $currents = $this->getCurrents();
    
        $currentRepo->shouldReceive('all')->andReturn($currents);
//        
        $app['App\Contracts\Weather\Repository\ICurrent'] = $currentRepo;        
                
        $res = $this->action('GET', 'Weather\Current@index');       
        
        $this->assertResponseOk();
    }
    
    
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExampleWithParameter()
    {
        $app = app();
        
        $currentRepo = $this->getCurrentRep(); 
        
        $currents = $this->getCurrents();
        
        $currentRepo->shouldReceive('takeRandomOnAll')->withArgs([3])->andReturn($currents);      
       
        $app['App\Contracts\Weather\Repository\ICurrent'] = $currentRepo;        
                
        $res = $this->action('GET', 'Weather\Current@index', [], ['mode' => 'rand', 'cnt' => 3]);       
         
        $this->assertResponseOk();
        
        $currentRepo->shouldHaveReceived('takeRandomOnAll')->with(3);        
    }
    
}
