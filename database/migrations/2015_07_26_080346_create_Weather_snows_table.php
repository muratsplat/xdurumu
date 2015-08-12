<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeatherSnowsTable extends Migration
{
    
    private $table = "weather_snows";
    
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
            $t->integer('snowable_id')->unsigned();
            $t->string('snowable_type');      
            $t->double('3h', 15,8)->unsigned()->nullable();
            $t->double('snow', 15,8)->unsigned()->nullable(); 
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
