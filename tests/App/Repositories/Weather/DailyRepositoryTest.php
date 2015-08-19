<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
//use Illuminate\Foundation\Testing\DatabaseTransactions;


use App\Repositories\Weather\DailyStat as Repository;
use App\Libs\Weather\OpenWeatherMap;

use Mockery as m;

/**
 * Current Repository Test Class
 * 
 * @package WeatherForcast
 */
class DailyRepositoryTest extends \TestCase
{    

    /**
     * Example of json response
     *
     * @var string JSON 
     */
    private $jsonExample ='{"city":{"id":524901,"name":"Moscow","coord":{"lon":37.615555,"lat":55.75222},"country":"RU","population":0},"cod":"200","message":0.0324,"cnt":16,"list":[{"dt":1439974800,"temp":{"day":16.94,"min":9.22,"max":18.32,"night":9.22,"eve":17.95,"morn":14.12},"pressure":1011.85,"humidity":50,"weather":[{"id":800,"main":"Clear","description":"Açık","icon":"01d"}],"speed":6.46,"deg":17,"clouds":0},{"dt":1440061200,"temp":{"day":19.65,"min":6.97,"max":21.61,"night":11.08,"eve":21.29,"morn":6.97},"pressure":1015.87,"humidity":51,"weather":[{"id":800,"main":"Clear","description":"Açık","icon":"01d"}],"speed":4.46,"deg":32,"clouds":0},{"dt":1440147600,"temp":{"day":22.34,"min":8.48,"max":23.72,"night":11.33,"eve":22.99,"morn":8.48},"pressure":1016.02,"humidity":50,"weather":[{"id":800,"main":"Clear","description":"Açık","icon":"01d"}],"speed":3.06,"deg":8,"clouds":0},{"dt":1440234000,"temp":{"day":23.59,"min":8.45,"max":24.8,"night":14.18,"eve":24.15,"morn":8.45},"pressure":1013.57,"humidity":49,"weather":[{"id":800,"main":"Clear","description":"Açık","icon":"01d"}],"speed":2.76,"deg":355,"clouds":0},{"dt":1440320400,"temp":{"day":22.79,"min":14.64,"max":22.79,"night":14.64,"eve":18.28,"morn":19.5},"pressure":1007.5,"humidity":0,"weather":[{"id":500,"main":"Rain","description":"Hafif yağmur","icon":"10d"}],"speed":2.5,"deg":66,"clouds":49,"rain":0.44},{"dt":1440406800,"temp":{"day":19.18,"min":7.49,"max":19.18,"night":7.49,"eve":13.41,"morn":15.94},"pressure":1010.74,"humidity":0,"weather":[{"id":800,"main":"Clear","description":"Açık","icon":"01d"}],"speed":5.97,"deg":65,"clouds":0},{"dt":1440493200,"temp":{"day":19.52,"min":9.45,"max":19.52,"night":9.45,"eve":14.98,"morn":14.82},"pressure":1010.92,"humidity":0,"weather":[{"id":500,"main":"Rain","description":"Hafif yağmur","icon":"10d"}],"speed":5.47,"deg":25,"clouds":31,"rain":1},{"dt":1440579600,"temp":{"day":16.37,"min":6.7,"max":16.37,"night":6.7,"eve":12.03,"morn":12.31},"pressure":1015.72,"humidity":0,"weather":[{"id":500,"main":"Rain","description":"Hafif yağmur","icon":"10d"}],"speed":6.39,"deg":31,"clouds":18},{"dt":1440666000,"temp":{"day":16.79,"min":7.22,"max":16.79,"night":7.22,"eve":12.33,"morn":10.66},"pressure":1018.42,"humidity":0,"weather":[{"id":800,"main":"Clear","description":"Açık","icon":"01d"}],"speed":5.22,"deg":3,"clouds":10},{"dt":1440752400,"temp":{"day":19.82,"min":10.38,"max":19.82,"night":10.38,"eve":14.71,"morn":12.9},"pressure":1018.06,"humidity":0,"weather":[{"id":800,"main":"Clear","description":"Açık","icon":"01d"}],"speed":7.07,"deg":6,"clouds":0},{"dt":1440838800,"temp":{"day":20.51,"min":7.37,"max":20.51,"night":7.37,"eve":14.29,"morn":15.32},"pressure":1019.5,"humidity":0,"weather":[{"id":500,"main":"Rain","description":"Hafif yağmur","icon":"10d"}],"speed":4.78,"deg":9,"clouds":0},{"dt":1440925200,"temp":{"day":20.24,"min":10.61,"max":20.24,"night":10.61,"eve":14.45,"morn":14.69},"pressure":1015.19,"humidity":0,"weather":[{"id":500,"main":"Rain","description":"Hafif yağmur","icon":"10d"}],"speed":5.43,"deg":319,"clouds":43,"rain":0.66},{"dt":1441011600,"temp":{"day":18.14,"min":9.4,"max":18.14,"night":9.4,"eve":13.68,"morn":14.08},"pressure":1016.98,"humidity":0,"weather":[{"id":500,"main":"Rain","description":"Hafif yağmur","icon":"10d"}],"speed":2.95,"deg":38,"clouds":48,"rain":1.33},{"dt":1441098000,"temp":{"day":22.03,"min":13.06,"max":22.03,"night":13.06,"eve":17.32,"morn":15.77},"pressure":1018.65,"humidity":0,"weather":[{"id":800,"main":"Clear","description":"Açık","icon":"01d"}],"speed":5.34,"deg":325,"clouds":0},{"dt":1441184400,"temp":{"day":23.19,"min":12.37,"max":23.19,"night":12.37,"eve":18.71,"morn":17.54},"pressure":1015.33,"humidity":0,"weather":[{"id":800,"main":"Clear","description":"Açık","icon":"01d"}],"speed":8.14,"deg":306,"clouds":26},{"dt":1441270800,"temp":{"day":12.37,"min":12.37,"max":12.37,"night":12.37,"eve":12.37,"morn":12.37},"pressure":1013.89,"humidity":0,"weather":[{"id":800,"main":"Clear","description":"Açık","icon":"01ddd"}],"speed":3.98,"deg":301,"clouds":11}]}';
    
    
        public function setUp()
        {
            parent::setUp();                
        }        
        
        /***
         * 
         * @return \App\Libs\Weather\DataType\WeatherDataAble
         */
        private function getAccessorWithSampleData()
        {
            $data = $this->jsonExample;
            
            return (new OpenWeatherMap($data))->daily();
        }
        
        /**
         * Mocked WeatherCurrent Model
         * 
         * @return \Mockery\MockInterface
         */
        private function getDailyStatMock()
        {
            return m::mock('App\Weather\DailyStat');            
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
         * Mocked City Repo Model
         * 
         * @return \Mockery\MockInterface
         */
        private function getCityRepoMock()
        {
            return m::mock('App\Contracts\Repository\ICity');            
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
       
        /**
         * Mocked List Repositpry Model
         * 
         * @return \Mockery\MockInterface
         */
        private function getWeatherListRepoMock()
        {
            return m::mock('App\Repositories\Weather\ListRepo');
        }
        
        /**
         * Mocked Conditions Repository Model
         * 
         * @return \Mockery\MockInterface
         */
        private function getConditionRepoMock()
        {
            return m::mock('App\Contracts\Weather\Repository\Condition');
        }        
        
        public function testSimple()
        {   
            $hourly     = $this->getDailyStatMock();
            
            $city       = $this->getCityRepoMock();
            
            $condition  = $this->getConditionRepoMock();
            
            $resource   = $this->getWeatherForeCastResourceMock();
            
            $cache      = $this->getMockedCache();           
            
            $config     = $this->getMockedConfig();
            
            $config->shouldReceive('get')->andReturn(30);
            
            $listRepo   = $this->getWeatherListRepoMock();
            
            $one = new Repository($cache, $config, $city,$condition, $resource, $hourly, $listRepo);
          
        }       
        
        public function atestSelectCity()
        {   
            $hourly     = $this->getHourlyStatMock();
            
            $cityRepo   = $this->getCityRepoMock();
            
            $cityRepo->shouldReceive('firstOrCreateWeatherHouryStat')->andReturn();
            
            $city       = $this->getCityMock();
            
            $city->exists = true;                    
            
            $condition  = $this->getConditionRepoMock();
            
            $resource   = $this->getWeatherForeCastResourceMock();
            
            $cache      = $this->getMockedCache();           
            
            $config     = $this->getMockedConfig();
            
            $config->shouldReceive('get')->andReturn(30);
            
            $listRepo   = $this->getWeatherListRepoMock();
            
            $one = new Repository($cache, $config, $cityRepo, $condition, $resource, $hourly, $listRepo);
            
            $accessor = $this->getAccessorWithSampleData();
            
            $one->selectCity($city);                    
        }  
        
        public function tearDown()
        {
            parent::tearDown();
            
            m::close();
        }
  
}
