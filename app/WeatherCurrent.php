<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Weather Current 
 * 
 * @package WeatherForecast
 */
class WeatherCurrent extends Model
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
         * To define an inverse one-to-one relationship 
         * 
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function condition() 
        {
            return $this->belongsTo('App\WeatherCondition', 'weather_conditions_id', 'id');
        }

        /**
         * To define an inverse one-to-one relationship 
         * 
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function weatherForeCastResource() 
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
        public function rains() 
        {            
            return $this->hasMany('App\WeatherRain', 'weather_current_id','id');
        }
        
        /**
         * TO define an one to one relationship
         * 
         * @return \Illuminate\Database\Eloquent\Relations\HasOne
         */
        public function snows() 
        {            
            return $this->hasMany('App\WeatherSnow', 'weather_current_id','id');
        }
        
        /**
         * TO define an one to one relationship
         * 
         * @return \Illuminate\Database\Eloquent\Relations\HasOne
         */
        public function cloud() 
        {            
            return $this->hasOne('App\WeatherCloud', 'weather_current_id','id');
        }
        
       
    
    
    
    
}
