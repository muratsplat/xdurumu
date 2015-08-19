<?php

namespace App\Weather;

use App\CacheAbleEloquent; 

/**
 * Weather Daily Data Stats
 * 
 * @package
 */
class DailyStat extends CacheAbleEloquent
{
   
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'weather_daily_stats';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */            
    protected $fillable = ['enable'];    
    
    
        /**
         * To define an inverse one-to-one relationship 
         * 
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function city() 
        {
            return $this->belongsTo('App\City', 'city_id', 'id');
        }        
        
        /**
         * To get all of WeatherHourlyStat's list via 
         * polymorphic one-to-many relationship.
         * 
         * @return \Illuminate\Database\Eloquent\Relations\MorphMany
         */
        public function weatherLists()
        {
            return $this->morphMany('App\WeatherList', 'listable', 'listable_type', 'listable_id');
        }        
        
        /**
         * To define an inverse one-to-one relationship 
         * 
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function foreCastResource() 
        {
            return $this->belongsTo('App\WeatherForeCastResource', 'weather_forecast_resource_id', 'id');
        } 
}
