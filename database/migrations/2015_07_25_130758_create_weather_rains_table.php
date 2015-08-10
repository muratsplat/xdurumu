<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeatherRainsTable extends Migration
{
    
    private $table = "weather_rains";
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // rain: {
        //        3h: 0.025
        //        }, 
        \Schema::create($this->table, function(Blueprint $t) {
            
            $t->increments('id');
            $t->integer('weather_current_id')->unsigned()->nullable();
            $t->integer('weather_hourly_id')->unsigned()->nullable();
            $t->integer('weather_daily_id')->unsigned()->nullable();
            $t->float('3h')->unsigned()->nullable();
            $t->float('rain')->unsigned()->nullable();
            
            $t->foreign('weather_current_id')->references('id')->on('weather_currents');             
            $t->foreign('weather_hourly_id')->references('id')->on('weather_hourly_stats');   
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
