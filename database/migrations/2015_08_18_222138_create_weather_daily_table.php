<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeatherDailyTable extends Migration
{
    
    protected $table = "weather_daily_stats";
        
        
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
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
