<?php

namespace App\Jobs\Weather;

use App\City;
use App\Jobs\Job;
use App\Contracts\Weather\Accessor;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Contracts\Weather\Repository\IHourly as HourlyRepo;

/**
 * This Job make update to weather hourly data via injected city model
 * 
 */
class UpdateHourly extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    
    /**
     * @var \App\City 
     */
    private $city;
    
    /**
     * @var App\Contracts\Weather\Repository\IHourlyRepository
     */
    private $hourlyRepo;    
    
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
        public function handle(HourlyRepo $repo )
        {             
            $this->init($repo);
            
            $client     = $this->getApiClient();
            
            $city       = $this->getCity();
            
            $accessor   = $client->selectCity($city)->hourly()->sendRequest();            
            
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
         * @return  \App\WeatherHourlyStat 
         */
        protected function importData(City $city, Accessor $accessor)
        {
            return $this->hourlyRepo->selectCity($city)->import($accessor);
        }        
        
        /**
         * To set hourly repository and injected Weather Api Factory
         * 
         * @param \App\Contracts\Weather\Repository\IHourlyRepository $hourly
         */
        private function init(HourlyRepo $hourly)
        {
            $this->hourlyRepo      = $hourly;
            
            $this->weatherApiFactory= app('app.weather.factory');                
        }
     
}
