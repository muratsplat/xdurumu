<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


use App\Repositories\Weather\CurrentRepository as Repository;
use App\Libs\Weather\OpenWeatherMap;
use Mockery as m;

/**
 * Current Repository Test Class
 * 
 * @package WeatherForcast
 */
class CurrentRepositoryTest extends \TestCase
{
    

    /**
     * Example of json response
     *
     * @var string JSON 
     */
    private $jsonExample ='{
                    "coord":{"lon":139,"lat":35},
                    "sys":{"country":"JP","sunrise":1369769524,"sunset":1369821049},
                    "weather":[{"id":804,"main":"clouds","description":"overcast clouds","icon":"04n"}], 
                    "main":{
                                    "temp":289.5,
                                    "humidity":89,
                                    "pressure":1013,
                                    "temp_min":287.04,
                                    "temp_max":292.04
                                    },
                    "wind":{"speed":7.31,"deg":187.002}, 
                    "rain":{"3h":0},
                    "clouds":{"all":92},
                    "dt":1369824698,
                    "id":1851632,
                    "name":"Shuzenji",
                    "cod":200
                }';
    
    
        public function setUp()
        {
            parent::setUp();    
            
          
           
        }
        
        /**
         * Mocked WeatherCurrent Model
         * 
         * @return \Mockery\MockInterface
         */
        private function getCurrentMock()
        {
            return m::mock('App\WeatherCurrent');            
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
         * Mocked City Model
         * 
         * @return \Mockery\MockInterface
         */
        private function getCityRepoMock()
        {
            return m::mock('App\Contracts\Repository\ICityRepository');            
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
        /**
         * Mocked App\WeatherCurrent Model
         * 
         * @return \Mockery\MockInterface
         */
        private function getWeatherCurrentMock()
        {
            return m::mock('App\WeatherCurrent');            
        }
        
       /**
         * Mocked Current Model
         * 
         * @return \Mockery\MockInterface
         */
        private function getConditionMock()
        {
            return m::mock('App\WeatherCondition');
        }
        
        /**
         * Mocked Resource Model
         * 
         * @return \Mockery\MockInterface
         */
        private function getWeatherForeCastResourceMock()
        {
            return m::mock('App\WeatherForeCastResource');
        }
        
        
        public function testSimple()
        {   
            $current    = $this->getCurrentMock();
            
            $city       = $this->getCityRepoMock();
            
            $condition  = $this->getConditionMock();
            
            $resource   = $this->getWeatherForeCastResourceMock();
            
            $cache      = $this->getMockedCache();           
            
            $config     = $this->getMockedConfig();
            
            $config->shouldReceive('get')->andReturn(30);
            
            $one = new Repository($cache, $config, $city,$condition, $resource, $current);
          
        }
        
        
        public function testOpenWeatherMapCurrentJsonResponse()
        {   
            $json = '{
                    "coord":{"lon":139,"lat":35},
                    "sys":{"country":"JP","sunrise":1369769524,"sunset":1369821049},
                    "weather":[{"id":804,"main":"clouds","description":"overcast clouds","icon":"04n"}], 
                    "main":{
                                    "temp":289.5,
                                    "humidity":89,
                                    "pressure":1013,
                                    "temp_min":287.04,
                                    "temp_max":292.04
                                    },
                    "wind":{"speed":7.31,"deg":187.002}, 
                    "rain":{"3h":0},
                    "clouds":{"all":92},
                    "dt":1369824698,
                    "id":1851632,
                    "name":"Shuzenji",
                    "cod":200
                }';
            
           $stdObject = json_decode($json);
           
           $this->assertInstanceOf('stdClass', $stdObject);          
        }
        
        public function testSimpleJSON()
        {   
            $json = '{
                    "coord":{"lon":139,"lat":35},
                    "sys":{"country":"JP","sunrise":1369769524,"sunset":1369821049},
                    "weather":[{"id":804,"main":"clouds","description":"overcast clouds","icon":"04n"}], 
                    "main":{
                                    "temp":289.5,
                                    "humidity":89,
                                    "pressure":1013,
                                    "temp_min":287.04,
                                    "temp_max":292.04
                                    },
                    "wind":{"speed":7.31,"deg":187.002}, 
                    "rain":{"3h":0},
                    "clouds":{"all":92},
                    "dt":1369824698,
                    "id":1851632,
                    "name":"Shuzenji",
                    "cod":200
                }';
            
           $stdObject = json_decode($json);
           
           $this->assertInstanceOf('stdClass', $stdObject);          
        } 
        
        public function testFindByCityID()
        {
            $current    = $this->getCurrentMock();
            
            $city       = $this->getCityRepoMock();
            
            $cities     = factory(\App\City::class, 10)->make();  
            
            $city->shouldReceive('all')->andReturn($cities);
            
            $condition  = $this->getConditionMock();
                 
            $resource   = $this->getWeatherForeCastResourceMock();            
                 
            $cache      = $this->getMockedCache();           
            
            $config     = $this->getMockedConfig();
            
            $config->shouldReceive('get')->andReturn(30);
            
            $one = new Repository($cache, $config, $city,$condition,$resource, $current);       
            
            $founded = $one->findByCityID($cities->random());
            
            $this->assertNotNull($founded);  
        }
        
        
        public function testFindByCityIDNoExistCity()
        {
            $current    = $this->getCurrentMock();
            
            $city       = $this->getCityRepoMock();
            
            $cities     = factory(\App\City::class, 2)->make();  
            
            $city->shouldReceive('all')->andReturn($cities);
            
            $condition  = $this->getConditionMock();
            
            $resource   = $this->getWeatherForeCastResourceMock();
                 
            $cache      = $this->getMockedCache();           
            
            $config     = $this->getMockedConfig();
            
            $config->shouldReceive('get')->andReturn(30);
            
            $one = new Repository($cache, $config, $city,$condition, $resource, $current);       
            
            $founded = $one->findByCityID(99);
            
            $this->assertNull($founded);  
        }
        
        public function testFindByCitySlug()
        {
            $current    = $this->getCurrentMock();
            
            $city       = $this->getCityRepoMock();
            
            $cities     = factory(\App\City::class, 2)->make();  
            
            $city->shouldReceive('findBySlug')->andReturn($cities->first());
            
            $condition  = $this->getConditionMock();
                 
            $resource   = $this->getWeatherForeCastResourceMock();            
                 
            $cache      = $this->getMockedCache();           
            
            $config     = $this->getMockedConfig();
            
            $config->shouldReceive('get')->andReturn(30);
            
            $one = new Repository($cache, $config, $city,$condition, $resource, $current);       
            
            $founded = $one->findByCitySlug($cities->last()->id);
            
            $this->assertNotNull($founded);  
        }        

        public function testSimpleAll() 
        {
            
            $current    = $this->getCurrentMock(); 
            
            $city       = $this->getCityRepoMock();
            
            $currents   = factory(\App\WeatherCurrent::class, 5)->make();        
            
            $current->shouldReceive('all')->andReturn($currents);
            
            $current->shouldReceive('getAttribute')->andReturnSelf();
            
            $current->shouldReceive('get')->andReturn($currents);                   
            
            $condition  = $this->getConditionMock();
                 
            $resource   = $this->getWeatherForeCastResourceMock();
                 
            $cache      = $this->getMockedCache();           
            
            $config     = $this->getMockedConfig();
            
            $config->shouldReceive('get')->andReturn(30);
            
            $one = new Repository($cache, $config, $city,$condition, $resource, $current); 
            
            $this->assertCount($currents->count(), $one->all());                     
        }
        
        public function testSimpleSelectCity() 
        {            
            $current    = $this->getCurrentMock(); 
            
            $cityModel  = $this->getCityRepoMock();
            
            $city       = m::mock('App\City');
            
            $city->exists = true;
            
            $condition  = $this->getConditionMock();            
                 
            $resource   = $this->getWeatherForeCastResourceMock();           
                 
            $cache      = $this->getMockedCache();           
            
            $config     = $this->getMockedConfig();
            
            $config->shouldReceive('get')->andReturn(30);
            
            $one = new Repository($cache, $config, $cityModel,$condition, $resource,$current); 
            
            $one->selectCity($city);
        }       
        
        public function tearDown()
        {
            parent::tearDown();
            
            m::close();
        }
  
}
