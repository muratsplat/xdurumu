<?php

namespace App\Console\Commands\Weather;

use App\Console\TestAbleCommand;
use App\Jobs\Weather\UpdateDaily as Job;
use Illuminate\Contracts\Queue\Queue;
use App\Contracts\Repository\ICity as CityRepo;

/**
 * This command make update to weather forecast Daily data of all cities
 *  
 */
class UpdateDaily extends TestAbleCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update daily weather forcast data of each all cities from API Service';
    
    /**
     * @var \App\Contracts\Repository\ICity
     */
    private $cityRepo;    
    
    /**
     * @var \Illuminate\Contracts\Queue\Queue 
     */
    private $queue;
            
        /**
         * Create a new command instance.
         * 
         * @param \Illuminate\Contracts\Queue\Queue $queue Description
         * @param \App\Contracts\Repository\ICityRepository $city Description
         */
        public function __construct(Queue $queue, CityRepo $city)
        {
            parent::__construct();
                       
            $this->queue        = $queue;   
            
            $this->cityRepo     = $city; 
        }

        /**
         * Execute the console command.
         *
         * @return mixed
         */
        public function handle()
        {           
            $no   = 0;
            
            foreach ($this->getAllCities() as $city) {              
                
                $no++;
                
                $job = new Job($city);
                
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
                
                return $this->cityRepo->onModel()->enable()->get();
                
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
            $this->queue->pushOn('db-medium', $job);
        } 
}