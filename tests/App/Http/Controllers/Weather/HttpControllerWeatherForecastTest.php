<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
//use Illuminate\Foundation\Testing\DatabaseTransactions;

use Mockery as m;


/**
 * This test file is written for 'App\Http\Controllers\Weather\Forecasr' Controller
 * 
 */
class HttpControllerWeatherForecastTest extends TestCase
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
    private function getCurrents()
    {
        return factory(App\WeatherCurrent::class, 10)->make()->each(function(\App\WeatherCurrent $item){
            
            $cond = new \stdClass();
            
            $cond->icon = 'foo';
            
            $cond->description = 'Sky is clear!';
            
            $collection = new \Illuminate\Database\Eloquent\Collection([$cond]);
            
            $item->conditions = $collection;
            
            $city = new \stdClass();
            
            $city->slug = 'foo';
            
            $city->name = 'bar';
            
            $city->longitude = 233233;
                    
            $city->latitude = 233233;                    
            
            $item->city =  $city;    
            
            $main = new \stdClass();
            
            $main->temp = 1;
            
            $item->main = $main;
        });
        
        
        return new Illuminate\Database\Eloquent\Collection();
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
        
        $currentRepo->shouldReceive('enableCache')->andReturnSelf();       
        
        $currents = m::mock('\Illuminate\Contracts\Pagination\LengthAwarePaginator');
        
        $currents->shouldReceive('with')->andReturnSelf();
        
        $currents->shouldReceive('count')->andReturn(23);
        
        $currents->shouldReceive('isEmpty')->andReturn(false);
        
        $currents->shouldReceive('total')->andReturn(99);
        
        $currents->shouldReceive('paginate')->andReturnSelf();
        
         $currents->shouldReceive('perPage')->andReturnSelf();
         
           $currents->shouldReceive('render')->andReturnSelf();
    
        $currentRepo->shouldReceive('onModel')->andReturn($currents);
        
        $cityRepo = $this->getCityRep();
        
        $app['App\Contracts\Weather\Repository\ICurrent'] = $currentRepo;        
        
        $app['App\Contracts\Repository\ICity'] = $cityRepo;
                
        $res = $this->action('GET', 'Weather\Forecast@index');       
          
        $this->assertResponseOk();
        
        $currents->shouldNotReceive('total');
        $currents->shouldNotReceive('paginate');
        $currents->shouldNotReceive('render');
         
    }
    
    
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function atestBasicExampleWithParameter()
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
