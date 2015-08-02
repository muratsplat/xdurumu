<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
//use Illuminate\Foundation\Testing\DatabaseTransactions;


use App\Repositories\Weather\ForecastResourceRepository as Repository;

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
        
        public function testOnEnable()
        {
            $cache      = $this->getMockedCache();        
            
            $config     = $this->getMockedConfig();
            $config->shouldReceive('get')->andReturn(60);
            
            $resource   = $this->getMockedResource();            
            
            $one = new Repository($cache, $config, $resource);
            
            
        }  
        

  
}
