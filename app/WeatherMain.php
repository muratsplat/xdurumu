<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Weather Clouds
 * 
 * @package WaetherForcast
 */
class WeatherMain extends Model
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
    protected $fillable = ['all'];
}
