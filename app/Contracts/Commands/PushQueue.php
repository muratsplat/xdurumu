<?php

namespace App\Contracts\Commands;


use Illuminate\Contracts\Queue\Queue;

/**
 * Methods and properties to be easy to controll Queue
 *
 */
trait PushQueue
{    
    /**
     * @var \Illuminate\Contracts\Queue\Queue 
     */
    protected $queue;
    
        /**
         * To push job
         * 
         * @param Object $job
         * @param string queue
         */
        protected function pushJob($job, $queue = "lower")
        {
            $this->queue->pushOn($queue, $job);
        } 
        
        /**
         * To set queue intance 
         * 
         *  @param \Illuminate\Contracts\Queue\Queue $queue Description
         */
        public function setQueue(Queue $queue)
        {
            $this->queue = $queue;            
        }
}
