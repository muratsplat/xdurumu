<?php

namespace App\Weather;

use App\CacheAbleEloquent; 
use Carbon\Carbon;

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
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['city_id','weather_forecast_resource_id','created_at'];  
    
    
    
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
        
        /**
         * To get names of all relations 
         * 
         * @return array
         */
        public function getNameOfRelations()
        {
            return [
                
                'weatherLists',               
            ];
        }
        
}
