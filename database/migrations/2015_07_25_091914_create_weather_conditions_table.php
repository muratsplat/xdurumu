<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeatherConditionsTable extends Migration
{
    
    /**
     * Note: This file creates 'weather_conditions' table ! 
     *       It is Not 'weather_names' !
     *
     * @var string 
     */    
    private $table = 'weather_conditions';
      
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create($this->table, function(Blueprint $t) {
            
            $t->increments('id');
            $t->integer('open_weather_map_id')->unsigned()->nullable();            
            $t->string('name', 50)->nullable();
            $t->string('orgin_name', 50);
            $t->string('description', 200)->nullable();           
            $t->string('orgin_description', 200);
            $t->string('icon', 50)->nullable(); 
            $t->boolean('enable')->default(true);
            $t->string('slug', 200)->nullable()->unique()->index();
            $t->integer('sort_order')->unsigned()->default(0);            
            $t->softDeletes();                       
            $t->timestamps();
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
