<?php

namespace App;

use App\CacheAbleEloquent; 

class WeatherHourlyStat extends CacheAbleEloquent
{
   
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'weather_hourly_stats';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */            
    protected $fillable = ['enable', 'source_updated_at', 'dt'];    
    
    
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
         * To define an many to many polymorphic relation
         * 
         * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
         */
        public function conditions()
        {
            return $this->morphToMany('App\WeatherCondition', 'weather_condition_able', 'weather_condition_ables');            
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
