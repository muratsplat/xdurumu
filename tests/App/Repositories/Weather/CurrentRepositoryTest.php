<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
//use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\WeatherCurrent as Current;

use App\Repositories\Weather\CurrentRepository as Repository;
/**
 * Current Repository Test Class
 * 
 * @package WeatherForcast
 */
class CurrentRepositoryTest  extends \TestCase
{
    
    /**
     * @var \App\WeatherCurrent 
     */
    private $current;
    
    /**
     * @var \App\Repositories\Weather\CurrentRepository
     */
    private $repository;
    
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

            $this->current      = new Current();
            
            $this->repository   = new Repository($this->current);
        }
    
        public function testSimple()
        {   
            $current = $this->current;
            
            $one = new Repository($current);
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
  
}
