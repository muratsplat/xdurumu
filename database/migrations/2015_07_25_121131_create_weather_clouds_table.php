<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeatherCloudsTable extends Migration
{
    
    private $table = 'weather_clouds';
    
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {       
        // "clouds":{"all":92}        
        \Schema::create($this->table, function(Blueprint $t) {
            
            $t->bigIncrements('id');            
            $t->bigInteger('cloudsable_id')->unsigned();
            $t->string('cloudsable_type');            
            $t->integer('all')->unsigned()->nullable();                                
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
