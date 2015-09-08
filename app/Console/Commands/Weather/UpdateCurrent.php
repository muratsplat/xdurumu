<?php

namespace App\Console\Commands\Weather;

use App\Contracts\QueuePriority;
use App\Console\TestAbleCommand;
use App\Contracts\Repository\ICity                  as CityRepo;
use App\Jobs\Weather\UpdateCurrent                  as Current;
use Illuminate\Contracts\Queue\Queue;
use App\Contracts\Commands\PushQueue;

/**
 * This command make update to weather forecast current data of all cities
 *  
 */
class UpdateCurrent extends TestAbleCommand
{   
    use PushQueue, QueuePriority;
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
    protected $description = 'Update currently weather forcast data of each all cities from API Service';
    
    /**
     * @var \App\Contracts\Repository\ICity
     */
    private $cityRepo;  
    
        /**
         * Create a new command instance.
         * 
         * @param \Illuminate\Contracts\Queue\Queue $queue Description
         * @param \App\Contracts\Repository\ICity   $city Description
         */
        public function __construct(Queue $queue, CityRepo $city)
        {
            parent::__construct();
            
            $this->cityRepo     = $city; 
            
            $this->setQueue($queue);           
        }

        /**
         * Execute the console command.
         *
         * @return mixed
         */
        public function handle()
        {           
            $no   = 0;
            
            $delay  = \Config::get('app.job_delay');
            
            foreach ($this->getAllCities() as $city) {              
                
                $no++;
                
                $job    = ( new Current($city) )->delay($delay);
                
                $queue  = $this->createQueueName($city->priority);
                
                $this->pushJob($job, $queue);
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
}
