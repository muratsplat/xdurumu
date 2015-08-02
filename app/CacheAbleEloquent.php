<?php 

namespace App;

use Illuminate\Database\Eloquent\Model as M;
use App\Listeners\ModelCacheCleaner;
/**
 * This abstract class is created for cacheable models
 *
 * @author Murat Ödünç <murat.asya@gmail.com>
 */
abstract class CacheAbleEloquent  extends M {    
          
        /**
         * To add event to eloquent listener
         */
        public static function boot() {
            parent::boot();        

            $callback = function($model) {

                $cleaner = new ModelCacheCleaner($model);          
            };

            static::saved($callback);         
            static::updated($callback);                     
            static::created($callback);           
            static::deleted($callback);           
        }
  
}