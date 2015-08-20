<?php

namespace App\Jobs\Weather;

use App\City;
use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Contracts\Repository\ICity as Repo;

/**
 * This Job is to delete all old 
 * WeatherList models and it's childs models 
 * via eloquent model   
 */
class DeleteOldData extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    
    /**
     * @var \App\City 
     */
    private $city;    
  
    
    /**
     * @var \App\Libs\Weather\ApiServiceFactory
     */
    private $weatherApiFactory;

        /**
         * Create a new job instance.
         *
         * @param App\City  $city
         * @param App\Repositories\Weather\CurrentRepository $current 
         * @return void
         */
        public function __construct(City $city)
        {
            $this->city             = $city;          
        }

        /**
         * Execute the job.
         *
         * @return bool
         */
        public function handle(Repo $repo )
        {             
            $city = $this->getCity();
            
            return $repo->deleteOldListsByCity($city);              
        }

        /**
         * To get city
         * 
         * @return \App\City 
         */
        protected function getCity()
        {
            return $this->city;
        }             
}
