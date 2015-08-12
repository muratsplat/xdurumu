<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeatherSysTable extends Migration
{
    
    private $table = 'weather_sys';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       // sys: {"country":"JP","sunrise":1369769524,"sunset":1369821049}
        
       \Schema::create($this->table, function(Blueprint $t) {
           
           $t->increments('id');
           $t->integer('weather_current_id')->unsigned()->nullable();
           $t->string('country', 50)->nullable();
           $t->timestamp('sunrise')->nullable();
           $t->timestamp('sunset')->nullable();   
 
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
