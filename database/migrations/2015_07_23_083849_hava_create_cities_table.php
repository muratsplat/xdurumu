<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HavaCreateCitiesTable extends Migration
{
    
    private $table = 'cities';
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $t) {
            
            $t->increments('id');
            $t->string('name',150)->index();
            $t->integer('open_weather_map_id')->unsigned()->index()->unique();
            $t->string('country',10)->index();         
            $t->double('latitude', 15,8);
            $t->double('longitude',15,8);
            $t->tinyInteger('priority')->unsigned()->default(3);
            $t->tinyInteger('enable')->default(0);
            $t->string('slug', 200)->nullable()->unique()->index();
            $t->integer('sort_order')->unsigned()->default(0);
            
            // Eloquent Columns
            $t->timestamps();
            $t->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop($this->table);        
    }
}
