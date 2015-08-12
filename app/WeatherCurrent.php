<?php

namespace App;

use App\CacheAbleEloquent as CacheAble;

/**
 * Weather Current 
 * 
 * @package WeatherForecast
 */
class WeatherCurrent extends CacheAble
{
    
   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'weather_currents';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */            
    protected $fillable = ['enable', 'source_updated_at'];    
    
    
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
            return $this->morphOne('App\WeatherMain', 'mainable', 'mainable_type', 'mainable_id');
        }
        
        /**
         * TO define an one to one relationship
         * 
         * @return \Illuminate\Database\Eloquent\Relations\MorphOne
         */
        public function wind() 
        {            
            return $this->morphOne('App\WeatherWind', 'windable','windable_type', 'windable_id');
        }
        
        /**
         * TO define an one to one relationship
         * 
         * @return \Illuminate\Database\Eloquent\Relations\MorphOne
         */
        public function rain() 
        {            
            return $this->morphOne('App\WeatherRain', 'rainable','rainable_type', 'rainable_id');
        }
        
        /**
         * TO define an one to one relationship
         * 
         * @return \Illuminate\Database\Eloquent\Relations\HasOne
         */
        public function snow() 
        {            
            return $this->morphOne('App\WeatherSnow', 'snowable','snowable_type', 'snowable_id');
        }
        
        /**
         * TO define an one to one relationship
         * 
         * @return \Illuminate\Database\Eloquent\Relations\MorphOne
         */
        public function clouds() 
        {            
            return $this->morphOne('App\WeatherCloud', 'cloudsable', 'cloudsable_type', 'cloudsable_id');
        }
        
        /**
         * TO define an one to one relationship
         * 
         * @return \Illuminate\Database\Eloquent\Relations\HasOne
         */
        public function sys() 
        {            
            return $this->morphOne('App\WeatherSys', 'sysable','sysable_type', 'sysable_id');
        }
}