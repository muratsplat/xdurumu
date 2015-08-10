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

        /**
         * TO define an one to one relationship
         * 
         * @return \Illuminate\Database\Eloquent\Relations\HasOne
         */
        public function main() 
        {            
            return $this->hasOne('App\WeatherMain', 'weather_hourly_id','id');
        }
        
        /**
         * TO define an one to one relationship
         * 
         * @return \Illuminate\Database\Eloquent\Relations\HasOne
         */
        public function wind() 
        {            
            return $this->hasOne('App\WeatherWind', 'weather_hourly_id','id');
        }
        
        /**
         * TO define an one to one relationship
         * 
         * @return \Illuminate\Database\Eloquent\Relations\HasOne
         */
        public function clouds() 
        {            
            return $this->hasOne('App\WeatherCloud', 'weather_hourly_id','id');
        }   
}
