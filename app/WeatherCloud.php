<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Weather Clouds
 * 
 * @package WaetherForcast
 */
class WeatherCloud extends Model
{   
      
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'weather_clouds';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */            
    protected $fillable = [
            'temp', 
            'temp_min', 
            'temp_max', 
            'temp_eve',
            'temp_night',
            'temp_morn',
            'pressure',
            'humidity',
            'sea_level',
            'grnd_level',
            'temp_kf'
        ];
    
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
