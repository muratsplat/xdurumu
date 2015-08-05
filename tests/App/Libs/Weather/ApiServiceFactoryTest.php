<?php


use App\Libs\Weather\ApiServiceFactory as ApiFactory;

use Mockery as m;

/**
 * Test file for App\Libs\Weather\OpenWeatherMap class
 * 
 */
class ApiServiceFactoryTest extends \TestCase
{  
    
        public function setUp()
        {
            parent::setUp();           
        }
        
        public function tearDown()
        {
            parent::tearDown();            
            m::close();
        } 
    
        public function testSimple()
        {
           $api = app('app.weather.factory');
            
           $this->assertInstanceOf('App\Libs\Weather\ApiServiceFactory', $api);     
        }
        
        /** 
         * @return \App\Libs\Weather\ApiServiceFactory
         */
        private function getAppWeatherFactory()
        {
            return app('app.weather.factory');
        }
        
        /**
         * 
         * @return \Mockery\MockInterface
         */
        private function getMockedRepository()
        {
            return m::mock('App\Contracts\Weather\Repository\IForecastResourceRepository');
        }
        
        /**
         * 
         * @return \Mockery\MockInterface
         */
        private function getMockedLog()
        {
            return m::mock('Illuminate\Contracts\Logging\Log');
        }       
        
        
        public function testSimpleDefaultAccessor()
        {
            $app = app();
            
            $repository = $this->getMockedRepository();
            
            $weatherForCastResourceCollection = factory(\App\WeatherForeCastResource::class, 4)->make();
            
            $repository->shouldReceive('enableCache')->andReturnSelf();
            $repository->shouldReceive('all')->andReturn($weatherForCastResourceCollection);
            
            
            $app['App\Contracts\Weather\Repository\IForecastResourceRepository'] = $repository;
            
            $factory = $this->getAppWeatherFactory();
            try {
               
                $client = $factory->defaultClient();
                
            } catch (InvalidArgumentException  $ex) {
                
                $repository->shouldHaveReceived('enableCache')->times(1);
                $repository->shouldHaveReceived('all')->times(1);              
            }
          
        }
        
        public function testDefaultAccessor()
        {
            $app = app();
            
            $repository = $this->getMockedRepository();
            
            $weatherForCastResourceCollection = factory(\App\WeatherForeCastResource::class, 4)->make();
            
            $weatherForCastResourceCollection->first()->name = "openweathermap";
            $weatherForCastResourceCollection->first()->enable = true;
            $weatherForCastResourceCollection->first()->priority = 0;        
            
            $repository->shouldReceive('enableCache')->andReturnSelf();
            $repository->shouldReceive('all')->andReturn($weatherForCastResourceCollection);
            
            
            $app['App\Contracts\Weather\Repository\IForecastResourceRepository'] = $repository;
            
            $factory = $this->getAppWeatherFactory();
            try {
               
                $client = $factory->defaultClient();
                
            } catch (InvalidArgumentException  $ex) {
              
                $this->assertTrue(False);
            }
            
            $repository->shouldHaveReceived('enableCache')->times(1);
            $repository->shouldHaveReceived('all')->times(1);            
            
            $this->assertInstanceOf('App\Libs\Weather\OpenWeatherMapClient', $client); 
            $this->assertInstanceOf('\App\Contracts\Weather\ApiClient', $client); 
            
        }
        
        public function testNextClient()
        {
            $app = app();
            
            $repository = $this->getMockedRepository();
            
            $weatherForCastResourceCollection = factory(\App\WeatherForeCastResource::class, 4)->make();
            
            $weatherForCastResourceCollection->first()->name = "openweathermap";
            $weatherForCastResourceCollection->first()->enable = true;
            $weatherForCastResourceCollection->first()->priority = 0;            
            
            $repository->shouldReceive('enableCache')->andReturnSelf();            
            $repository->shouldReceive('all')->andReturn($weatherForCastResourceCollection);            
            
            $log    = $this->getMockedLog();
            
            $log->shouldReceive('alert')->andReturnSelf();           
            
            $app['App\Contracts\Weather\Repository\IForecastResourceRepository'] = $repository;
            
            //$app['log'] = $log;
            
            $factory = $this->getAppWeatherFactory();
            try {
               
                $client   = $factory->defaultClient();
                
                $nextAccesor= $factory->nextClient();
                
            } catch (Exception  $ex) {           
              
                $this->assertTrue(False, $ex->getMessage());       
            }           
            
            $repository->shouldHaveReceived('enableCache')->times(2);
            $repository->shouldHaveReceived('all')->times(3); 
            
            $this->assertInstanceOf('App\Libs\Weather\OpenWeatherMapClient', $nextAccesor);          
        }
        
        
        public function testCallDynamicallyMethods()
        {
            $app = app();
            
            $repository = $this->getMockedRepository();
            
            $weatherForCastResourceCollection = factory(\App\WeatherForeCastResource::class, 4)->make();
            
            $weatherForCastResourceCollection->first()->name = "openweathermap";
            $weatherForCastResourceCollection->first()->enable = true;
            $weatherForCastResourceCollection->first()->priority = 0;            
            
            $repository->shouldReceive('enableCache')->andReturnSelf();            
            $repository->shouldReceive('all')->andReturn($weatherForCastResourceCollection);           
            
            $app['App\Contracts\Weather\Repository\IForecastResourceRepository'] = $repository;
      
            $factory = $this->getAppWeatherFactory();
            
            $this->assertInstanceOf('App\Contracts\Weather\Accessor', $factory->getAccessor());
                  
        }
        
        
      
}