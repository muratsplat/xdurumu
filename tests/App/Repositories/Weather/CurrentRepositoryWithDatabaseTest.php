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
        
        
        private function createCities($count=2)
        {
            return factory(App\City::class, $count)->create();   
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
            $cities = $this->createCities(3);
            
            $this->assertCount(3, $cities);
            
            $city = $this->getCity();
            
            $condition = $this->getCondition();
            
            $resource = $this->getResource();
            
            $current  = $this->getCurrent();
            
            $one = new Repository($city,$condition, $resource, $current);
          
        }
        
        
        public function testSelectCity()
        {   
            $cities = $this->createCities(3);
            
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
            
            $weatherData = (new OpenWeatherMap($this->jsonExample))->current()->getWeatherData();  
            
            $weatherCurrent = (new OpenWeatherMap($this->jsonExample))->current();  
            
            $cities = $this->createCities(3);
            
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
            $this->assertEquals($model->sys->sunrise, $weatherData['weather_sys']->sunrise);
            $this->assertEquals($model->sys->sunset, $weatherData['weather_sys']->sunset);
            $this->assertEquals($model->sys->country, $weatherData->weather_sys->country);        
            $this->assertEquals($model->condition->open_weather_map_id, $weatherData['weather_condition']->open_weather_map_id);  
            $this->assertEquals($model->condition->name, $weatherData['weather_condition']->name);
            $this->assertEquals($model->condition->description, $weatherData['weather_condition']->description);
            $this->assertEquals($model->condition->orgin_description, $weatherData['weather_condition']->description);
            $this->assertEquals($model->main->temp, $weatherData['weather_main']->temp);
            $this->assertEquals($model->main->temp, $weatherData['weather_main']->temp);
            $this->assertEquals($model->main->humidity, $weatherData['weather_main']->humidity);
            $this->assertEquals($model->main->pressure, $weatherData['weather_main']->pressure);
            $this->assertEquals($model->main->temp_min, $weatherData['weather_main']->temp_min);
            $this->assertEquals($model->main->temp_max, $weatherData['weather_main']->temp_max);
           
            $this->assertEquals($model->wind->speed, $weatherData['weather_wind']->speed);
            $this->assertEquals($model->wind->deg, $weatherData['weather_wind']->deg);
            $this->assertEquals($model->rains->first()->{'3h'}, $weatherData['weather_rain']['3h']);
            $this->assertEquals($model->snows->first()->{'3h'}, $weatherData['weather_snow']['3h']);            
            $this->assertEquals($model->clouds->all, $weatherData['weather_clouds']->all);            
            $this->assertEquals($model['source_updated_at'], $weatherData['source_updated_at']);
            $this->assertEquals($model->city->name, $selectCity->name); 
        }
        
        public function testImportTwentyTimes()
        {               
            $weatherCurrent = (new OpenWeatherMap($this->jsonExample))->current();         
            
            $cities = $this->createCities(10);
            
            $this->assertCount(10, $cities);
            
            $city = $this->getCity();
            
            $condition = $this->getCondition();
            
            $resource = $this->getResource();
            
            $current  = $this->getCurrent();
            
            $one = new Repository($city,$condition, $resource, $current);
            
            $selectCity = $cities->random();
            
            $weatherCurrents = [];
            
            foreach ($cities as $eachCity) {                
                
                $weatherCurrents[] = $one->selectCity($eachCity)->import($weatherCurrent);                                
            }
            
            $this->assertCount(10,$weatherCurrents);            
            $this->assertCount(10, App\WeatherCurrent::all());
            $this->assertCount(10, App\WeatherMain::all());
            $this->assertCount(10, App\WeatherSnow::all());
            $this->assertCount(10, App\WeatherRain::all());
            $this->assertCount(10, App\WeatherSys::all());
            $this->assertCount(1, App\WeatherCondition::all());
            $this->assertCount(1, App\WeatherForeCastResource::all());
            $this->assertCount(10, App\WeatherWind::all());
            $this->assertCount(10, App\WeatherCloud::all());
            
            foreach ($cities as $eachCity) {                
                
                $weatherCurrents[] = $one->selectCity($eachCity)->import($weatherCurrent);                                
            }
            
            $this->assertCount(20, $weatherCurrents);            
            $this->assertCount(10, App\WeatherCurrent::all());
            $this->assertCount(10, App\WeatherMain::all());
            $this->assertCount(10, App\WeatherSnow::all());
            $this->assertCount(10, App\WeatherRain::all());
            $this->assertCount(10, App\WeatherSys::all());
            $this->assertCount(1, App\WeatherCondition::all());
            $this->assertCount(1, App\WeatherForeCastResource::all());
            $this->assertCount(10, App\WeatherWind::all());
            $this->assertCount(10, App\WeatherCloud::all());
        }
}
