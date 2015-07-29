<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use App\Repositories\CityRepository as City;
use App\Jobs\UpdateWeatherCurrent;

/**
 * This command make update to weather forecast current data of all cities
 *  
 */
class UpdateWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:current';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To update currently weather forcast data of each all cities from API Service';
    
    /**
     * 
     * @var App\Repositories\CityRepository
     */
    private $cityRepo;

        /**
         * Create a new command instance.
         *
         * @return void
         */
        public function __construct(City $city)
        {
            parent::__construct();
            
            $this->cityRepo = $city;
            
        }

        /**
         * Execute the console command.
         *
         * @return mixed
         */
        public function handle()
        {
            foreach ($this->cityRepo->enable()->all() as $city) {              
                 
                $job    = new UpdateWeatherCurrent($city);

                \Queue::push($job);               
            }          
        }
}
