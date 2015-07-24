<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call(UserTableSeeder::class);
        
        /**
         * Loading Cities
         */
        $this->call(SeedDefaultCities::class);    
        
        /**
         * Loading Weather Forecast Resources
         */
        $this->call(SeedsWeaterForeCastResources::class);
        
        Model::reguard();
    }
}
