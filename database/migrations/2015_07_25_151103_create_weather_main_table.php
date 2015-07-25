<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeatherMainTable extends Migration
{
    
    private $table = 'weather_main';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //    "temp":294.99,
        //    "temp_min":293.465,
        //    "temp_max":294.99,
        //    "temp_night":11.12,
        //    "temp_eve":16.39,
        //    "temp_morn":13
        //    "pressure":1009.98,
        //    "humidity":82,
        //    "sea_level":1029.41,
        //    "grnd_level":1009.98,
        //    "temp_kf":1.53

        \Schema::create($this->table, function(Blueprint $t){
            
            $t->increments('id');
            $t->integer('weather_current_id')->unsigned()->nullable();
            $t->integer('weather_hourly_id')->unsigned()->nullable();
            $t->integer('weather_daily_id')->unsigned()->nullable();
            $t->double('temp', 15,8);
            $t->double('temp_min', 15,8)->nullable();
            $t->double('temp_max', 15,8)->nullable();
            $t->double('temp_eve', 15,8)->nullable();
            $t->double('temp_night', 15,8)->nullable();
            $t->double('temp_morn', 15,8)->nullable(); 
            $t->double('pressure', 15,8)->unsigned()->nullable();
            $t->integer('humidity')->unsigned()->nullable();
            $t->double('sea_level', 15,8)->nullable();
            $t->double('grnd_level', 15,8)->nullable();
            $t->float('temp_kf')->nullable();                               
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
