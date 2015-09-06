<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
//use Illuminate\Foundation\Testing\DatabaseTransactions;

use Mockery as m;


/**
 * This test file is written for 'App\Http\Controllers\Api\City' Controller
 * 
 */
class HttpControllerApiWeatherCurrentTest extends TestCase
{
    
   // use WithoutMiddleware;
    
    
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
    private function getCurrents($count = 15)
    {
        return factory(App\WeatherCurrent::class, $count)->make();
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
    
        $currentRepo->shouldReceive('all')->andReturn($currents);//        
        $app['App\Contracts\Weather\Repository\ICurrent'] = $currentRepo;   
        
        $res = $this->action('GET', 'Api\Weather\Current@index');        
        
        $this->assertResponseOk();
    }
   
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testWithParameters()
    {                     
        $app = app();
        
        $currentRepo = $this->getCurrentRep();
//        
        $currentRepo->shouldReceive('enableCache')->andReturnSelf();            
     
        $currents = $this->getCurrents();
        
        $currentRepo->shouldReceive('takeRandomOnAll')->andReturn($currents);
    
        $currentRepo->shouldReceive('all')->andReturn($currents->take(5));//   
        
        $app['App\Contracts\Weather\Repository\ICurrent'] = $currentRepo;   
        
        $res = $this->action('GET', 'Weather\Current@index', ['mode' => 'rand', 'cnt' => 10]);           
        
        $this->assertResponseOk();
    }
    
   /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testSenorioOneWantedTenButCurrentsFive()
    {                     
        $app = app();
        
        $currentRepo = $this->getCurrentRep();
//        
        $currentRepo->shouldReceive('enableCache')->andReturnSelf();            
     
        $currents = $this->getCurrents(5);
        
        $currentRepo->shouldReceive('takeRandomOnAll')->andReturn($currents);
    
        $currentRepo->shouldReceive('all')->andReturn($currents);   
        
        $app['App\Contracts\Weather\Repository\ICurrent'] = $currentRepo;   
        
        $res = $this->call('GET', 'http://api.durumum.dev/weather/current',['mode' => 'rand', 'cnt' => 10]);                   
        
        $this->assertResponseOk();
        
        $currentRepo->shouldNotHaveReceived('takeRandomOnAll');
    }
    
    
    
}
