<?php

namespace App\Listeners;

//use Illuminate\Queue\InteractsWithQueue;
//use Illuminate\Contracts\Queue\ShouldQueue;
use InvalidArgumentException;

/**
 * This class is a helper which ones cached model is flushed on cache driver
 * when CRUD action is works..
 */
class ModelCacheCleaner
{    
    /**
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    private $model;
            
    /**
     * Create the event listener.
     *
     * @param Object $model Eloquent model
     * @return void
     */
    public function __construct($model=null)
    {        
        if (is_null($model) || ! is_subclass_of($model, 'Illuminate\Database\Eloquent\Model')) {
            
            throw new InvalidArgumentException('Injected value is not valid!. It is must be Eloquen model.');
        }
        
        $this->model = $model; 
        
        $this->checkAndForget();
    }

    /**
     * Handle the event.
     *
     * @param  eloquent  $event
     * @return void
     */
    public function handle($event)
    {      
        
    }
    
    /**
     * To get unique model key
     * 
     * @return string
     */
    private function getUniqueModelKey()
    {
        return createUniqueKeyFromObj($this->model);        
    }
    
    /**
     * Determine if the model is cached
     * 
     * @return bool
     */
    protected function isModelCached()
    {
        $key = $this->getUniqueModelKey();
        
        return \Cache::has($key);
    }
    
    /**
     * To flush cached model on cache driver
     * 
     * @return bool
     */
    public function forget()
    {
        $key = $this->getUniqueModelKey();
        
        return \Cache::forget($key);
    }
    
    /**
     * To check and if the model is cached, flush it
     * 
     * @return bool
     */
    public function checkAndForget()
    {
        if ($this->isModelCached()) {
            
            return $this->forget();
        } 
        
        return false;
    }
}
