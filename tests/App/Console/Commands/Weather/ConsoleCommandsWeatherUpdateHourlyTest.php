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
        private function getMockedCity()
        {
            return m::mock('App\Contracts\Repository\ICity');
        } 
        
        /**
         * 
         * @return \Mockery\MockInterface
         */
        private function getMockedCurrent()
        {
            return m::mock('App\Contracts\Weather\Repository\ICurrent');
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
            $repo= $this->getMockedCity();  
            
            $queue = $this->getMockedQueue();                    
            
            $job = new ConsoleHourly($queue, $repo);
        }   
        
        public function testHandle()
        {
            $cities   = factory(App\City::class, 10)->make();
            
            $repo= $this->getMockedCity();  
            
            $repo->shouldReceive('onModel')->andReturnSelf();
            $repo->shouldReceive('enable')->andReturnSelf();
            $repo->shouldReceive('get')->andReturn($cities);            
            
            $queue = $this->getMockedQueue(); 
            
            $queue->shouldReceive('pushOn')->andReturnSelf();
   
            $job = new ConsoleHourly($queue, $repo);
            
            $job->enableTesting();
            
            $job->handle();
            
            $queue->shouldHaveReceived('pushOn')->times(10);
        }    
      
}