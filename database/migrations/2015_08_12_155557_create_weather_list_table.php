<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeatherListTable extends Migration
{
    
    
    private $table = 'weather_lists';
    
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create($this->table, function(Blueprint $t) {
            
            $t->bigIncrements('id');              
            $t->bigInteger('listable_id')->unsigned();
            $t->string('listable_type');
            $t->boolean('enable')->default(true);
            $t->timestamp('source_updated_at')->nullable();           
            $t->integer('dt')->nullable();                       
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
