<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Repositories\City as Repository;
//use Mockery as m;

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
            
           // $one = new Repository($cache, $config, $city);          
        }
        
        /**
         * 
         * @return \App\Repositories\CityRepository
         */
        private function getCityRepository()
        {
            $city       = $this->getCity();
            
            $config     = $this->getConfig();
            
            $cache      = $this->getCache();
            
         //   return new Repository($cache, $config, $city);        
        }        
        
        public function atestFind()
        {           
            $cities = factory(\App\City::class, 5)->create();            
            
            $repo = $this->getCityRepository();            
            
            //$one = $cities->random();
            
            $founded = $repo->find($one->id);
            
            $this->assertNotNull($founded);   
            
            $notExists = $repo->find(99);
            
            $this->assertNull($notExists);            
        }        
    
        public function atestFindByCitySlug()
        {              
            $cities = factory(\App\City::class, 5)->create();            
            
            //$repo = $this->getCityRepository();            
            
            $one = $cities->random();
            
            $oneBySlug = $repo->findBySlug($one->slug);
            
            $this->assertNotNull($oneBySlug);
            
            $this->assertEquals($oneBySlug->id, $one->id);
            
            $notExists = $repo->findBySlug('fooBıraBıra');
            
            $this->assertNull($notExists);           
        }        

        public function atestSimpleAll() 
        {            
            $cities = factory(\App\City::class, 5)->create();            
            
            $repo = $this->getCityRepository();            
            
            $this->assertCount($cities->count(), $repo->all());
            $this->assertCount($cities->count(), $repo->enableCache()->all());           
        }
        
        public function atestFirstOrCreateWeatherHouryStat()
        {            
            $city = factory(\App\City::class)->create();             
            
            $repo = $this->getCityRepository();    
            
            $hourlyStat = $repo->firstOrCreateWeatherHouryStat($city);
            
            $this->assertNotNull($hourlyStat);            
            
            $hourlyStat2 = $repo->firstOrCreateWeatherHouryStat($city);
            
            $this->assertEquals($hourlyStat2->id, $hourlyStat->id);            
        }
        
        public function atestFirstOrCreateWeatherCurrent()
        {            
            $city = factory(\App\City::class)->create();             
            
            $repo = $this->getCityRepository();    
            
            $current = $repo->firstOrCreateWeatherCurrent($city);
            
            $this->assertNotNull($current);            
            
            $current2 = $repo->firstOrCreateWeatherCurrent($city);
            
            $this->assertEquals($current2->id, $current->id);            
        }
        
  
}
