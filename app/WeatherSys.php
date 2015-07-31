<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Weather Sys
 * 
 * @package WaetherForcast
 */
class WeatherSys extends Model
{
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'weather_sys';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */            
    protected $fillable = ['country', 'sunrise', 'sunset'];    
    
        /**
         * TO define an  inverse one to one relation
         * 
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function current() {
            
            return $this->belongsTo('App\WeatherCurrent', 'weather_current_id','id');
        }
    
}
