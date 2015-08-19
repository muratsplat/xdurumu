<?php

use App\Libs\Weather\Convertors\OpenWeatherMap\Daily;

class OpenWeatherMapDailyTest extends \TestCase
{   
    
     /**
     * Example oj JSON
     * 
     * Daily weather data
     *
     * @var string 
     */
    private  $daily = '{"city":{"id":1260206,"name":"Pasighat","coord":{"lon":95.333328,"lat":28.066669},"country":"IN","population":0},"cod":"200","message":0.0208,"cnt":16,"list":[{"dt":1439874000,"temp":{"day":293.51,"min":293.34,"max":293.51,"night":293.34,"eve":293.51,"morn":293.51},"pressure":902.33,"humidity":99,"weather":[{"id":502,"main":"Rain","description":"Şiddetli yağmur","icon":"10d"}],"speed":0.66,"deg":51,"clouds":100,"rain":25.39},{"dt":1439960400,"temp":{"day":293.72,"min":292.54,"max":293.72,"night":292.54,"eve":293.56,"morn":293.27},"pressure":903.9,"humidity":100,"weather":[{"id":502,"main":"Rain","description":"Şiddetli yağmur","icon":"10d"}],"speed":0.86,"deg":120,"clouds":92,"rain":43.61},{"dt":1440046800,"temp":{"day":293.87,"min":292.18,"max":294.32,"night":292.96,"eve":294.32,"morn":292.18},"pressure":905.47,"humidity":96,"weather":[{"id":502,"main":"Rain","description":"Şiddetli yağmur","icon":"10d"}],"speed":0.87,"deg":51,"clouds":92,"rain":36.55},{"dt":1440133200,"temp":{"day":294.08,"min":292.19,"max":294.08,"night":292.34,"eve":294.07,"morn":292.19},"pressure":919.79,"humidity":0,"weather":[{"id":502,"main":"Rain","description":"Şiddetli yağmur","icon":"10d"}],"speed":0.96,"deg":79,"clouds":79,"rain":30.09},{"dt":1440219600,"temp":{"day":296.26,"min":292.1,"max":296.26,"night":292.94,"eve":295.92,"morn":292.1},"pressure":918.74,"humidity":0,"weather":[{"id":501,"main":"Rain","description":"Orta şiddetli yağmur","icon":"10d"}],"speed":0.88,"deg":41,"clouds":48,"rain":7.2},{"dt":1440306000,"temp":{"day":300.29,"min":292.82,"max":300.29,"night":294.06,"eve":297.31,"morn":292.82},"pressure":917.51,"humidity":0,"weather":[{"id":500,"main":"Rain","description":"Hafif yağmur","icon":"10d"}],"speed":0.99,"deg":128,"clouds":4,"rain":2.65},{"dt":1440392400,"temp":{"day":300.28,"min":293.4,"max":300.28,"night":294.77,"eve":297.94,"morn":293.4},"pressure":917.77,"humidity":0,"weather":[{"id":500,"main":"Rain","description":"Hafif yağmur","icon":"10d"}],"speed":0.87,"deg":103,"clouds":7,"rain":2.07},{"dt":1440478800,"temp":{"day":300.39,"min":294.16,"max":300.39,"night":294.43,"eve":297.64,"morn":294.16},"pressure":917.31,"humidity":0,"weather":[{"id":501,"main":"Rain","description":"Orta şiddetli yağmur","icon":"10d"}],"speed":0.83,"deg":120,"clouds":6,"rain":7.75},{"dt":1440565200,"temp":{"day":299.04,"min":294.04,"max":299.04,"night":294.27,"eve":296.77,"morn":294.04},"pressure":916.26,"humidity":0,"weather":[{"id":501,"main":"Rain","description":"Orta şiddetli yağmur","icon":"10d"}],"speed":0.92,"deg":242,"clouds":25,"rain":10},{"dt":1440651600,"temp":{"day":299.53,"min":294.04,"max":299.53,"night":294.54,"eve":297.43,"morn":294.04},"pressure":916.67,"humidity":0,"weather":[{"id":501,"main":"Rain","description":"Orta şiddetli yağmur","icon":"10d"}],"speed":0.88,"deg":135,"clouds":37,"rain":4.45},{"dt":1440738000,"temp":{"day":299.99,"min":294.1,"max":299.99,"night":294.79,"eve":297.83,"morn":294.1},"pressure":917.7,"humidity":0,"weather":[{"id":501,"main":"Rain","description":"Orta şiddetli yağmur","icon":"10d"}],"speed":1.02,"deg":127,"clouds":46,"rain":4.32},{"dt":1440824400,"temp":{"day":299.27,"min":294.41,"max":299.27,"night":294.7,"eve":296.92,"morn":294.41},"pressure":919.61,"humidity":0,"weather":[{"id":501,"main":"Rain","description":"Orta şiddetli yağmur","icon":"10d"}],"speed":1.04,"deg":191,"clouds":66,"rain":5.22},{"dt":1440910800,"temp":{"day":298.36,"min":294.55,"max":298.36,"night":294.73,"eve":297.06,"morn":294.55},"pressure":920.91,"humidity":0,"weather":[{"id":501,"main":"Rain","description":"Orta şiddetli yağmur","icon":"10d"}],"speed":0.91,"deg":186,"clouds":74,"rain":9.05},{"dt":1440997200,"temp":{"day":300.91,"min":294.27,"max":300.91,"night":295.01,"eve":297.71,"morn":294.27},"pressure":922.51,"humidity":0,"weather":[{"id":501,"main":"Rain","description":"Orta şiddetli yağmur","icon":"10d"}],"speed":0.85,"deg":177,"clouds":16,"rain":6.57},{"dt":1441083600,"temp":{"day":300.14,"min":294.38,"max":300.14,"night":294.67,"eve":297.14,"morn":294.38},"pressure":923.81,"humidity":0,"weather":[{"id":501,"main":"Rain","description":"Orta şiddetli yağmur","icon":"10d"}],"speed":0.99,"deg":219,"clouds":18,"rain":10.13},{"dt":1441170000,"temp":{"day":294.65,"min":294.65,"max":294.65,"night":294.65,"eve":294.65,"morn":294.65},"pressure":925.18,"humidity":0,"weather":[{"id":501,"main":"Rain","description":"Orta şiddetli yağmur","icon":"10d"}],"speed":0.7,"deg":330,"clouds":67,"rain":5.5}]}';
    
        public function testSimple()
        {
            $daily = new Daily();
            
            $this->assertNotNull($daily);        
        }    
        
        public function testConstructer()
        {
            $stdObject = json_decode($this->daily);
            
            $daily = new Daily($stdObject);
            
            $this->assertNotNull($daily);            
        } 
        
        public function testGetWeatherData()
        {
            $stdObject = json_decode($this->daily);
            
            $array     = json_decode($this->daily , true);
            
            $daily = new Daily($stdObject);
            
            $data = $daily->getWeatherData();
            
            $this->assertInstanceOf('App\Libs\Weather\DataType\WeatherDaily', $data);
            
            $this->assertTrue($data->isFilledRequiredElements());
            
            $this->assertNotEmpty($data['list']->toArray());
            
            $this->assertCount(16, $data['list']->toArray());      
            
            $this->assertEquals($array['city']['id'], $data['city']['id']);            
            $this->assertEquals($array['list'][0]['dt'], $data['list'][0]['dt']);
            $this->assertEquals($array['list'][0]['temp']['day'], $data['list'][0]['weather_main']['temp']);
            $this->assertEquals($array['list'][0]['weather'][0]['main'], $data['list'][0]['weather_conditions'][0]['name']); 
            $this->assertEquals($array['list'][11]['rain'], $data['list'][11]['weather_rain']['3h']);               
            $this->assertEquals($array['list'][0]['rain'], $data['list'][0]['weather_rain']['3h']);     
       
        } 
        
        
        
        
        
}