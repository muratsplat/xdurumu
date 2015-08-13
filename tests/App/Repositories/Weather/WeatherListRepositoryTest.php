<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
//use Illuminate\Foundation\Testing\DatabaseTransactions;


use App\Repositories\Weather\ListRepository as Repository;
use App\Libs\Weather\OpenWeatherMap;
use Mockery as m;

/**
 * Current Repository Test Class
 * 
 * @package WeatherForcast
 */
class WeatherListRepositoryTest extends \TestCase
{    
        public function setUp()
        {
            parent::setUp();        
           
        }
        
        /**
         * Mocked WeatherCurrent Model
         * 
         * @return \Mockery\MockInterface
         */
        private function getHourlyStatMock()
        {
            return m::mock('App\WeatherHourlyStat');            
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
         * Mocked List Repository
         *  
         * @return \Mockery\MockInterface
         */
        private function getMockedListRepository()
        {
            return m::mock('App\Contracts\Weather\Repository\IListRepository');            
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
         * To get mocked WeatherList Object
         * 
         * @return \Mockery\MockInterface
         */
        private function getMockedWeaherList()
        {
            return m::mock('App\WeatherList');            
        }
        
        public function testSimple()
        {           
            //$condition  = $this->getConditionMock();
            
            //$resource   = $this->getWeatherForeCastResourceMock();
            
            $list       = $this->getMockedWeaherList();
            
            $cache      = $this->getMockedCache();           
            
            $config     = $this->getMockedConfig();
            
            $config->shouldReceive('get')->andReturn(30);
            
            $one = new Repository($cache, $config, $list);          
        }   
        
        public function tearDown()
        {
            parent::tearDown();
            
            m::close();
        }
  
}
