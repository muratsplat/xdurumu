<?php

namespace App\Jobs\Weather;

use App\City;
use App\Jobs\Job;
use App\Jobs\ReConnectDB;
use App\Contracts\Weather\Accessor;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Contracts\Weather\Repository\ICurrent as CurrentRepo;

/**
 * This Job make update to weather current data each injected city
 * 
 */
class UpdateCurrent extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels, ReConnectDB;
    
    /**
     * @var \App\City 
     */
    private $city;
    
    /**
     * @var \App\Contracts\Weather\Repository\ICurrent
     */
    private $currentRepo;    
    
    /**
     * @var \App\Libs\Weather\ApiServiceFactory
     */
    private $weatherApiFactory;

        /**
         * Create a new job instance.
         *
         * @param App\City  $city
         * @param \App\Contracts\Weather\Repository\ICurrent $current 
         * @return void
         */
        public function __construct(City $city)
        {
            parent::__construct();
            
            $this->city             = $city;          
        }

        /**
         * Execute the job.
         *
         * @return void
         */
        public function handle(CurrentRepo $current )
        {             
            $this->init($current);
            
            $client     = $this->getApiClient();
            
            $city       = $this->getCity();
            
            $accessor   = $client->selectCity($city)->current()->sendRequest();
            
            $model      = $this->importCurrentData($city, $accessor);
            
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
         * @return  \Illuminate\Database\Eloquent\Model 
         */
        protected function importCurrentData(City $city, Accessor $accessor)
        {
            return $this->currentRepo->selectCity($city)->import($accessor);
        }        
        
        /**
         * To set current repository and injected Weather Api Factory
         * 
         * @param \App\Contracts\Weather\Repository\ICurrent $current
         */
        private function init(CurrentRepo $current)
        {
            $this->currentRepo      = $current;
            
            $this->weatherApiFactory= app('app.weather.factory');                
        }
     
}
