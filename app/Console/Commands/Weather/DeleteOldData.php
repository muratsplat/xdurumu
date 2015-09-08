<?php

namespace App\Console\Commands\Weather;

use App\Console\TestAbleCommand;
use App\Contracts\QueuePriority;
use App\Jobs\Weather\DeleteOldData as Job;
use App\Contracts\Repository\ICity as CityRepo;
use App\Contracts\Commands\PushQueue;
use Illuminate\Contracts\Queue\Queue;

/**
 * This command make update to weather forecast Daily data of all cities
 *  
 */
class DeleteOldData extends TestAbleCommand
{
    use PushQueue, QueuePriority;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete old weather data rows for a reduction of DB size';
    
    /**
     * @var \App\Contracts\Repository\ICity
     */
    private $cityRepo;    

            
        /**
         * Create a new command instance.
         * 
         * @param \Illuminate\Contracts\Queue\Queue $queue Description
         * @param \App\Contracts\Repository\ICityRepository $city Description
         */
        public function __construct(Queue $queue, CityRepo $city)
        {
            parent::__construct();
                       
            $this->setQueue($queue);
            
            $this->cityRepo     = $city; 
        }

        /**
         * Execute the console command.
         *
         * @return mixed
         */
        public function handle()
        {           
            $no     = 0;
            
            $delay  = \Config::get('app.delete_worker_delay'); 
            
            foreach ($this->getAllCities() as $city) {              
                
                $no++;
                
                $job = (new Job($city))->delay($delay);                     
                
                $this->pushJob($job);               
            }
       
            $this->writeInfo("Jobs which are delete old db rows is queued for $no number of city..");
        }
        
        /**
         * To get all enabled cities
         * 
         * @return \Illuminate\Database\Eloquent\Collection|static[]
         */
        protected function getAllCities()
        {           
            try {
                
                return $this->cityRepo->onModel()->get();
                
            } catch (\Illuminate\Database\QueryException $ex) {            
                
                $this->writeError($ex->getMessage());
          
                $this->writeComment('Probably database connection is not ready or'
                        . ' migration class and seeder class about App\City is not loaded!');
                return array();
            }
        }

}