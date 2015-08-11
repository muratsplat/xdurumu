<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Weather Snow
 * 
 * @package WeatherForcast
 */
class WeatherSnow extends Model
{
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'weather_snows';
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
     public $timestamps = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */            
    protected $fillable = ['3h', 'snow'];
    
        /**
         * Defining an inverse one to many relation
         * 
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function current()
        {
            return $this->belongsTo('App\WeatherCurrent', 'weather_current_id', 'id');        
        }
        
        /**
         * Defining an inverse one to many relation
         * 
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function hourlyStat()
        {
            return $this->belongsTo('App\WeatherHourlyStat', 'weather_hourly_id', 'id');        
        }
    
}
