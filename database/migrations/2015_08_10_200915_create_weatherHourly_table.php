<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeatherHourlyTable extends Migration
{
    protected $table = "weather_hourly_stats";
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
//        {"city":{"id":1851632,"name":"Shuzenji",
//        "coord":{"lon":138.933334,"lat":34.966671},
//        "country":"JP",
//        "cod":"200",
//        "message":0.0045,
//        "cnt":38,
//        "list":[{
//                "dt":1406106000,
//                "main":{
//                    "temp":298.77,
//                    "temp_min":298.77,
//                    "temp_max":298.774,
//                    "pressure":1005.93,
//                    "sea_level":1018.18,
//                    "grnd_level":1005.93,
//                    "humidity":87
//                    "temp_kf":0.26},
//                "weather":[{"id":804,"main":"Clouds","description":"overcast clouds","icon":"04d"}],
//                "clouds":{"all":88},
//                "wind":{"speed":5.71,"deg":229.501},
//                "sys":{"pod":"d"},
//                "dt_txt":"2014-07-23 09:00:00"}
//                ]}
        
        \Schema::create($this->table, function(Blueprint $t) {
            
            $t->increments('id');
            $t->unsignedInteger('city_id');        
            $t->unsignedInteger('weather_forecast_resource_id')->nullable(); 
            $t->timestamps();             
         
            $t->foreign('city_id')->references('id')->on('cities');             
            $t->foreign('weather_forecast_resource_id')->references('id')->on('weather_forecast_resources');               
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
