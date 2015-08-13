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
        \Schema::create($this->table, function(Blueprint $t){
            
            $t->bigIncrements('id');
            $t->bigInteger('windable_id')->unsigned();
            $t->string('windable_type');
            $t->float('speed')->unsigned()->nullable();
            $t->float('deg')->nullable();  

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
