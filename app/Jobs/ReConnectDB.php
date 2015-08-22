<?php

namespace App\Jobs;

trait ReConnectDB
{
    
    /**
     * To refresh DB connection
     * 
     * @param string $name specific connection
     * @return \Illuminate\Database\Connection 
     */
    public function reConnectDB($name=null) 
    {        
        return \DB::reconnect($name);
    }
}
