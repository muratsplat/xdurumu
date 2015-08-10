<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\WeatherHourlyStat;


class WeatherHourlyStatTest extends TestCase
{
        use DatabaseMigrations, DatabaseTransactions;
     
        public function testSimpleCRUD()
        {
            
            $current = factory(App\WeatherHourlyStat::class, 2)
                        ->make()
                        ->each(function(\App\WeatherHourlyStat $cur){
                            
                            $cur->city()->associate(factory(\App\City::class)->create());
                        });
            
            $this->assertCount(2, $current);
        }
        
        /**
         * A basic functional test example.
         *
         * @return void
         */
        public function testSimple()
        {           
            $one = new WeatherHourlyStat();                     
        }


        public function testSimpleTwo() 
        {            
            /**
             * Todos:
             *    - Model factoring should rewrite again to using models in relation
             */
            $data =  [
                    'city_id'                       => factory(\App\City::class)->make(),                  
                    'weather_forecast_resource_id'  => factory(\App\WeatherForeCastResource::class)->make()->id,        
                    'enable'                        => (boolean) rand(0, 1),
                    'source_update_at'              => \Carbon\Carbon::createFromTimestampUTC(rand(1437814800, 1437914800))->format('Y-m-d H:m:s'),
                    'dt'                            => rand(1437814800, 1437914800),
            ];
            
            $one = $this->createNewWeatherHourlyStat($data); 
            
            $this->assertEquals($data['city_id'], $one['city_id']);
        
            $this->assertEquals($data['weather_forecast_resource_id'], $one['weather_forecast_resource_id']);
            $this->assertEquals($data['enable'], $one['enable']);  
            $this->assertEquals($data['source_update_at'], $one['source_update_at']);            
        }
        
        public function testWithFakerAttributes() 
        {            
                       
            $one = factory(App\WeatherHourlyStat::class)->make();      
        }
        
        public function testRelations() 
        {
            $one = $this->createNewWeatherHourlyStat();
            
            $this->assertInstanceOf('App\WeatherForeCastResource', $one->foreCastResource()->getRelated());        
            $this->assertInstanceOf('App\City', $one->city()->getRelated());   
            $this->assertInstanceOf('App\WeatherCondition', $one->conditions()->getRelated());  
            $this->assertInstanceOf('App\WeatherMain', $one->main()->getRelated());  
            $this->assertInstanceOf('App\WeatherWind', $one->wind()->getRelated());  
            $this->assertInstanceOf('App\WeatherCloud', $one->clouds()->getRelated());    

        }
        
        /**
         * 
         * @return \App\WeatherCurrent
         */
        protected function createNewWeatherHourlyStat(array $attributes=[])
        {            
            return factory(App\WeatherHourlyStat::class)->make($attributes);
        }  
        
       
        public function testFirstOrCreateForMain()
        {            
            $current = factory(App\WeatherHourlyStat::class, 2)
                        ->make()
                        ->each(function(\App\WeatherHourlyStat $cur){
                            
                            $cur->city()->associate(factory(\App\City::class)->create());
                        })->each(function(\App\WeatherHourlyStat $cur){
                            
                            $cur->save();
                        });                     
                        
           $first = $current->first();
           
           $main = factory(App\WeatherMain::class)->make();
                      
           $this->assertCount(0, App\WeatherMain::all());
           
           $mainCreated = $first->main()->firstOrCreate($main->toArray());     
           
           $this->assertTrue($mainCreated->save());
                
           $this->assertCount(1, App\WeatherMain::all());
           
           $this->assertEquals($first->id, $mainCreated->weather_hourly_id);
           
           $this->assertEquals($first->id, $first->main->weather_hourly_id);
           
           $this->assertNotNull($first->main);
           
           $this->assertCount(1, App\WeatherMain::all());       
           
           $mainCreated2 = $first->main()->firstOrCreate(array());              
           
           $this->assertTrue($mainCreated2->save($main->toArray()));
           
           $this->assertCount(1, App\WeatherMain::all());
           
        }
        
        
}