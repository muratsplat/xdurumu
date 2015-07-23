<?php

use Illuminate\Database\Seeder;
use App\City;

class SeedDefaultCities extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = app_path('../resources/defaults/city.list.json');
            
            $file = file($path);
            
            foreach ($file as $line) {
                
               $cityJson = json_decode($line);  
               
               // If the city is not in Turkey, pass it..
               if($cityJson->country !=='TR') {  continue; }
                
                $city   = new City();                                           
                $city->name         = $cityJson->name;
                $city->country      = $cityJson->country;           
                $city->latitude     = $cityJson->coord->lat;
                $city->longitude    = $cityJson->coord->lon;        
                $city->open_weather_map_id = $cityJson->_id;                
                $city->save();               
            }
            
            $addedCities    = City::all();
            
            $msg            = (string) $addedCities->count() . ' number cities where in Turkey was seeded on current DB !';          
            
            $this->command->info($msg);
    }
}
