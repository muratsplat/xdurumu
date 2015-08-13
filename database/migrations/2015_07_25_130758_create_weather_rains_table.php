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
            
            $t->bigIncrements('id');
            $t->bigInteger('rainable_id')->unsigned();
            $t->string('rainable_type');           
            $t->float('3h')->unsigned()->nullable();
            $t->float('rain')->unsigned()->nullable();
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
