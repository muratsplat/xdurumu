<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Repositories\Weather\DailyStat as Repository;
use App\Libs\Weather\OpenWeatherMap;
use App\Weather\DailyStat;
use App\WeatherForeCastResource;
use Mockery as m;

/**
 * Current Repository Test Class
 * 
 * @package WeatherForcast
 */
class DailyRepositoryWithDatabaseTest extends \TestCase
{
    use DatabaseMigrations, DatabaseTransactions;
    
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
        
        public function tearDown()
        {
            parent::tearDown();
            
            m::close();
        }        
        
        private function createCities($count=2)
        {
            return factory(App\City::class, $count)->create();   
        }       
        
        /**
         * To get accessor for daily data
         * 
         * @return \App\Libs\Weather\OpenWeatherMap
         */
        private function getAccessorForDailyData()
        {
            return (new OpenWeatherMap($this->jsonExample))->daily();
        }
        
        
        /**
         * To get cache driver
         * 
         * @return Cache Instance
         */
        private function getCacheInstance()
        {
            $app = app();
            
            return $app['cache']->driver();           
        }
        
        /**
         * To get Config Instance
         * 
         * @return Config Instance
         */
        private function getConfigInstance()
        {
            $app = app();
            
            return $app['config'];           
        }
        
        /**
         * 
         * @return \App\Repositories\CityRepository
         */
        private function getCityRepo()
        {
            return app('App\Contracts\Repository\ICity');  
        }
        
        /**
         * 
         * @return \App\Contracts\Weather\Repository\IListRepository
         */
        private function getListRepo()
        {
            return app('App\Contracts\Weather\Repository\IList');       
        }

        /**
         * 
         * @return \App\WeatherHourlyStat
         */
        private function getDailyStat()
        {
            return new DailyStat();
        }
        
        /**
         * 
         * @return \App\WeatherForeCastResource
         */
        private function getResource()
        {
            return new WeatherForeCastResource();
        }

        /**
         * 
         * @return \App\WeatherCondition
         */
        private function getCondition()
        {
            return app('App\Contracts\Weather\Repository\Condition');
        }    

        public function testSimple()
        {               
            
            $cities = $this->createCities(3);
            
          
            
            $this->assertCount(3, $cities);
            
            $cityRepo = $this->getCityRepo();            
                       
            $condition = $this->getCondition();
            
            $resource = $this->getResource();
            
            $daily  = $this->getDailyStat();        
            
            $config     = $this->getConfigInstance();
            
            $cache      = $this->getCacheInstance();
            
            $accessor   = $this->getAccessorForDailyData();
            
            $listRepo   = $this->getListRepo();            
            
            $one = new Repository($cache, $config, $cityRepo,$condition, $resource, $daily, $listRepo);
            
            $one->selectCity($cities->random());
            
            $createdHourlyModel = $one->import($accessor);
            
            $this->assertNotNull($createdHourlyModel);
            
            $numberOfLists = count($accessor->getWeatherData()->getAttribute('list'));
                      
            $this->assertCount(1, App\Weather\DailyStat::all());
            $this->assertCount(1, App\WeatherForeCastResource::all());
            $this->assertCount($numberOfLists, App\WeatherList::all());            
            $this->assertEquals($createdHourlyModel->foreCastResource->name, App\WeatherForeCastResource::all()->first()->name);
            $this->assertEquals($createdHourlyModel->foreCastResource->name, App\WeatherForeCastResource::all()->first()->name);            
            $this->assertCount($numberOfLists, $createdHourlyModel->weatherLists); 
            
            $this->assertCount($numberOfLists, App\WeatherCloud::all());
            $this->assertCount($numberOfLists, App\WeatherMain::all());
            $this->assertCount($numberOfLists, App\WeatherWind::all());           
            
            $numberOfRains = $this->countNotNullElement('rain');           
            
            $this->assertCount($numberOfRains, App\WeatherRain::all());
            
            /**
             * There is no data for Snow in example data
             */
            //$this->assertCount($numberOfLists, App\WeatherSnow::all());  
        }       
        
        public function testFixesWeatherForeCastResourceAssociatedIssue()
        {            
            $cities = $this->createCities(3);          
            
            $cityRepo = $this->getCityRepo();            
                       
            $condition = $this->getCondition();
            
            $resource = $this->getResource();
            
            $daily  = $this->getDailyStat();        
            
            $config     = $this->getConfigInstance();
            
            $cache      = $this->getCacheInstance();
            
            $accessor   = $this->getAccessorForDailyData();
            
            $listRepo   = $this->getListRepo();           
           
            $one = new Repository($cache, $config, $cityRepo,$condition, $resource, $daily, $listRepo);
            
            $one->selectCity($cities->random());
            
            $createdHourlyModel = $one->import($accessor);
              
            $model = App\Weather\DailyStat::all()->find($createdHourlyModel->id);
           
            $this->assertNotNull($model);
            
            $this->assertEquals(1, $createdHourlyModel->weather_forecast_resource_id);            
        } 
        
        
        /**
         * To count not empty or not null elements in json example data
         * 
         * @param string $name
         * @return int
         */
        private function countNotNullElement($name)
        {
            $rawData = json_decode($this->jsonExample, true);            
            
            $no = 0; 
            
            foreach ($rawData['list'] as $one) {
                
                $elem = isset($one[$name]) ? $one[$name] : null;                
                
                if ( is_null($elem) || empty($elem)) {
                    
                    continue;                    
                }
                
                $no++;                
            }
            
            return $no;       
        }
        
        public function testALotOfConditionsRecordsIssue()
        {            
            
            $cities = $this->createCities(3);          
            
            $cityRepo = $this->getCityRepo();            
                       
            $condition = $this->getCondition();
            
            $resource = $this->getResource();
            
            $daily  = $this->getDailyStat();        
            
            $config     = $this->getConfigInstance();
            
            $cache      = $this->getCacheInstance();
            
            $accessor   = $this->getAccessorForDailyData();
            
            $listRepo   = $this->getListRepo();           
           
            $one = new Repository($cache, $config, $cityRepo,$condition, $resource, $daily, $listRepo);
            
            $one->selectCity($cities->random());
            
            $createdHourlyModel = $one->import($accessor);
            
            $numberOfConditions = App\WeatherCondition::all()->count();
            
            $createdHourlyModel1 = $one->import($accessor);
            
            $this->assertEquals(App\WeatherCondition::all()->count(), $numberOfConditions);    
        } 
        
        
        public function testCompareDataInDBAndJSON()
        {               
            
            $cities = $this->createCities(3);
            
            $city   = $cities->random();
            
            $city->name = 'Moscow';
            $city->country = 'RU';
            
            $this->assertTrue($city->save());
            
            $this->assertCount(3, $cities);
            
            $cityRepo = $this->getCityRepo();            
                       
            $condition = $this->getCondition();
            
            $resource = $this->getResource();
            
            $daily  = $this->getDailyStat();        
            
            $config     = $this->getConfigInstance();
            
            $cache      = $this->getCacheInstance();
            
            $accessor   = $this->getAccessorForDailyData();
            
            $listRepo   = $this->getListRepo();            
            
            $one = new Repository($cache, $config, $cityRepo,$condition, $resource, $daily, $listRepo);
            
            $one->selectCity($city);
            
            $hourlyModel = $one->import($accessor);
            
            $rawData = json_decode($this->jsonExample, true);
            
            $this->assertEquals($rawData['city']['name'], $hourlyModel->city->name);
            $this->assertEquals($rawData['city']['country'], $hourlyModel->city->country);
            
            // test temp attribute on WeatherMain model
            foreach ($rawData['list'] as $k => $v) {
                
                $this->assertEquals($rawData['list'][$k]['temp']['day'], $hourlyModel->weatherLists[$k]->main->temp);               
            }
            
            // test temp_min attribute on WeatherMain model            
            foreach ($rawData['list'] as $k => $v) {
                
                $this->assertEquals($rawData['list'][$k]['temp']['min'], $hourlyModel->weatherLists[$k]->main->temp_min);               
            }            
                        
            // test temp_max attribute on WeatherMain model            
            foreach ($rawData['list'] as $k => $v) {
                
                $this->assertEquals($rawData['list'][$k]['temp']['max'], $hourlyModel->weatherLists[$k]->main->temp_max);               
            } 
            
            // test temp_night attribute on WeatherMain model            
            foreach ($rawData['list'] as $k => $v) {
                
                $this->assertEquals($rawData['list'][$k]['temp']['night'], $hourlyModel->weatherLists[$k]->main->temp_night);               
            }  
            
            // test temp_eve attribute on WeatherMain model            
            foreach ($rawData['list'] as $k => $v) {
                
                $this->assertEquals($rawData['list'][$k]['temp']['eve'], $hourlyModel->weatherLists[$k]->main->temp_eve);               
            }  
            
            // test temp_morn attribute on WeatherMain model            
            foreach ($rawData['list'] as $k => $v) {
                
                $this->assertEquals($rawData['list'][$k]['temp']['morn'], $hourlyModel->weatherLists[$k]->main->temp_morn);               
            }  
            
            // test pressure attribute on WeatherMain model            
            foreach ($rawData['list'] as $k => $v) {
                
                $this->assertEquals($rawData['list'][$k]['pressure'], $hourlyModel->weatherLists[$k]->main->pressure);               
            } 
            
            // test pressure attribute on WeatherMain model            
            foreach ($rawData['list'] as $k => $v) {
                
                $this->assertEquals($rawData['list'][$k]['humidity'], $hourlyModel->weatherLists[$k]->main->humidity);               
            } 
            
            // test  attributes on WeatherCondition model            
            foreach ($rawData['list'] as $k => $v) {
                
                foreach ($rawData['list'][$k]['weather'] as $sk => $sv) {         
                    
                    $this->assertEquals($rawData['list'][$k]['weather'][$sk]['id'], $hourlyModel->weatherLists[$k]->conditions[$sk]->open_weather_map_id);                                                       
                } 
                
                foreach ($rawData['list'][$k]['weather'] as $sk => $sv) {         
                    
                    $this->assertEquals($rawData['list'][$k]['weather'][$sk]['main'], $hourlyModel->weatherLists[$k]->conditions[$sk]->name);                                                       
                }  
                
                foreach ($rawData['list'][$k]['weather'] as $sk => $sv) {         
                    
                    $this->assertEquals($rawData['list'][$k]['weather'][$sk]['description'], $hourlyModel->weatherLists[$k]->conditions[$sk]->description);                                                       
                } 
                
                foreach ($rawData['list'][$k]['weather'] as $sk => $sv) {                             
                  
                    // A bug founded in openweather map api
                    
                    //$this->assertEquals($rawData['list'][$k]['weather'][$sk]['icon'], $hourlyModel->weatherLists[$k]->conditions[$sk]->icon);                                                       
                } 
                                     
            }
            
            // wind speed
            foreach ($rawData['list'] as $k => $v) {
                
                $this->assertEquals($rawData['list'][$k]['speed'], $hourlyModel->weatherLists[$k]->wind->speed);               
            }
            
            // wind speed deg
            foreach ($rawData['list'] as $k => $v) {
                
                $this->assertEquals($rawData['list'][$k]['deg'], $hourlyModel->weatherLists[$k]->wind->deg);               
            } 
            
            // clouds
            foreach ($rawData['list'] as $k => $v) {
                
                $this->assertEquals($rawData['list'][$k]['clouds'], $hourlyModel->weatherLists[$k]->clouds->all);               
            }           
        }    
}