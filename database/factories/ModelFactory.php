<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function ($faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => str_random(10),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\City::class, function (Faker\Generator $faker) {
    return [
        
        'name'                  => $faker->name,
        'country'               => $faker->country,
        'latitude'              => $faker->latitude,
        'longitude'             => $faker->longitude,
        'open_weather_map_id'   => rand(1, 200000),       
    ];
});

//            WeatherForeCastResource  Migration
        
//        $t->increments('id');
//        $t->string('name', 150)->unique();
//        $t->mediumText('description')->nullable();
//        $t->string('url', 250)->unique();
//        $t->string('api_url', 150)->nullable()->unique();
//        $t->boolean('apiable')->default(false);                   
//        $t->tinyInteger('enable')->default(0);
//        $t->tinyInteger('priority')->unsigned()->default(10);            
//        $t->tinyInteger('paid')->default(0);
//        $t->bigInteger('api_calls_count')->unsigned()->default(0);
//        $t->timestamp('last_access_on')->nullable();   
//        $t->softDeletes();            
//        $t->timestamps();
$factory->define(App\WeatherForeCastResource::class, function (Faker\Generator $faker) {
    return [
        'name'                  => $faker->name,
        'description'           => $faker->paragraph,
        'url'                   => $faker->unique()->url,
        'api_url'               => $faker->unique()->url,
        'apiable'               => true,
        'last_access_on'        => $faker->date($format = 'Y-m-d H:m:s', $max = 'now'),
        'enable'                => 1,
        'paid'                  => 0,
        'priority'              => rand(0, 10),
        'api_calls_count'       => rand(100, 999999),
        'deleted_at'            => null,
        'created_at'            => $faker->date($format = 'Y-m-d H:m:s', $max = 'now'),
        'updated_at'            => $faker->date($format = 'Y-m-d H:m:s', $max = 'now'),     
    ];
});

//       The Migration  For App\WeatherCondition
//       
//        $t->increments('id');
//        $t->integer('open_weather_map_id')->unsigned()->nullable();            
//        $t->string('name', 50);
//        $t->string('description', 150);
//        $t->string('icon', 50)->nullable(); 
//        $t->boolean('enable')->default(true);
//        $t->string('slug', 200)->nullable()->unique()->index();
//        $t->integer('sort_order')->unsigned()->default(0);            
//        $t->softDeletes();                       
//        $t->timestamps();
$factory->define(App\WeatherCondition::class, function (Faker\Generator $faker) {
    return [
        'name'                  => $faker->name,
        'description'           => $faker->paragraph,   
        'orgin_name'            => $faker->name,
        'orgin_description'     => $faker->paragraph,   
        'enable'                => 1,        
        'icon'                  => str_random(4),        
        'open_weather_map_id'   => rand(1, 5),          
        'deleted_at'            => null,
        'created_at'            => $faker->date($format = 'Y-m-d H:m:s', $max = 'now'),
        'updated_at'            => $faker->date($format = 'Y-m-d H:m:s', $max = 'now'),     
    ];
});

//    $t->increments('id');
//    $t->integer('weather_current_id')->unsigned()->nullable();
//    $t->integer('weather_hourly_id')->unsigned()->nullable();
//    $t->integer('weather_daily_id')->unsigned()->nullable();
//    $t->integer('all');
$factory->define(App\WeatherCloud::class, function (Faker\Generator $faker) {
    return [
        
        'weather_current_id'    => null,
        'weather_hourly_id'     => null,   
        'weather_daily_id'      => null,        
        'all'                   => rand(1, 100),             
    ];
});

//    $t->increments('id');
//    $t->integer('weather_current_id')->unsigned()->nullable();
//    $t->integer('weather_hourly_id')->unsigned()->nullable();
//    $t->float('speed')->unsigned();
//    $t->double('deg', 15, 8);       
$factory->define(App\WeatherWind::class, function (Faker\Generator $faker) {
    return [
        
        'weather_current_id'    => null,
        'weather_hourly_id'     => null,           
        'speed'                 => 7.31,
        'deg'                   => 187.002,        
    ];
});

//    $t->increments('id');
//    $t->integer('weather_current_id')->unsigned()->nullable();
//    $t->integer('weather_hourly_id')->unsigned()->nullable();
//    $t->integer('weather_daily_id')->unsigned()->nullable();
//    $t->double('3h', 15,8)->unsigned()->nullable();
//    $t->double('rain', 15,8)->unsigned()->nullable();
$factory->define(App\WeatherRain::class, function (Faker\Generator $faker) {
    return [
        
        'weather_current_id'    => null,
        'weather_hourly_id'     => null,   
        'weather_daily_id'      => null,             
        '3h'                    => 2.225,
        'rain'                  => 187.002,        
    ];
});

//    $t->increments('id');
//    $t->integer('weather_current_id')->unsigned()->nullable();
//    $t->integer('weather_hourly_id')->unsigned()->nullable();
//    $t->integer('weather_daily_id')->unsigned()->nullable();
//    $t->double('temp', 15,8);
//    $t->double('temp_min', 15,8)->nullable();
//    $t->double('temp_max', 15,8)->nullable();
//    $t->double('temp_eve', 15,8)->nullable();
//    $t->double('temp_night', 15,8)->nullable();
//    $t->double('temp_morn', 15,8)->nullable(); 
//    $t->double('pressure', 15,8)->unsigned()->nullable();
//    $t->integer('humidity')->unsigned()->nullable();
//    $t->double('sea_level', 15,8)->nullable();
//    $t->double('grnd_level', 15,8)->nullable();
//    $t->float('temp_kf')->nullable();   
$factory->define(App\WeatherMain::class, function (Faker\Generator $faker) {
    return [
        
        
        'weather_current_id'    => null,
        'weather_hourly_id'     => null,   
        'weather_daily_id'      => null,             
        'temp'                  => (double) rand(-30, 60) * 0.21,        
        'temp_min'              => (double) rand(-30, 60) * 0.65,             
        'temp_max'              => (double) rand(-30, 60) * 0.65, 
        'temp_eve'              => (double) rand(-30, 60) * 0.65, 
        'temp_night'            => (double) rand(-30, 60) * 0.65, 
        'temp_morn'             => (double) rand(-30, 60) * 0.65, 
        'pressure'              => rand(500,1000),        
        'humidity'              => rand(1,99),
        'sea_level'             => (double) rand(500,1200) * 0.84,        
        'grnd_level'            => (double) rand(500,1200) * 0.84,
        'temp_kf'               => (double) rand(2,67),     
    ];
});

//    $t->increments('id');
//    $t->integer('weather_current_id')->unsigned()->nullable();
//    $t->string('country', 50)->nullable();
//    $t->time('sunrise');
//    $t->time('sunset');  

$factory->define(App\WeatherSys::class, function (Faker\Generator $faker) {
    return [
        'weather_current_id'    => null,
        'country'               => $faker->city,
        'sunrise'               => $faker->unixTime,
        'sunset'                => $faker->unixTime,
    ];
});

//    $t->increments('id');
//    $t->integer('weather_current_id')->unsigned()->nullable();
//    $t->integer('weather_hourly_id')->unsigned()->nullable();      
//    $t->double('3h', 15,8)->unsigned()->nullable();
//    $t->double('snow', 15,8)->unsigned()->nullable();
$factory->define(App\WeatherSnow::class, function (Faker\Generator $faker) {
    return [
        'weather_current_id'    => null,
        'weather_hourly_id'     => null,         
        '3h'                    => 2.225,
        'snow'                  => 187.002,    
    ];
});

//    $t->increments('id');
//    $t->integer('city_id')->unsigned();
//    $t->integer('weather_conditions_id')->unsigned();     
//    $t->integer('weather_forecast_resource_id')->unsigned()->nullable();
//      $t->integer('weather_main_id')->unsigned();    
//    $t->integer('weather_wind_id')->unsigned()->nullable();  
//    $t->integer('weather_rain_id')->unsigned()->nullable();  
//    $t->integer('weather_snow_id')->unsigned()->nullable(); 
//    $t->integer('weather_cloud_id')->unsigned()->nullable(); 
//    $t->boolean('enable')->default(true);
//    $t->timestamp('source_updated_at');
//    $t->timestamps();             
//
//    $t->foreign('weather_conditions_id')->references('id')->on('weather_conditions');            
//    $t->foreign('city_id')->references('id')->on('cities');             
//    $t->foreign('weather_forecast_resource_id')->references('id')->on('weather_forecast_resources');   
$factory->define(App\WeatherCurrent::class, function (Faker\Generator $faker) {
    
    $now        = \Carbon\Carbon::now();
    $created_at = $now->format('Y-m-d H:m:s');
    $updated_at = $now->addHour(1)->format('Y-m-d H:m:s');
    
    return [
        'city_id'                       => null,
        'weather_condition_id'          => null,
        'weather_forecast_resource_id'  => null,
        'weather_main_id'               => null,   
        'weather_wind_id'               => null,
        'weather_rain_id'               => null,
        'weather_snow_id'               => null,
        'weather_cloud_id'              => null,
        'enable'                        => (boolean) rand(0, 1),
        'source_updated_at'              => \Carbon\Carbon::createFromTimestampUTC(rand(1437814800, 1437914800))->format('Y-m-d H:m:s'),
        'created_at'                    => $created_at,
        'updated_at'                    => $updated_at,       
    ];
});
        