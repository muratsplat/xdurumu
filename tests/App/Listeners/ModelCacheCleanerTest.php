<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
//use Illuminate\Foundation\Testing\DatabaseTransactions;

use Mockery as m;

use App\Listeners\ModelCacheCleaner;

/**
 * Current Repository Test Class
 * 
 * @package WeatherForcast
 */
class ModelCacheCleanerTest extends \TestCase
{
    

        public function setUp()
        {
            parent::setUp();    
        }
        
        public function tearDown()
        {
            parent::tearDown();
            
            m::close();
        }
        
        public function testSimple()
        {
            $model = m::mock('\App\WeatherForeCastResource');   
            
            \Cache::shouldReceive('has')->once()->andReturn(true);
            
            \Cache::shouldReceive('forget')->once()->andReturn(true);
            
            $cleaner = new ModelCacheCleaner($model);            
        }
        
}