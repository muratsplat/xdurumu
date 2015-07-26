<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Weather Wind
 * 
 * @package WeatherForecast
 */
class WeatherWind extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'weather_winds';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */            
    protected $fillable = ['speed', 'deg'];
    
        /**
         * Defining an inverse one to one relation
         * 
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function current()
        {
            return $this->belongsTo('App\WeatherCurrent', 'weather_current_id', 'id');        
        }
}
