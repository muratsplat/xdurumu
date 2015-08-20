<?php

use Mockery as m;
use App\Jobs\Weather\DeleteOldData;

/**
 * //
 * 
 */
class DeleteOldDataTest extends \TestCase
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
            return m::mock('App\Contracts\Repository\ICity');
        }         
     
        
        public function testSimple()
        {
            $city   = factory(App\City::class)->make();        
            
            $job = new DeleteOldData($city);          
        }   
        
                
        public function testSimpleHandle()
        {
                     
            $city   = factory(App\City::class)->make();
            
            $city->exists = true;
            
            $repo= $this->getMockedRepository();  
            
            $repo->shouldReceive('deleteOldListsByCity')->andReturnSelf();
            
            $job = new DeleteOldData($city);       
            
            $job->handle($repo); 
        }        
}