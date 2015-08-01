<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


use App\Repositories\Weather\CurrentRepository as Repository;
use App\Libs\Weather\OpenWeatherMap;
use App\City;
use App\WeatherCurrent;
use App\WeatherCondition;
use App\WeatherForeCastResource;




/**
 * Current Repository Test Class
 * 
 * @package WeatherForcast
 */
class CurrentRepositoryWithDatabaseTest extends \TestCase
{
    use DatabaseMigrations, DatabaseTransactions;
    
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
            
           \Config::set('database.default', 'sqlite');  
        }
        
        
        private function createTwoCities()
        {
            return factory(App\City::class, 3)->create();   
        }
        
        /**
         * 
         * @return \App\City
         */
        private function getCity()
        {
            return new City();
        }

        /**
         * 
         * @return \App\WeatherCurrent
         */
        private function getCurrent()
        {
            return new  WeatherCurrent();
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
            return new WeatherCondition();
        }

        public function testSimple()
        {   
            $cities = $this->createTwoCities();
            
            $this->assertCount(3, $cities);
            
            $city = $this->getCity();
            
            $condition = $this->getCondition();
            
            $resource = $this->getResource();
            
            $current  = $this->getCurrent();
            
            $one = new Repository($city,$condition, $resource, $current);
          
        }
        
        
        public function testSelectCity()
        {   
            $cities = $this->createTwoCities();
            
            $this->assertCount(3, $cities);
            
            $city = $this->getCity();
            
            $condition = $this->getCondition();
            
            $resource = $this->getResource();
            
            $current  = $this->getCurrent();
            
            $one = new Repository($city,$condition, $resource, $current);
            
            $one->selectCity($cities->random());          
        }
        
        public function testImport()
        {   
            
            $weatherCurrent = (new OpenWeatherMap($this->jsonExample))->current()->getWeatherCurrent();     
            
            $cities = $this->createTwoCities();
            
            $this->assertCount(3, $cities);
            
            $city = $this->getCity();
            
            $condition = $this->getCondition();
            
            $resource = $this->getResource();
            
            $current  = $this->getCurrent();
            
            $one = new Repository($city,$condition, $resource, $current);
            
            $one->selectCity($cities->random())->import($weatherCurrent);
            
            
          
        }        
        

}
