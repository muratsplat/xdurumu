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
            
            $one = new Repository($cache, $config, $city);          
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
            
            return new Repository($cache, $config, $city);        
        }        
        
        public function testFind()
        {           
            $cities = factory(\App\City::class, 5)->create();            
            
            $repo = $this->getCityRepository();            
            
            $one = $cities->random();
            
            $founded = $repo->find($one->id);
            
            $this->assertNotNull($founded);   
            
            $notExists = $repo->find(99);
            
            $this->assertNull($notExists);            
        }        
    
        public function testFindByCitySlug()
        {              
            $cities = factory(\App\City::class, 5)->create();            
            
            $repo = $this->getCityRepository();            
            
            $one = $cities->random();
            
            $oneBySlug = $repo->findBySlug($one->slug);
            
            $this->assertNotNull($oneBySlug);
            
            $this->assertEquals($oneBySlug->id, $one->id);
            
            $notExists = $repo->findBySlug('fooBıraBıra');
            
            $this->assertNull($notExists);           
        }        

        public function testSimpleAll() 
        {            
            $cities = factory(\App\City::class, 5)->create();            
            
            $repo = $this->getCityRepository();            
            
            $this->assertCount($cities->count(), $repo->all());
            $this->assertCount($cities->count(), $repo->enableCache()->all());           
        }
        
        public function testFirstOrCreateWeatherHouryStat()
        {            
            $city = factory(\App\City::class)->create();             
            
            $repo = $this->getCityRepository();    
            
            $hourlyStat = $repo->firstOrCreateWeatherHouryStat($city);
            
            $this->assertNotNull($hourlyStat);            
            
            $hourlyStat2 = $repo->firstOrCreateWeatherHouryStat($city);
            
            $this->assertEquals($hourlyStat2->id, $hourlyStat->id);            
        }
        
        public function testFirstOrCreateWeatherCurrent()
        {            
            $city = factory(\App\City::class)->create();             
            
            $repo = $this->getCityRepository();    
            
            $current = $repo->firstOrCreateWeatherCurrent($city);
            
            $this->assertNotNull($current);            
            
            $current2 = $repo->firstOrCreateWeatherCurrent($city);
            
            $this->assertEquals($current2->id, $current->id);            
        }  
        
        
        public function testGetHourlyStatByCity()
        {            
            $city = $this->createCity();
            
            $hourly = factory(App\WeatherHourlyStat::class)->create(['city_id' => $city->id]);
            
            $city->weatherHourlyStat()->save($hourly);      
            
            $repo = $this->getCityRepository();        
            
            $this->assertEquals($hourly->id, $repo->getHourlyStatByCity($city)->id);          
        }
        
        public function testDeleteOldHourlyLists()
        {            
            $city = $this->createCity();
            
            $hourly = factory(App\WeatherHourlyStat::class)->create(['city_id' => $city->id]);
            
            $city->weatherHourlyStat()->save($hourly);      
            
            $allWeatherlist = $this->createWeatherList(120);
            
            $some = $allWeatherlist->take(50);
            
            $stat = $city->weatherHourlyStat;
                      
            $stat->weatherLists()->saveMany($some);
            
            $this->assertCount(50, $stat->weatherLists);            
           
            $repo = $this->getCityRepository();        
            
            $deletes = $repo->deleteOldHourlyLists($city);
            
            $this->assertEquals($deletes, $some->count() - 37);
            
            $this->assertEquals($allWeatherlist->count() - $deletes, \App\WeatherList::all()->count());            
            
            $this->assertCount(37, $repo->getAllHourlyListByCity($city));
        }        
        
        
        public function testGetDailyStatByCity()
        {            
            $city = $this->createCity();
            
            $daily = factory(App\Weather\DailyStat::class)->create(['city_id' => $city->id]);
            
            $city->weatherDailyStat()->save($daily);      
            
            $repo = $this->getCityRepository();        
            
            $this->assertEquals($daily->id, $repo->getDailyStatByCity($city)->id);          
        }
        
        public function testDeleteOldDailyLists()
        {            
            $city = $this->createCity();
            
            $daily = factory(App\Weather\DailyStat::class)->create(['city_id' => $city->id]);
            
            $city->weatherDailyStat()->save($daily);      
            
            $allWeatherlist = $this->createWeatherList(120);
            
            $some = $allWeatherlist->take(50);
            
            $stat = $city->weatherDailyStat;
                      
            $stat->weatherLists()->saveMany($some);
            
            $this->assertCount(50, $stat->weatherLists);            
           
            $repo = $this->getCityRepository();        
            
            $deletes = $repo->deleteOldDailyLists($city);
            
            $this->assertEquals($deletes, $some->count() - 16);
            
            $this->assertEquals($allWeatherlist->count() - $deletes, \App\WeatherList::all()->count());            
            
            $this->assertCount(16, $repo->getAllDailyListByCity($city));
        }        
        
        public function testDeleteOldLists()
        {            
            $city = $this->createCity();
            
            $daily = factory(App\Weather\DailyStat::class)->create(['city_id' => $city->id]);
            
            $hourly = factory(App\WeatherHourlyStat::class)->create(['city_id' => $city->id]);
            
            $city->weatherHourlyStat()->save($hourly);      
            
            $city->weatherDailyStat()->save($daily);      
            
            $allWeatherlist = $this->createWeatherList(120);
            
            $fordaily       = $allWeatherlist->take(60);
            
            $forHourly      = $allWeatherlist->take(-60);
            
            $statDaily      = $city->weatherDailyStat;
            $statHourly     = $city->weatherHourlyStat;            
                      
            $statDaily->weatherLists()->saveMany($fordaily);             
            $statHourly->weatherLists()->saveMany($forHourly);  
            
            $repo = $this->getCityRepository();           
            
            $deletes = $repo->deleteOldListsByCity($city);
            
            $this->assertEquals((60-16) + (60-37), $deletes);
            
            $this->assertEquals(120 - ((60-16) + (60-37)),  \App\WeatherList::all()->count() );
         
        } 
        
        
        /**
         * 
         * @param int $count
         * @return \Illuminate\Database\Eloquent\Collection
         */
        private function createWeatherList($count)
        {            
            return factory(\App\WeatherList::class,$count)->create();            
        }
        
        
        /**
         * 
         * @return \App\City
         */
        private function createCity()
        {
            return factory(\App\City::class)->create();        
        }
        
        public function testAllOnlyOnesHasWeatherData()
        {            
            $cityNumber = 10;
            
            $cities = factory(App\City::class, $cityNumber)->create();
            
            $cities->random(3)->each(function($city){
                
                $city->weatherDailyStat()->create([]);
                $city->weatherCurrent()->create([]);
                $city->weatherHourlyStat()->create([]);                
            });
            
            $repo = $this->getCityRepository();
            
            
            $all = $repo->getAllOnlyOnesHasWeatherData();     
            
            $this->assertCount(3, $all);         
        } 
}