<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


use App\Repositories\CityRepository as Repository;
use Mockery as m;

/**
 * Current Repository Test Class
 * 
 * @package WeatherForcast
 */
class CityRepositoryWithDatabaseTest extends \TestCase
{  
    use DatabaseMigrations, DatabaseTransactions;
  
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
         * @return App\City
         */
        private function getCity()
        {
            return new App\City();      
        }
        
        /**
         * Mocked Cache
         *  
         * @return \Illuminate\Contracts\Cache\Repository
         */
        private function getCache()
        {            
            return app('cache')->driver();   
        }
        
        /**
         * Mocked Config
         *  
         * @return \Illuminate\Contracts\Config\Repository
         */
        private function getConfig()
        {            
            return app('config');
        }
       
        public function testSimple()
        { 
            $city       = $this->getCity();
            
            $config     = $this->getConfig();
            
            $cache      = $this->getCache();
            
            $one = new Repository($cache, $config, $city);          
        }     
        
        public function testFind()
        {           
         
        }
        
        
        public function testFindNoExistCity()
        {
            
          
        }
        
        public function testFindByCitySlug()
        {            
           
        }        

        public function testSimpleAll() 
        {
           
        }
        
  
}
