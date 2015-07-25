<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeatherWindsTable extends Migration
{
    
    private $table = "weather_winds";
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // "wind":{"speed":7.31,"deg":187.002},
        
        \Schema::create($this->table, function(Blueprint $t){
            
            $t->increments('id');
            $t->integer('weather_current_id')->unsigned()->nullable();
            $t->integer('weather_hourly_id')->unsigned()->nullable();
            $t->float('speed')->unsigned();
            $t->double('deg', 15, 8);           
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
