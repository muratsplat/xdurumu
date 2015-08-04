<?php

use Mockery as m;
use App\Jobs\Weather\UpdateCurrent;
use App\Console\Commands\WeatherUpdateCurrent as ConsoleUpdate;
/**
 * Test file for App\Libs\Weather\OpenWeatherMap class
 * 
 */
class ConsoleCommandsWeatherUpdateCurrentTest extends \TestCase
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
            return m::mock('App\Repositories\CityRepository');
        } 
        
        /**
         * 
         * @return \Mockery\MockInterface
         */
        private function getMockedCurrentRepository()
        {
            return m::mock('App\Contracts\Weather\Repository\ICurrentRepository');
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
        private function getMockedQueue()
        {
            return m::mock('Illuminate\Contracts\Queue\Queue');
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
            $cities   = factory(App\City::class, 10)->make();
            
            $currentRepo = $this->getMockedCurrentRepository();
            
            $repo= $this->getMockedRepository();  
            
            $queue = $this->getMockedQueue();                    
            
            $job = new ConsoleUpdate($queue, $repo, $currentRepo);
        }   
        
        public function testHandle()
        {
            $cities   = factory(App\City::class, 10)->make();
            
            $repo= $this->getMockedRepository();  
            
            $repo->shouldReceive('enable')->andReturnSelf();
            $repo->shouldReceive('all')->andReturn($cities);            
            
            $queue = $this->getMockedQueue(); 
            
            $queue->shouldReceive('push')->andReturnSelf();
            
            $app = app();           
            
            $currentRepo = $this->getMockedCurrentRepository();
        
            $job = new ConsoleUpdate($queue, $repo, $currentRepo);
            
            $job->enableTesting();
            
            $job->handle();
            
            $queue->shouldHaveReceived('push')->times(10);
        }   
        
 
      
      
}