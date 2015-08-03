<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use App\Repositories\CityRepository as CityRepo;
use App\Jobs\Weather\UpdateCurrent;

/**
 * This command make update to weather forecast current data of all cities
 *  
 */
class WeatherUpdateCurrent extends Command
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
     * @var \App\Repositories\CityRepository
     */
    private $cityRepo;    

        /**
         * Create a new command instance.
         *
         * @return void
         */
        public function __construct(CityRepo $city)
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
            $repo = $this->getCurrentRepo();
            
            $no   = 0;
            
            foreach ($this->getAllCities() as $city) {              
                
                $no++;
                
                $job    = new UpdateCurrent($city, $repo);

                \Queue::push($job);               
            }
            
            $this->info(PHP_EOL . "$no number of city update request job is queued." . PHP_EOL );
        }
        
        /**
         * To get Weather Current Repository
         * 
         * @return \App\Repositories\CityRepository
         */
        protected function getCurrentRepo()
        {
            return $this->cityRepo;
        }
        
        /**
         * To get all enabled cities
         * 
         * @return \Illuminate\Database\Eloquent\Collection|static[]
         */
        protected function getAllCities()
        {           
            try {
                
                return $this->cityRepo->enable()->all();
                
            } catch (\Illuminate\Database\QueryException $ex) {            
                
                $this->error($ex->getMessage());
          
                $this->comment(PHP_EOL. 'Probably database connection is not ready or migration class and seeder class about App\City is not loaded!');
                
                return array();
            }
        }
}
