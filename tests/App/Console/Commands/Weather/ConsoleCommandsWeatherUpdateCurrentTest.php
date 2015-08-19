
<?php

use Mockery as m;
use App\Console\Commands\Weather\UpdateCurrent as ConsoleUpdate;

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
        private function getMockedCity()
        {
            return m::mock('App\Repositories\City');
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
            
            $job = new ConsoleUpdate($queue, $repo);
        }   
        
        public function testHandle()
        {
            $cities   = factory(App\City::class, 10)->make();
            
            $repo= $this->getMockedCity();  
            
            $repo->shouldReceive('onModel')->andReturnSelf();
            $repo->shouldReceive('enable')->andReturnSelf();
            $repo->shouldReceive('get')->andReturn($cities);                        
            
            $queue = $this->getMockedQueue();             
            $queue->shouldReceive('push')->andReturnSelf();                    
            
            $job = new ConsoleUpdate($queue, $repo);
            
            $job->enableTesting();
            
            $job->handle();
            
            $queue->shouldHaveReceived('push')->times(10);
        }         
}