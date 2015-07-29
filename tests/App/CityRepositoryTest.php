<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
//use Illuminate\Foundation\Testing\DatabaseTransactions;


use App\Repositories\CityRepository as Repository;
use Mockery as m;

/**
 * Current Repository Test Class
 * 
 * @package WeatherForcast
 */
class CityRepositoryTest extends \TestCase
{  
  
        public function setUp()
        {
            parent::setUp();      
           
        }
      
        /**
         * Mocked City Model
         * 
         * @return \Mockery\MockInterface
         */
        private function getCityMock()
        {
            return m::mock('App\City');            
        }
  
        public function testSimple()
        { 
            $city       = $this->getCityMock();
            
            $one = new Repository($city);          
        }     
        
        public function testFind()
        {           
            $city       = $this->getCityMock();
            
            $one        = factory(App\City::class)->make();
            
            $city->shouldReceive('find')->andReturn($one);
            
            $repo = new Repository($city);          
            
            $founded   = $repo->find(1);
            
            $this->assertNotNull($founded);
        }
        
        
        public function testFindNoExistCity()
        {
            $city       = $this->getCityMock();
            
            $city->shouldReceive('find')->andReturnNull();
            
            $repo = new Repository($city);          
            
            $founded   = $repo->find(1);
            
            $this->assertNull($founded);
          
        }
        
        public function testFindByCitySlug()
        {            
            $city       = $this->getCityMock();
            
            $one        = factory(App\City::class)->make();
            
            $city->shouldReceive('findBySlug')->andReturn($one);
            
            $repo      = new Repository($city);          
            
            $founded   = $repo->findBySlug($one->slug);
            
            $this->assertNotNull($founded);
           
        }        

        public function testSimpleAll() 
        {
            $city       = $this->getCityMock();
            
            $one        = factory(App\City::class,10)->make();    
            
            $city->shouldReceive('all')->andReturn($one);
                 
            $repo       = new Repository($city);        
            
            $all        = $repo->all($one->all());
            
            $this->assertCount($one->count(), $all);                         
        }
        
  
}
