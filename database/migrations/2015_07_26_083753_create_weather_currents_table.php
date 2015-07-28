<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeatherCurrentsTable extends Migration
{
    
    private $table = 'weather_currents';
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        //        {"coord":{"lon":139,"lat":35},
        //	"sys":{"country":"JP","sunrise":1369769524,"sunset":1369821049},
        //	"weather":[{"id":804,"main":"clouds","description":"overcast clouds","icon":"04n"}], // ok
        //	"main":{
        //			"temp":289.5,
        //			"humidity":89,
        //			"pressure":1013,
        //			"temp_min":287.04,
        //			"temp_max":292.04
        //			},
        //	"wind":{"speed":7.31,"deg":187.002}, // ok
        //	"rain":{"3h":0},
        //	"clouds":{"all":92},
        //	"dt":1369824698,
        //	"id":1851632,
        //	"name":"Shuzenji",
        //	"cod":200
        //   
        
        \Schema::create($this->table, function(Blueprint $t) {
            
            $t->increments('id');
            $t->integer('city_id')->unsigned();
            $t->integer('weather_condition_id')->unsigned();     
            $t->integer('weather_forecast_resource_id')->unsigned()->nullable();
            $t->integer('weather_main_id')->unsigned();    
            $t->integer('weather_wind_id')->unsigned()->nullable();  
            $t->integer('weather_rain_id')->unsigned()->nullable();  
            $t->integer('weather_snow_id')->unsigned()->nullable(); 
            $t->integer('weather_cloud_id')->unsigned()->nullable(); 
            $t->boolean('enable')->default(true);
            $t->timestamp('source_updated_at');
            $t->timestamps();             
            
            $t->foreign('weather_condition_id')->references('id')->on('weather_conditions');            
            $t->foreign('city_id')->references('id')->on('cities');             
            $t->foreign('weather_forecast_resource_id')->references('id')->on('weather_forecast_resources');   
            $t->foreign('weather_main_id')->references('id')->on('weather_mains');   
            $t->foreign('weather_wind_id')->references('id')->on('weather_winds');   
            $t->foreign('weather_rain_id')->references('id')->on('weather_rains'); 
            $t->foreign('weather_snow_id')->references('id')->on('weather_snows'); 
            $t->foreign('weather_cloud_id')->references('id')->on('weather_clouds'); 
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {                
        \Schema::drop($this->table);
    }
}
