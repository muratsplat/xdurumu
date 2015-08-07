<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWetherConditionAbles extends Migration
{
    /**
     * Table name
     */
    protected $table = 'weather_condition_ables';
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         *  Many To Many Polymorphic Relations
         * 
         *  tag_id - integer
         *  taggable_id - integer
         *  taggable_type - string
         */        
        \Schema::create($this->table, function(Blueprint $t) {
            
            $t->integer('weather_condition_id')->unsigned();
            $t->integer('weather_condition_able_id')->unsigned();
            $t->string('weather_condition_able_type');            
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
