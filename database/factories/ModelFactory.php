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
        
//            $t->increments('id');
//            $t->string('name', 150);
//            $t->mediumText('description')->nullable();
//            $t->string('url', 250);
//            $t->string('api_url', 150)->nullable();
//            $t->boolen('apiable')->default(false);                   
//            $t->tinyInteger('enable')->default(0);
//            $t->tinyInteger('paid')->default(0);
//            $t->mediumInteger('api_calls_count')->unsigned()->default(0);
//            $t->timestamp('last_access_on')->nullable();   
//            $t->softDeletes();            
//            $t->timestamps();

$factory->define(App\WeatherForeCastResource::class, function (Faker\Generator $faker) {
    return [
        'name'                  => $faker->name,
        'description'           => $faker->paragraph,
        'url'                   => $faker->url,
        'api_url'               => $faker->url,
        'apiable'               => true,
        'last_access_on'        => $faker->date($format = 'Y-m-d H:m:s', $max = 'now'),
        'enable'                => 1,
        'paid'                  => 0,
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
        'enable'                => 1,        
        'icon'                  => str_random(4),        
        'open_weather_map_id'   => rand(1, 5),          
        'deleted_at'            => null,
        'created_at'            => $faker->date($format = 'Y-m-d H:m:s', $max = 'now'),
        'updated_at'            => $faker->date($format = 'Y-m-d H:m:s', $max = 'now'),     
    ];
});
        