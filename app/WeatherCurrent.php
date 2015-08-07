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
         * To define an inverse one-to-one relationship 
         * 
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function condition() 
        {
            return $this->belongsTo('App\WeatherCondition', 'weather_condition_id', 'id');
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
            return $this->hasOne('App\WeatherMain', 'weather_current_id','id');
        }
        
        /**
         * TO define an one to one relationship
         * 
         * @return \Illuminate\Database\Eloquent\Relations\HasOne
         */
        public function wind() 
        {            
            return $this->hasOne('App\WeatherWind', 'weather_current_id','id');
        }
        
        /**
         * TO define an one to one relationship
         * 
         * @return \Illuminate\Database\Eloquent\Relations\HasOne
         */
        public function rain() 
        {            
            return $this->hasOne('App\WeatherRain', 'weather_current_id','id');
        }
        
        /**
         * TO define an one to one relationship
         * 
         * @return \Illuminate\Database\Eloquent\Relations\HasOne
         */
        public function snow() 
        {            
            return $this->hasOne('App\WeatherSnow', 'weather_current_id','id');
        }
        
        /**
         * TO define an one to one relationship
         * 
         * @return \Illuminate\Database\Eloquent\Relations\HasOne
         */
        public function clouds() 
        {            
            return $this->hasOne('App\WeatherCloud', 'weather_current_id','id');
        }
        
        /**
         * TO define an one to one relationship
         * 
         * @return \Illuminate\Database\Eloquent\Relations\HasOne
         */
        public function sys() 
        {            
            return $this->hasOne('App\WeatherSys', 'weather_current_id','id');
        }  
    
}
