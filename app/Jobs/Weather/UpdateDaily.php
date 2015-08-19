<?php

namespace App\Jobs\Weather;

use App\City;
use App\Jobs\Job;
use App\Contracts\Weather\Accessor;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Contracts\Weather\Repository\IDaily as Repo;

/**
 * This Job make update to weather daily data via injected city model
 * 
 */
class UpdateDaily extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    
    /**
     * @var \App\City 
     */
    private $city;
    
    /**
     * @var \App\Contracts\Weather\Repository\IDaily
     */
    private $repo;    
    
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
            $this->init($repo);
            
            $client     = $this->getApiClient();
            
            $city       = $this->getCity();
            
            $accessor   = $client->selectCity($city)->daily()->sendRequest();
            
            $model      = $this->importData($city, $accessor);
            
            return $model->exists;                      
        }
        
        /**
         * To get Weather Api Service Factory
         * 
         * @return App\Libs\Weather\ApiServiceFactory
         */
        protected function getApiServiceFactory()
        {
            return $this->weatherApiFactory;
        }
        
        /**
         * To get api client
         * 
         * @return \App\Contracts\Weather\ApiClient
         */
        protected function getApiClient()
        {
            return $this->getApiServiceFactory()->defaultClient();
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
        
        /**
         * To import weather current data to the repository via Accessor 
         * 
         * @param   \App\City                           $city
         * @param   \App\Contracts\Weather\Accessor     $accessor
         * @return  \App\Weather\DailyStat 
         */
        protected function importData(City $city, Accessor $accessor)
        {
            return $this->repo->selectCity($city)->import($accessor);
        }        
        
        /**
         * To set daily repository and injected Weather Api Factory
         * 
         * @param \App\Contracts\Weather\Repository\IDaily $daily
         */
        private function init(Repo $daily)
        {
            $this->repo             = $daily;
            
            $this->weatherApiFactory= app('app.weather.factory');                
        }
     
}
