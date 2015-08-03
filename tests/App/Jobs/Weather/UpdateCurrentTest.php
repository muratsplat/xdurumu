<?php


use App\Libs\Weather\ApiServiceFactory as ApiFactory;

use Mockery as m;
use App\Jobs\Weather\UpdateCurrent;

/**
 * Test file for App\Libs\Weather\OpenWeatherMap class
 * 
 */
class UpdateCurrentTest extends \TestCase
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
        private function getMockedRepository()
        {
            return m::mock('App\Repositories\Weather\CurrentRepository');
        } 
        
        /**
         * 
         * @return \Mockery\MockInterface
         */
        private function getMockedApiServiceFactory()
        {
            return m::mock('App\Libs\Weather\ApiServiceFactory');
        } 
        
        /**
         * 
         * @return \Mockery\MockInterface
         */
        private function getMockedAccessor()
        {
            return m::mock('App\Contracts\Weather\Accessor');
        } 
        
        
        
        public function testSimple()
        {
            $city   = factory(App\City::class)->make();
            
            $current= $this->getMockedRepository();            
            
            $job = new UpdateCurrent($city, $current);          
        }   
        
                
        public function testSimpleCaşşHandle()
        {
            $app = app();
            
            $accessor = $this->getMockedAccessor();
            
            $apiFactory = $this->getMockedApiServiceFactory();
            
            $apiFactory->shouldReceive('defaultClient')->andReturnSelf();
            
            $apiFactory->shouldReceive('selectCity')->andReturnSelf();
            
            $apiFactory->shouldReceive('current')->andReturnSelf();
            
            $apiFactory->shouldReceive('sendRequest')->andReturn($accessor);
            
            $app['app.weather.factory'] = $apiFactory;          
            
            $city   = factory(App\City::class)->make();
            
            $city->exists = true;
            
            $current= $this->getMockedRepository();  
            
            $current->exists = true;
            
            $current->shouldReceive('selectCity')->andReturnSelf();
            
            $current->shouldReceive('import')->andReturnSelf();
            
            
            $job = new UpdateCurrent($city, $current);       
            
            $job->handle(); 
        }   
      
      
}