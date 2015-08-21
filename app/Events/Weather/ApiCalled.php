<?php

namespace App\Events\Weather;

use App\Events\Event;
use App\WeatherForeCastResource as Resource;
use Illuminate\Queue\SerializesModels;

//use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * When the app calls to get data on api, this event is fired. 
 * 
 */
class ApiCalled extends Event
{
    use SerializesModels;
    
    
    /**
     * @var \App\WeatherForeCastResource 
     */
    private $resource;

        /**
         * Create a new event instance.
         *
         * @return void
         */
        public function __construct(Resource $resource)
        {
            $this->resource     = $resource;
        }       
        
        /**
         * To model
         * 
         * @return \App\WeatherForeCastResource 
         */
        public function getReourceModel()
        {
            return $this->resource;
        }

        /**
         * Get the channels the event should be broadcast on.
         *
         * @return array
         */
        public function broadcastOn()
        {
            return [];
        }
    }
