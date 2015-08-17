<?php

use Mockery as m;

use App\Console\Commands\Weather\UpdateHourly as ConsoleHourly;


class ConsoleCommandsWeatherUpdateHourlyTest extends \TestCase
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
        private function getMockedCityRepository()
        {
            return m::mock('App\Contracts\Repository\ICityRepository');
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

        public function testSimple()
        {           
            $currentRepo = $this->getMockedCurrentRepository();
            
            $repo= $this->getMockedCityRepository();  
            
            $queue = $this->getMockedQueue();                    
            
            $job = new ConsoleHourly($queue, $repo, $currentRepo);
        }   
        
        public function testHandle()
        {
            $cities   = factory(App\City::class, 10)->make();
            
            $repo= $this->getMockedCityRepository();  
            
            $repo->shouldReceive('onModel')->andReturnSelf();
            $repo->shouldReceive('enable')->andReturnSelf();
            $repo->shouldReceive('get')->andReturn($cities);            
            
            $queue = $this->getMockedQueue(); 
            
            $queue->shouldReceive('push')->andReturnSelf();
      
            $currentRepo = $this->getMockedCurrentRepository();
        
            $job = new ConsoleHourly($queue, $repo, $currentRepo);
            
            $job->enableTesting();
            
            $job->handle();
            
            $queue->shouldHaveReceived('push')->times(10);
        }   
        
 
      
      
}