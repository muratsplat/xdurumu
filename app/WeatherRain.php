<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Weather Rain
 * 
 * @package WeatherForcast
 */
class WeatherRain extends Model
{
             
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'weather_rains';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */            
    protected $fillable = ['3h', 'rain'];    
    
        /**
         * Defining an inverse one to many relation
         * 
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function current()
        {
            return $this->belongsTo('App\WeatherCurrent', 'weather_current_id', 'id');        
        }
    
}
