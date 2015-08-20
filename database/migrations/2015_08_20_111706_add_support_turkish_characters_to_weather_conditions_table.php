<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSupportTurkishCharactersToWeatherConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // SQLITE doesnt support changing collation
            if(App::environment() === 'testing') { return; } 
             
            // changing collation of tables for best matching turkish charecters
            // Notes: 
            //  http://forum.laravel.gen.tr/viewtopic.php?id=1332 , 
            //  http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            //  http://stackoverflow.com/questions/5906585/how-to-change-the-default-collation-of-a-database
            //
            DB::statement('ALTER TABLE `weather_conditions` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // SQLITE doesnt support changing collation
        if(App::environment() === 'testing') { return; } 

        DB::statement('ALTER TABLE `weather_conditions` CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci');
    }
}
