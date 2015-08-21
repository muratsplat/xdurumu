<?php

namespace App\Events\Weather;

use App\Events\Event;
use App\WeatherForeCastResource as Resource;
use Illuminate\Queue\SerializesModels;
use \Psr\Http\Message\ResponseInterface as Response;

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
     * @var \Psr\Http\Message\ResponseInterface
     */
    private $response;

        /**
         * Create a new event instance.
         *
         * @return void
         */
        public function __construct(Resource $resource, Response $response)
        {
            $this->resource     = $resource;
            
            $this->response     = $response;
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
         * To get http response
         * 
         * @return \Psr\Http\Message\ResponseInterface
         */
        public function getResponse()
        {
            return $this->response;            
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
