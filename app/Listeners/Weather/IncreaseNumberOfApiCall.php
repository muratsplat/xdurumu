<?php

namespace App\Listeners\Weather;

use App\Events\Weather\ApiCalled;
//use Illuminate\Queue\InteractsWithQueue;
//use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * To increase number of api cals for certain api resource
 * 
 * @package Weather
 */
class IncreaseNumberOfApiCall
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  App\Events\Weather\ApiCalled  $event
     * @return void
     */
    public function handle(ApiCalled $event)
    {
        $resource = $event->getReourceModel();
        
        $resource->increaseNumberOfApiCall();  
    }
}
