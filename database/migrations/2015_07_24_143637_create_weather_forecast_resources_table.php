<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeatherForecastResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weather_forecast_resources', function (Blueprint $t) {
            
            $t->increments('id');
            $t->string('name', 150)->unique();
            $t->mediumText('description')->nullable();
            $t->string('url', 250)->unique();
            $t->string('api_url', 150)->nullable()->unique();
            $t->boolean('apiable')->default(false);                   
            $t->tinyInteger('enable')->default(0);
            $t->tinyInteger('priority')->unsigned()->default(10);            
            $t->tinyInteger('paid')->default(0);
            $t->bigInteger('api_calls_count')->unsigned()->default(0);
            $t->timestamp('last_access_on')->nullable();   
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
        Schema::drop('weather_forecast_resources');
    }
}
