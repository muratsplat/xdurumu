<?php

namespace App\Console\Commands;

use App\Repositories\CityRepository as CityRepo;
use App\Contracts\Weather\Repository\ICurrentRepository as CurrentRepo;
use App\Jobs\Weather\UpdateCurrent;
use Illuminate\Contracts\Queue\Queue;
use App\Console\TestAbleCommand;

/**
 * This command make update to weather forecast current data of all cities
 *  
 */
class WeatherUpdateCurrent extends TestAbleCommand
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
     * @var \App\Repositories\CityRepository
     */
    private $cityRepo;    
    
    /**
     * @var \Illuminate\Contracts\Queue\Queue 
     */
    private $queue;
    
    /**
     * @var \App\Contracts\Weather\Repository\ICurrentRepository 
     */
    private $currentRepo;
            
        /**
         * Create a new command instance.
         * 
         * @param \Illuminate\Contracts\Queue\Queue $queue Description
         * @param \App\Repositories\CityRepository $city Description
         */
        public function __construct(Queue $queue, CityRepo $city, CurrentRepo $current)
        {
            parent::__construct();
            
            $this->cityRepo     = $city; 
            
            $this->queue        = $queue;   
            
            $this->currentRepo  = $current;
        }

        /**
         * Execute the console command.
         *
         * @return mixed
         */
        public function handle()
        {            
            $repo = $this->getCurrentRepository();
            
            $no   = 0;
            
            foreach ($this->getAllCities() as $city) {              
                
                $no++;
                
                $job = new UpdateCurrent($city, $repo);
                
                $this->pushJob($job);               
            }
       
            $this->writeInfo("$no number of city update request job is queued.");
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
                
                $this->writeError($ex->getMessage());
          
                $this->writeComment('Probably database connection is not ready or'
                        . ' migration class and seeder class about App\City is not loaded!');
                return array();
            }
        }
        
        /**
         * To push job
         * 
         * @param Object $job
         */
        protected function pushJob($job)
        {
            $this->queue->push($job);
        }
        
        /**
         * To get Weather Current Repository
         * 
         * @return \App\Contracts\Weather\Repository\ICurrentRepository 
         */
        protected function getCurrentRepository()
        {   
            return $this->currentRepo;            
        }      
}
