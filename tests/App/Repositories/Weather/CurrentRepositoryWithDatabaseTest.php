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
                    "snow":{"3h":0},
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
            
            $selectCity = $cities->random();
            
            $model = $one->selectCity($selectCity)->import($weatherCurrent);
//            
//           
//              "coord":{"lon":139,"lat":35},
//                    "sys":{"country":"JP","sunrise":1369769524,"sunset":1369821049},
//                    "weather":[{"id":804,"main":"clouds","description":"overcast clouds","icon":"04n"}], 
//                    "main":{
//                                    "temp":289.5,
//                                    "humidity":89,
//                                    "pressure":1013,
//                                    "temp_min":287.04,
//                                    "temp_max":292.04
//                                    },
//                    "wind":{"speed":7.31,"deg":187.002}, 
//                    "rain":{"3h":0},
//                    "snow":{"3h":0},
//                    "clouds":{"all":92},
//                    "dt":1369824698,
//                    "id":1851632,
//                    "name":"Shuzenji",
//                    "cod":200
            $this->assertEquals($model->sys->sunrise, $weatherCurrent['weather_sys']->sunrise);
            $this->assertEquals($model->sys->sunset, $weatherCurrent['weather_sys']->sunset);
            $this->assertEquals($model->sys->country, $weatherCurrent->weather_sys->country);        
            $this->assertEquals($model->condition->open_weather_map_id, $weatherCurrent['weather_condition']->open_weather_map_id);  
            $this->assertEquals($model->condition->name, $weatherCurrent['weather_condition']->name);
            $this->assertEquals($model->condition->description, $weatherCurrent['weather_condition']->description);
            $this->assertEquals($model->condition->orgin_description, $weatherCurrent['weather_condition']->description);
            $this->assertEquals($model->main->temp, $weatherCurrent['weather_main']->temp);
            $this->assertEquals($model->main->temp, $weatherCurrent['weather_main']->temp);
            $this->assertEquals($model->main->humidity, $weatherCurrent['weather_main']->humidity);
            $this->assertEquals($model->main->pressure, $weatherCurrent['weather_main']->pressure);
            $this->assertEquals($model->main->temp_min, $weatherCurrent['weather_main']->temp_min);
            $this->assertEquals($model->main->temp_max, $weatherCurrent['weather_main']->temp_max);
           
            $this->assertEquals($model->wind->speed, $weatherCurrent['weather_wind']->speed);
            $this->assertEquals($model->wind->deg, $weatherCurrent['weather_wind']->deg);
            $this->assertEquals($model->rains->first()->{'3h'}, $weatherCurrent['weather_rain']['3h']);
            $this->assertEquals($model->snows->first()->{'3h'}, $weatherCurrent['weather_snow']['3h']);            
            $this->assertEquals($model->clouds->all, $weatherCurrent['weather_clouds']->all);            
            $this->assertEquals($model['source_updated_at'], $weatherCurrent['source_updated_at']);
            $this->assertEquals($model->city->name, $selectCity->name); 
        }                
}
