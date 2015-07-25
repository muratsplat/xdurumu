<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * 
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
}
