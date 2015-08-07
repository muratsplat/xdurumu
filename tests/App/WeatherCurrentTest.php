<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\WeatherCurrent;


class WeatherCurrentTest extends TestCase
{
        use DatabaseMigrations, DatabaseTransactions;
     
        public function testSimpleCRUD()
        {
            
            $current = factory(App\WeatherCurrent::class, 2)
                        ->make()
                        ->each(function(\App\WeatherCurrent $cur){
                            
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
            $one = new WeatherCurrent();                     
        }


        public function testSimpleTwo() 
        {            
            /**
             * Todos:
             *    - Model factoring should rewrite again to using models in relation
             */
            $data =  [
                    'city_id'                       => factory(\App\City::class)->make(),
                    'weather_conditions_id'         => factory(\App\WeatherCondition::class)->make(),
                    'weather_forecast_resource_id'  => factory(\App\WeatherForeCastResource::class)->make()->id,        
                    'enable'                        => (boolean) rand(0, 1),
                    'source_update_at'              => \Carbon\Carbon::createFromTimestampUTC(rand(1437814800, 1437914800))->format('Y-m-d H:m:s'),
            ];
            
            $one = $this->createNewWeatherCurrent($data); 
            
            $this->assertEquals($data['city_id'], $one['city_id']);
            $this->assertEquals($data['weather_conditions_id'], $one['weather_conditions_id']);
            $this->assertEquals($data['weather_forecast_resource_id'], $one['weather_forecast_resource_id']);
            $this->assertEquals($data['enable'], $one['enable']);  
            $this->assertEquals($data['source_update_at'], $one['source_update_at']);            
        }
        
        public function testWithFakerAttributes() 
        {            
                       
            $one = factory(App\WeatherCurrent::class)->make();      
        }
        
        public function testRelations() 
        {
            $one = $this->createNewWeatherCurrent();
            
            $this->assertInstanceOf('App\WeatherForeCastResource', $one->foreCastResource()->getRelated());        
            $this->assertInstanceOf('App\City', $one->city()->getRelated());   
            $this->assertInstanceOf('App\WeatherCondition', $one->conditions()->getRelated());  
            $this->assertInstanceOf('App\WeatherMain', $one->main()->getRelated());  
            $this->assertInstanceOf('App\WeatherWind', $one->wind()->getRelated());  
            $this->assertInstanceOf('App\WeatherRain', $one->rain()->getRelated());    
            $this->assertInstanceOf('App\WeatherCloud', $one->clouds()->getRelated());    
            $this->assertInstanceOf('App\WeatherSnow', $one->snow()->getRelated());  
            $this->assertInstanceOf('App\WeatherSys', $one->sys()->getRelated());  
        }
        
        /**
         * 
         * @return \App\WeatherCurrent
         */
        protected function createNewWeatherCurrent(array $attributes=[])
        {            
            return factory(App\WeatherCurrent::class)->make($attributes);
        }  
        
        
        public function testFirstOrCreateForSys()
        {            
            $current = factory(App\WeatherCurrent::class, 2)
                        ->make()
                        ->each(function(\App\WeatherCurrent $cur){
                            
                            $cur->city()->associate(factory(\App\City::class)->create());
                        })->each(function(\App\WeatherCurrent $cur){
                            
                            $cur->save();
                        });                     
                        
           $first = $current->first();
           
           $sys = factory(App\WeatherSys::class)->make();
           
           $sysCreated = $first->sys()->firstOrCreate($sys->toArray());
           
           $this->assertTrue($sysCreated->save());
           
           $this->assertEquals($first->id, $sysCreated->weather_current_id);
           
           $this->assertEquals($first->id, $first->sys->weather_current_id);
           
           $this->assertNotNull($first->sys);
           
           $sysCreated2 = $first->sys()->firstOrNew(array());
           
           $sys['country']= 'foo bar';
           
           $this->assertTrue($sysCreated2->update($sys->toArray()));
                    
           $this->assertCount(1, App\WeatherSys::all());
           
           $this->assertEquals($sys['country'], $sysCreated2->country);
           
        }
        
        public function testFirstOrCreateForMain()
        {            
            $current = factory(App\WeatherCurrent::class, 2)
                        ->make()
                        ->each(function(\App\WeatherCurrent $cur){
                            
                            $cur->city()->associate(factory(\App\City::class)->create());
                        })->each(function(\App\WeatherCurrent $cur){
                            
                            $cur->save();
                        });                     
                        
           $first = $current->first();
           
           $main = factory(App\WeatherMain::class)->make();
                      
           $this->assertCount(0, App\WeatherMain::all());
           
           $mainCreated = $first->main()->firstOrCreate($main->toArray());     
           
           $this->assertTrue($mainCreated->save());
                
           $this->assertCount(1, App\WeatherMain::all());
           
           $this->assertEquals($first->id, $mainCreated->weather_current_id);
           
           $this->assertEquals($first->id, $first->main->weather_current_id);
           
           $this->assertNotNull($first->main);
           
           $this->assertCount(1, App\WeatherMain::all());       
           
           $mainCreated2 = $first->main()->firstOrCreate(array());              
           
           $this->assertTrue($mainCreated2->save($main->toArray()));
           
           $this->assertCount(1, App\WeatherMain::all());
           
        }
        
        
}