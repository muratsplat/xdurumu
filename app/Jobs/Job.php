<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;

abstract class Job
{
    /*
    |--------------------------------------------------------------------------
    | Queueable Jobs
    |--------------------------------------------------------------------------
    |
    | This job base class provides a central location to place any logic that
    | is shared across all of your jobs. The trait included with the class
    | provides access to the "queueOn" and "delay" queue helper methods.
    |
    */

    use Queueable;    
    
        /**
         * Create A Job
         * 
         */
        public function __construct()
        {
            $this->refreshConnectionIfNeeded();            
        }        
        
        /**
         * To determine if the job needs to refreshed DB connection
         * 
         * @return bool
         */
        public function isNeededRefreshConnectionOnDB()
        {            
            return method_exists($this, 'reConnectDB');
        }
        
        /**
         * To determine if the job needs to refreshed DB connection
         * 
         * @return \Illuminate\Database\Connection|null
         */
        public function refreshConnectionIfNeeded()
        {            
           if ( $this->isNeededRefreshConnectionOnDB() ) {
               
               return $this->reConnectDB();
           }
        }       
}
