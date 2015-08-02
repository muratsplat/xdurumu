<?php

namespace App\Jobs\Weather;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\City;
use App\Repositories\Weather\CurrentRepository as CurrentRepo;

/**
 * This Job updated weather current data for passed city
 * 
 */
class UpdateCurrent extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    
    /**
     * @var \App\City 
     */
    private $city;
    
    /**
     * @var \App\Repositories\Weather\CurrentRepository
     */
    private $currentRepo;
    
    /**
     * JSON Response
     *
     * @var string 
     */
    private $jSONResponse;            

        /**
         * Create a new job instance.
         *
         * @return void
         */
        public function __construct(City $city, CurrentRepo $current)
        {
            $this->city         = $city;
            
            $this->currentRepo  = $current;
        }

        /**
         * Execute the job.
         *
         * @return void
         */
        public function handle()
        {
            
            \Log::info($this->city->name);            
        }
        
        /**
         * To get JSON in response
         * 
         * @return string  JSON
         */
        protected function getJsonResponse()
        {
            return '{
                    "coord":{"lon":139,"lat":35},
                    "sys":{"country":"JP","sunrise":1369769524,"sunset":1369821049},
                    "weather":[{"id":804,"main":"clouds","description":"overcast clouds","icon":"04n"}], 
                    "main":{
                                    "temp":289.5,
                                    "humidity":89,
                                    "pressure":1013,
                                    "temp_min":287.04,
                                    "temp_max":292.04
                                    },
                    "wind":{"speed":7.31,"deg":187.002}, 
                    "rain":{"3h":0},
                    "snow":{"3h":1},
                    "clouds":{"all":92},
                    "dt":1369824698,
                    "id":1851632,
                    "name":"Shuzenji",
                    "cod":200
                }';
            
        }
}
