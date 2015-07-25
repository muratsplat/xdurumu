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
}
