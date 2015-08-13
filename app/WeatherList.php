<?php

namespace App;


use App\CacheAbleEloquent as CacheAble;

/**
 * Weather List Model is created for CRUD jobs to manage lists of weather hourly and daily data..
 * 
 * @package WeatherForCast
 */
class WeatherList extends CacheAble
{
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'weather_lists';   
                  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */            
    protected $fillable = ['source_updated_at', 'td'];
    
        /**
         * Define a polymorphic, inverse one-to-one or many relationship.
         * 
         * @return \Illuminate\Database\Eloquent\Relations\MorphTo
         */
        public function listable()
        {
            return $this->morphTo('listable', 'listable_type', 'listable_id');
        }       
}
