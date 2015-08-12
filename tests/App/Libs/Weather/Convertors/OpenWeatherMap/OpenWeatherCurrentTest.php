<?php

use App\Libs\Weather\Convertors\OpenWeatherMap\Current;


class OpenWeatherCurrentTest extends \TestCase
{ 
    
    
    /**
     * Current
     *
     * @var string
     */
    private $current= '{
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
                    "snow":{"3h":1},
                    "clouds":{"all":92},
                    "dt":1369824698,
                    "id":1851632,
                    "name":"Shuzenji",
                    "cod":200
                }';
    
        public function testSimple()
        {
            $current = new Current(null);  
          
        }   
        
        public function testGetWeatherData()
        {
            $jsonObject = json_decode($this->current); 
            $current = new Current($jsonObject);  
            
            $weatherAble = $current->getWeatherData();          
        }
        
        public function testCheckData()
        {
            $jsonObject = json_decode($this->current); 
            
            $current = new Current($jsonObject);             
            
            $weatherAble = $current->getWeatherData();        
           
            // check city attributes
            $this->assertEquals($jsonObject->id, $weatherAble['city']['id']);
            $this->assertEquals($jsonObject->name, $weatherAble['city']['name']);
            $this->assertEquals($jsonObject->sys->country, $weatherAble['city']['country']);            
            $this->assertEquals($jsonObject->coord->lat, $weatherAble['city']['latitude']);
            $this->assertEquals($jsonObject->coord->lon, $weatherAble['city']['longitude']);            
            // check weather condition attributes
            $this->assertEquals($jsonObject->weather[0]->id, $weatherAble['weather_condition'][0]['open_weather_map_id']);
            $this->assertEquals($jsonObject->weather[0]->main, $weatherAble['weather_condition'][0]['name']);
            $this->assertEquals($jsonObject->weather[0]->main, $weatherAble['weather_condition'][0]['orgin_name']);
            $this->assertEquals($jsonObject->weather[0]->description, $weatherAble['weather_condition'][0]['description']);
            $this->assertEquals($jsonObject->weather[0]->description, $weatherAble['weather_condition'][0]['orgin_description']);   
            
            // check weather forcast resource attributes            
            $openWeatherMapApi = [
                
                    'name'                  => 'openweathermap',
                    'description'           => 'Current weather conditions in cities for world wide',
                    'url'                   => 'openweathermap.org',
                    'api_url'               => 'api.openweathermap.org/data/2.5/weather',            
                    'enable'                => 1,
                    'paid'                  => 0,
                    'apiable'               => true,
                ];            
      
            $this->assertEquals($openWeatherMapApi['name'], $weatherAble['weather_forecast_resource']['name']);
            $this->assertEquals($openWeatherMapApi['description'], $weatherAble['weather_forecast_resource']['description']);  
            $this->assertEquals($openWeatherMapApi['url'], $weatherAble['weather_forecast_resource']['url']);  
            $this->assertEquals($openWeatherMapApi['api_url'], $weatherAble['weather_forecast_resource']['api_url']);  
            $this->assertEquals($openWeatherMapApi['enable'], $weatherAble['weather_forecast_resource']['enable']);  
            $this->assertEquals($openWeatherMapApi['paid'], $weatherAble['weather_forecast_resource']['paid']);  
            $this->assertEquals($openWeatherMapApi['apiable'], $weatherAble['weather_forecast_resource']['apiable']);
            
            // check weather main attributes
            $this->assertEquals($jsonObject->main->temp, $weatherAble['weather_main']['temp']);
            $this->assertEquals($jsonObject->main->temp_min, $weatherAble['weather_main']['temp_min']);
            $this->assertEquals($jsonObject->main->temp_max, $weatherAble['weather_main']['temp_max']);
            $this->assertEquals($jsonObject->main->pressure, $weatherAble['weather_main']['pressure']);
            $this->assertEquals($jsonObject->main->humidity, $weatherAble['weather_main']['humidity']);
            
            // check weather wind attributes
            $this->assertEquals($jsonObject->wind->speed, $weatherAble['weather_wind']['speed']);
            $this->assertEquals($jsonObject->wind->deg, $weatherAble['weather_wind']['deg']);  
            
            // check weather wind attributes
            $this->assertEquals($jsonObject->rain->{'3h'}, $weatherAble['weather_rain']['3h']);
            $this->assertEquals(null,$weatherAble['weather_rain']['rain']); 
            
            // check weather snow attributes
            $this->assertEquals($jsonObject->snow->{'3h'}, $weatherAble['weather_snow']['3h']);
            $this->assertEquals(null,$weatherAble['weather_snow']['snow']);  
            
            // check weather clouds attributes
            $this->assertEquals($jsonObject->clouds->all, $weatherAble['weather_clouds']['all']);            
               
            // check weather clouds attributes
            $timestamp = \Carbon\Carbon::createFromTimestamp($jsonObject->dt)->format('Y-m-d H:m:s'); 
            $this->assertEquals($timestamp, $weatherAble['source_updated_at']);        
        }
        
        
        public function testSimpleGetWeather()
        {
            
            $jsonObject = json_decode($this->current); 
            
            $weatherCurrent = (new Current($jsonObject))->getWeatherData();
            
            $this->assertTrue($weatherCurrent->isFilledRequiredElements());
            
            $this->assertNotEmpty($weatherCurrent->toArray());               
        } 
        
        
        public function testWithoutSnowRainAttributes()
        {
             $current= '{
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
                    
                    "clouds":{"all":92},
                    "dt":1369824698,
                    "id":1851632,
                    "name":"Shuzenji",
                    "cod":200
                }';
             
            $jsonObject = json_decode($current);  
            $weatherCurrent = (new Current($jsonObject))->getWeatherData(); 
            
            $this->assertTrue($weatherCurrent->isFilledRequiredElements());
            
            $this->assertNotEmpty($weatherCurrent->toArray());               
        }
        
        public function testWithoutSnowRainNoAttributes()
        {
             $current= '{
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
                    "snow": {},
                    "rain": {},
                    "clouds":{"all":92},
                    "dt":1369824698,
                    "id":1851632,
                    "name":"Shuzenji",
                    "cod":200
                }';
             
            $jsonObject = json_decode($current);  
            $weatherCurrent = (new Current($jsonObject))->getWeatherData(); 
            
            $this->assertTrue($weatherCurrent->isFilledRequiredElements());
            
            $this->assertNotEmpty($weatherCurrent->toArray());               
        }
}