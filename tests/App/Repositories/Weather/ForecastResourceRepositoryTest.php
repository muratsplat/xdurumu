<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
//use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Repositories\Weather\ForecastResource as Repository;
use Mockery as m;

/**
 * Current Repository Test Class
 * 
 * @package WeatherForcast
 */
class ForecastResourceRepositoryTest extends \TestCase
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
        
        /**
         * 
         * @return \Mockery\MockInterface
         */
        private function getMockedCache()
        {
            return m::mock('Illuminate\Contracts\Cache\Repository');         
        }
        
        /**
         * 
         * @return \Mockery\MockInterface
         */
        private function getMockedConfig()
        {
            return m::mock('Illuminate\Contracts\Config\Repository');         
        }
        
        /**
         * 
         * @return \Mockery\MockInterface
         */
        private function getMockedResource()
        {
            return m::mock('App\WeatherForeCastResource');         
        }        
      
        public function testSimple()
        {
            $cache      = $this->getMockedCache();        
            
            $config     = $this->getMockedConfig();
            $config->shouldReceive('get')->andReturn(60);
            
            $resource   = $this->getMockedResource();            
            
            $one = new Repository($cache, $config, $resource);
            
            $config->shouldHaveReceived('get');
            
            $this->assertEquals($one->onModel(), $resource);           
        }  
        
        public function testDisableCacheAndEnableCache()
        {
            $cache      = $this->getMockedCache();  
            
            $collection = factory(App\WeatherForeCastResource::class, 10)->make();
            
            $cache->shouldReceive('remember')->andReturn($collection);
            
            $config     = $this->getMockedConfig();
            
            $config->shouldReceive('get')->andReturn(60);
            
            $resource   = $this->getMockedResource(); 
            
            $resource->shouldReceive('all')->andReturn($collection);
            
            $one = new Repository($cache, $config, $resource);
            
            $one->enableCache();
            
            $this->assertCount(10, $one->all());         
            
            $cache->shouldHaveReceived('remember');
            
            $resource->shouldNotHaveReceived('all');
            
            $one->disableCache();
            
            $this->assertCount(10, $one->all());  
            
            $resource->shouldReceive('all');
            
            $cache->shouldHaveReceived('remember')->times(1);         
        }  
}