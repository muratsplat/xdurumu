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
    
}
