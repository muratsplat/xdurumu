<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
//use Illuminate\Foundation\Testing\DatabaseTransactions;


use App\Repositories\City as Repository;
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
        
        
        public function tearDown()
        {
            parent::tearDown();
            
            m::close();
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
        
        /**
         * Mocked Cache
         *  
         * @return \Mockery\MockInterface
         */
        private function getMockedCache()
        {            
            return m::mock('Illuminate\Contracts\Cache\Repository');            
        }
        
        /**
         * Mocked Config
         *  
         * @return \Mockery\MockInterface
         */
        private function getMockedConfig()
        {            
            return m::mock('Illuminate\Contracts\Config\Repository');    
        }
       
        public function testSimple()
        { 
            $city       = $this->getCityMock();
            
            $config     = $this->getMockedConfig();
            
            $config->shouldReceive('get')->andReturn(30);
            
            $cache      = $this->getMockedCache();
            
            $one = new Repository($cache, $config, $city);          
        }     
        
        public function testFind()
        {           
            $city       = $this->getCityMock();
            
            $config     = $this->getMockedConfig();
            
            $config->shouldReceive('get')->andReturn(30);
            
            $cache      = $this->getMockedCache();
            
            $one        = factory(App\City::class)->make();
            
            $city->shouldReceive('find')->andReturn($one);           
            
            $repo = new Repository($cache, $config, $city);          
            
            $founded   = $repo->find(1);
            
            $this->assertNotNull($founded);
        }
        
        
        public function testFindNoExistCity()
        {
            $city       = $this->getCityMock();
            
            $city->shouldReceive('find')->andReturnNull();
            
            $config     = $this->getMockedConfig();
            
            $config->shouldReceive('get')->andReturn(30);
            
            $cache      = $this->getMockedCache();
            
            $repo = new Repository($cache, $config, $city);          
            
            $founded   = $repo->find(1);
            
            $this->assertNull($founded);
          
        }
        
        public function testFindByCitySlug()
        {            
            $city       = $this->getCityMock();
            
            $one        = factory(App\City::class)->make();
            
            $city->shouldReceive('findBySlug')->andReturn($one);
            
            $config     = $this->getMockedConfig();
            
            $config->shouldReceive('get')->andReturn(30);
            
            $cache      = $this->getMockedCache();
            
            $repo      = new Repository($cache, $config, $city);          
            
            $founded   = $repo->findBySlug($one->slug);
            
            $this->assertNotNull($founded);
           
        }        

        public function testSimpleAll() 
        {
            $city       = $this->getCityMock();
            
            $one        = factory(App\City::class,10)->make();    
            
            $city->shouldReceive('all')->andReturn($one);
            
            $config     = $this->getMockedConfig();
            
            $config->shouldReceive('get')->andReturn(30);
            
            $cache      = $this->getMockedCache();
                 
            $repo       = new Repository($cache, $config, $city);        
            
            $all        = $repo->all($one->all());
            
            $this->assertCount($one->count(), $all);                         
        }
        
  
}
