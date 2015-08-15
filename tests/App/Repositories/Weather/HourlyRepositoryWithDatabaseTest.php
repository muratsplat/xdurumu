<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Repositories\Weather\HourlyStatRepository as Repository;
use App\Libs\Weather\OpenWeatherMap;
use App\City;
use App\Repositories\CityRepository;
use App\WeatherCurrent;
use App\WeatherCondition;
use App\WeatherHourlyStat;
use App\WeatherForeCastResource;
use Mockery as m;

/**
 * Current Repository Test Class
 * 
 * @package WeatherForcast
 */
class HourlyRepositoryWithDatabaseTest extends \TestCase
{
    use DatabaseMigrations, DatabaseTransactions;
    
    /**
     * Example of json response
     *
     * @var string JSON 
     */
    private $jsonExample ='{"city":{"id":524901,"name":"Moscow","coord":{"lon":37.615555,"lat":55.75222},"country":"RU","population":0,"sys":{"population":0}},"cod":"200","message":0.0097,"cnt":36,"list":[{"dt":1439467200,"main":{"temp":300.51,"temp_min":300.51,"temp_max":301.012,"pressure":1007.5,"sea_level":1026.76,"grnd_level":1007.5,"humidity":40,"temp_kf":-0.51},"weather":[{"id":500,"main":"Rain","description":"light rain","icon":"10d"}],"clouds":{"all":56},"wind":{"speed":4.82,"deg":224.503},"rain":{"3h":0.19},"sys":{"pod":"d"},"dt_txt":"2015-08-13 12:00:00"},{"dt":1439478000,"main":{"temp":300.87,"temp_min":300.87,"temp_max":301.25,"pressure":1005.32,"sea_level":1024.71,"grnd_level":1005.32,"humidity":41,"temp_kf":-0.38},"weather":[{"id":803,"main":"Clouds","description":"broken clouds","icon":"04d"}],"clouds":{"all":76},"wind":{"speed":5.21,"deg":249.004},"rain":{},"sys":{"pod":"d"},"dt_txt":"2015-08-13 15:00:00"},{"dt":1439488800,"main":{"temp":291.15,"temp_min":291.15,"temp_max":291.398,"pressure":1007.13,"sea_level":1026.55,"grnd_level":1007.13,"humidity":97,"temp_kf":-0.25},"weather":[{"id":501,"main":"Rain","description":"moderate rain","icon":"10n"}],"clouds":{"all":92},"wind":{"speed":5.11,"deg":326.502},"rain":{"3h":3.955},"sys":{"pod":"n"},"dt_txt":"2015-08-13 18:00:00"},{"dt":1439499600,"main":{"temp":289.67,"temp_min":289.67,"temp_max":289.793,"pressure":1008.42,"sea_level":1027.87,"grnd_level":1008.42,"humidity":92,"temp_kf":-0.13},"weather":[{"id":501,"main":"Rain","description":"moderate rain","icon":"10n"}],"clouds":{"all":24},"wind":{"speed":4.36,"deg":332.004},"rain":{"3h":3.235},"sys":{"pod":"n"},"dt_txt":"2015-08-13 21:00:00"},{"dt":1439510400,"main":{"temp":287.744,"temp_min":287.744,"temp_max":287.744,"pressure":1009.63,"sea_level":1029.38,"grnd_level":1009.63,"humidity":89,"temp_kf":0},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01n"}],"clouds":{"all":0},"wind":{"speed":3.76,"deg":340.5},"rain":{},"sys":{"pod":"n"},"dt_txt":"2015-08-14 00:00:00"},{"dt":1439521200,"main":{"temp":286.447,"temp_min":286.447,"temp_max":286.447,"pressure":1010.55,"sea_level":1030.4,"grnd_level":1010.55,"humidity":83,"temp_kf":0},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01d"}],"clouds":{"all":0},"wind":{"speed":3.22,"deg":338.501},"rain":{},"sys":{"pod":"d"},"dt_txt":"2015-08-14 03:00:00"},{"dt":1439532000,"main":{"temp":289.488,"temp_min":289.488,"temp_max":289.488,"pressure":1011.67,"sea_level":1031.39,"grnd_level":1011.67,"humidity":76,"temp_kf":0},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01d"}],"clouds":{"all":0},"wind":{"speed":3.52,"deg":331},"rain":{},"sys":{"pod":"d"},"dt_txt":"2015-08-14 06:00:00"},{"dt":1439542800,"main":{"temp":291.39,"temp_min":291.39,"temp_max":291.39,"pressure":1011.56,"sea_level":1031.01,"grnd_level":1011.56,"humidity":68,"temp_kf":0},"weather":[{"id":801,"main":"Clouds","description":"few clouds","icon":"02d"}],"clouds":{"all":20},"wind":{"speed":4.16,"deg":319.002},"rain":{},"sys":{"pod":"d"},"dt_txt":"2015-08-14 09:00:00"},{"dt":1439553600,"main":{"temp":292.183,"temp_min":292.183,"temp_max":292.183,"pressure":1011.24,"sea_level":1030.74,"grnd_level":1011.24,"humidity":60,"temp_kf":0},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01d"}],"clouds":{"all":0},"wind":{"speed":4.26,"deg":312.502},"rain":{},"sys":{"pod":"d"},"dt_txt":"2015-08-14 12:00:00"},{"dt":1439564400,"main":{"temp":292.146,"temp_min":292.146,"temp_max":292.146,"pressure":1010.5,"sea_level":1030.02,"grnd_level":1010.5,"humidity":54,"temp_kf":0},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01d"}],"clouds":{"all":0},"wind":{"speed":4,"deg":308.501},"rain":{},"sys":{"pod":"d"},"dt_txt":"2015-08-14 15:00:00"},{"dt":1439575200,"main":{"temp":288.625,"temp_min":288.625,"temp_max":288.625,"pressure":1010.21,"sea_level":1029.82,"grnd_level":1010.21,"humidity":57,"temp_kf":0},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01n"}],"clouds":{"all":0},"wind":{"speed":2.97,"deg":302},"rain":{},"sys":{"pod":"n"},"dt_txt":"2015-08-14 18:00:00"},{"dt":1439586000,"main":{"temp":286.075,"temp_min":286.075,"temp_max":286.075,"pressure":1009.67,"sea_level":1029.35,"grnd_level":1009.67,"humidity":64,"temp_kf":0},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01n"}],"clouds":{"all":0},"wind":{"speed":2.56,"deg":286.003},"rain":{},"sys":{"pod":"n"},"dt_txt":"2015-08-14 21:00:00"},{"dt":1439596800,"main":{"temp":284.399,"temp_min":284.399,"temp_max":284.399,"pressure":1009.08,"sea_level":1028.76,"grnd_level":1009.08,"humidity":71,"temp_kf":0},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01n"}],"clouds":{"all":0},"wind":{"speed":2.46,"deg":277.001},"rain":{},"sys":{"pod":"n"},"dt_txt":"2015-08-15 00:00:00"},{"dt":1439607600,"main":{"temp":284.67,"temp_min":284.67,"temp_max":284.67,"pressure":1008.26,"sea_level":1027.99,"grnd_level":1008.26,"humidity":70,"temp_kf":0},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01d"}],"clouds":{"all":0},"wind":{"speed":2.9,"deg":281.501},"rain":{},"sys":{"pod":"d"},"dt_txt":"2015-08-15 03:00:00"},{"dt":1439618400,"main":{"temp":290.303,"temp_min":290.303,"temp_max":290.303,"pressure":1007.38,"sea_level":1026.87,"grnd_level":1007.38,"humidity":64,"temp_kf":0},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"02d"}],"clouds":{"all":8},"wind":{"speed":2.97,"deg":292.003},"rain":{},"sys":{"pod":"d"},"dt_txt":"2015-08-15 06:00:00"},{"dt":1439629200,"main":{"temp":293.02,"temp_min":293.02,"temp_max":293.02,"pressure":1006.39,"sea_level":1025.61,"grnd_level":1006.39,"humidity":62,"temp_kf":0},"weather":[{"id":801,"main":"Clouds","description":"few clouds","icon":"02d"}],"clouds":{"all":24},"wind":{"speed":4.11,"deg":289.502},"rain":{},"sys":{"pod":"d"},"dt_txt":"2015-08-15 09:00:00"},{"dt":1439640000,"main":{"temp":293.598,"temp_min":293.598,"temp_max":293.598,"pressure":1005.3,"sea_level":1024.7,"grnd_level":1005.3,"humidity":56,"temp_kf":0},"weather":[{"id":803,"main":"Clouds","description":"broken clouds","icon":"04d"}],"clouds":{"all":80},"wind":{"speed":4.82,"deg":296.001},"rain":{},"sys":{"pod":"d"},"dt_txt":"2015-08-15 12:00:00"},{"dt":1439650800,"main":{"temp":292.99,"temp_min":292.99,"temp_max":292.99,"pressure":1004.93,"sea_level":1024.21,"grnd_level":1004.93,"humidity":56,"temp_kf":0},"weather":[{"id":803,"main":"Clouds","description":"broken clouds","icon":"04d"}],"clouds":{"all":76},"wind":{"speed":4.65,"deg":306.501},"rain":{},"sys":{"pod":"d"},"dt_txt":"2015-08-15 15:00:00"},{"dt":1439661600,"main":{"temp":290.91,"temp_min":290.91,"temp_max":290.91,"pressure":1004.81,"sea_level":1024.28,"grnd_level":1004.81,"humidity":56,"temp_kf":0},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"01n"}],"clouds":{"all":0},"wind":{"speed":3.22,"deg":307.504},"rain":{},"sys":{"pod":"n"},"dt_txt":"2015-08-15 18:00:00"},{"dt":1439672400,"main":{"temp":288.204,"temp_min":288.204,"temp_max":288.204,"pressure":1004.83,"sea_level":1024.44,"grnd_level":1004.83,"humidity":61,"temp_kf":0},"weather":[{"id":803,"main":"Clouds","description":"broken clouds","icon":"04n"}],"clouds":{"all":64},"wind":{"speed":2.46,"deg":319.506},"rain":{},"sys":{"pod":"n"},"dt_txt":"2015-08-15 21:00:00"},{"dt":1439683200,"main":{"temp":286.049,"temp_min":286.049,"temp_max":286.049,"pressure":1005.37,"sea_level":1025.07,"grnd_level":1005.37,"humidity":71,"temp_kf":0},"weather":[{"id":802,"main":"Clouds","description":"scattered clouds","icon":"03n"}],"clouds":{"all":36},"wind":{"speed":1.61,"deg":331.501},"rain":{},"sys":{"pod":"n"},"dt_txt":"2015-08-16 00:00:00"},{"dt":1439694000,"main":{"temp":285.572,"temp_min":285.572,"temp_max":285.572,"pressure":1006.27,"sea_level":1025.97,"grnd_level":1006.27,"humidity":74,"temp_kf":0},"weather":[{"id":803,"main":"Clouds","description":"broken clouds","icon":"04d"}],"clouds":{"all":64},"wind":{"speed":2.42,"deg":336.004},"rain":{},"sys":{"pod":"d"},"dt_txt":"2015-08-16 03:00:00"},{"dt":1439704800,"main":{"temp":289.658,"temp_min":289.658,"temp_max":289.658,"pressure":1006.95,"sea_level":1026.47,"grnd_level":1006.95,"humidity":63,"temp_kf":0},"weather":[{"id":802,"main":"Clouds","description":"scattered clouds","icon":"03d"}],"clouds":{"all":44},"wind":{"speed":2.13,"deg":347.501},"rain":{},"sys":{"pod":"d"},"dt_txt":"2015-08-16 06:00:00"},{"dt":1439715600,"main":{"temp":291.266,"temp_min":291.266,"temp_max":291.266,"pressure":1007.49,"sea_level":1026.97,"grnd_level":1007.49,"humidity":59,"temp_kf":0},"weather":[{"id":803,"main":"Clouds","description":"broken clouds","icon":"04d"}],"clouds":{"all":64},"wind":{"speed":3.26,"deg":335.5},"rain":{},"sys":{"pod":"d"},"dt_txt":"2015-08-16 09:00:00"},{"dt":1439726400,"main":{"temp":291.812,"temp_min":291.812,"temp_max":291.812,"pressure":1008.1,"sea_level":1027.57,"grnd_level":1008.1,"humidity":55,"temp_kf":0},"weather":[{"id":803,"main":"Clouds","description":"broken clouds","icon":"04d"}],"clouds":{"all":68},"wind":{"speed":2.87,"deg":346.5},"rain":{},"sys":{"pod":"d"},"dt_txt":"2015-08-16 12:00:00"},{"dt":1439737200,"main":{"temp":291.697,"temp_min":291.697,"temp_max":291.697,"pressure":1008.3,"sea_level":1027.77,"grnd_level":1008.3,"humidity":55,"temp_kf":0},"weather":[{"id":801,"main":"Clouds","description":"few clouds","icon":"02d"}],"clouds":{"all":24},"wind":{"speed":2.62,"deg":351.5},"rain":{},"sys":{"pod":"d"},"dt_txt":"2015-08-16 15:00:00"},{"dt":1439748000,"main":{"temp":289.484,"temp_min":289.484,"temp_max":289.484,"pressure":1009,"sea_level":1028.51,"grnd_level":1009,"humidity":60,"temp_kf":0},"weather":[{"id":803,"main":"Clouds","description":"broken clouds","icon":"04n"}],"clouds":{"all":56},"wind":{"speed":2.67,"deg":13.5008},"rain":{},"sys":{"pod":"n"},"dt_txt":"2015-08-16 18:00:00"},{"dt":1439758800,"main":{"temp":288.832,"temp_min":288.832,"temp_max":288.832,"pressure":1009.58,"sea_level":1029.31,"grnd_level":1009.58,"humidity":61,"temp_kf":0},"weather":[{"id":803,"main":"Clouds","description":"broken clouds","icon":"04n"}],"clouds":{"all":68},"wind":{"speed":2.32,"deg":36.5037},"rain":{},"sys":{"pod":"n"},"dt_txt":"2015-08-16 21:00:00"},{"dt":1439769600,"main":{"temp":285.671,"temp_min":285.671,"temp_max":285.671,"pressure":1010.2,"sea_level":1030.09,"grnd_level":1010.2,"humidity":75,"temp_kf":0},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"02n"}],"clouds":{"all":8},"wind":{"speed":2.13,"deg":23.0042},"rain":{},"sys":{"pod":"n"},"dt_txt":"2015-08-17 00:00:00"},{"dt":1439780400,"main":{"temp":284.06,"temp_min":284.06,"temp_max":284.06,"pressure":1010.48,"sea_level":1030.41,"grnd_level":1010.48,"humidity":90,"temp_kf":0},"weather":[{"id":800,"main":"Clear","description":"sky is clear","icon":"02d"}],"clouds":{"all":8},"wind":{"speed":2.36,"deg":17.5},"rain":{},"sys":{"pod":"d"},"dt_txt":"2015-08-17 03:00:00"},{"dt":1439791200,"main":{"temp":286.752,"temp_min":286.752,"temp_max":286.752,"pressure":1011.29,"sea_level":1031,"grnd_level":1011.29,"humidity":90,"temp_kf":0},"weather":[{"id":500,"main":"Rain","description":"light rain","icon":"10d"}],"clouds":{"all":92},"wind":{"speed":3.12,"deg":25.0003},"rain":{"3h":0.8575},"sys":{"pod":"d"},"dt_txt":"2015-08-17 06:00:00"},{"dt":1439802000,"main":{"temp":288.653,"temp_min":288.653,"temp_max":288.653,"pressure":1011.87,"sea_level":1031.46,"grnd_level":1011.87,"humidity":76,"temp_kf":0},"weather":[{"id":500,"main":"Rain","description":"light rain","icon":"10d"}],"clouds":{"all":0},"wind":{"speed":3.11,"deg":22.5006},"rain":{"3h":0.6875},"sys":{"pod":"d"},"dt_txt":"2015-08-17 09:00:00"},{"dt":1439812800,"main":{"temp":290.274,"temp_min":290.274,"temp_max":290.274,"pressure":1011.85,"sea_level":1031.42,"grnd_level":1011.85,"humidity":60,"temp_kf":0},"weather":[{"id":802,"main":"Clouds","description":"scattered clouds","icon":"03d"}],"clouds":{"all":48},"wind":{"speed":4.32,"deg":16.0007},"rain":{},"sys":{"pod":"d"},"dt_txt":"2015-08-17 12:00:00"},{"dt":1439823600,"main":{"temp":289.029,"temp_min":289.029,"temp_max":289.029,"pressure":1012.49,"sea_level":1032.13,"grnd_level":1012.49,"humidity":58,"temp_kf":0},"weather":[{"id":802,"main":"Clouds","description":"scattered clouds","icon":"03d"}],"clouds":{"all":48},"wind":{"speed":4.82,"deg":16.0001},"rain":{},"sys":{"pod":"d"},"dt_txt":"2015-08-17 15:00:00"},{"dt":1439834400,"main":{"temp":286.854,"temp_min":286.854,"temp_max":286.854,"pressure":1013.46,"sea_level":1033.32,"grnd_level":1013.46,"humidity":62,"temp_kf":0},"weather":[{"id":803,"main":"Clouds","description":"broken clouds","icon":"04n"}],"clouds":{"all":56},"wind":{"speed":4.52,"deg":19.0049},"rain":{},"sys":{"pod":"n"},"dt_txt":"2015-08-17 18:00:00"},{"dt":1439845200,"main":{"temp":285.619,"temp_min":285.619,"temp_max":285.619,"pressure":1013.94,"sea_level":1033.82,"grnd_level":1013.94,"humidity":68,"temp_kf":0},"weather":[{"id":803,"main":"Clouds","description":"broken clouds","icon":"04n"}],"clouds":{"all":64},"wind":{"speed":3.92,"deg":22.5011},"rain":{},"sys":{"pod":"n"},"dt_txt":"2015-08-17 21:00:00"}]}';
    
    
        public function setUp()
        {
            parent::setUp();               
            
           \Config::set('database.default', 'sqlite');  
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
         * 
         * @return \App\City
         */
        private function getCity()
        {
            return new City();
        }
        
        
        /**
         * To get accessor for hourly data
         * 
         * @return \App\Libs\Weather\OpenWeatherMap
         */
        private function getAccessorForHourlyData()
        {
            return (new OpenWeatherMap($this->jsonExample))->hourly();
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
         * @return \App\City
         */
        private function getCityRepo()
        {
            $app = app();
            
            $cache  = $app['cache']->driver();
            
            $config = $app['config'];
            
            return new CityRepository($cache, $config, new City());
        }

        /**
         * 
         * @return \App\WeatherHourlyStat
         */
        private function getHourlyStat()
        {
            return new WeatherHourlyStat();
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
            
            $cityRepo = $this->getCityRepo();            
                       
            $condition = $this->getCondition();
            
            $resource = $this->getResource();
            
            $hourly  = $this->getHourlyStat();        
            
            $config     = $this->getConfigInstance();
            
            $cache      = $this->getCacheInstance();
            
            $accessor   = $this->getAccessorForHourlyData();
            
            $one = new Repository($cache, $config, $cityRepo,$condition, $resource, $hourly);
            
            $one->selectCity($cities->random());
            
            $one->import($accessor);
          
        }   
}