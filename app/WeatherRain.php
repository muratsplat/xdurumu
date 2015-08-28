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
    protected $fillable = ['3h', 'rain'];  
    
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['rainable_id', 'rainable_type'];
    
    
        /**
         * Define a polymorphic, inverse one-to-one or many relationship.
         * 
         * @return \Illuminate\Database\Eloquent\Relations\MorphTo
         */
        public function rainable()
        {
            return $this->morphTo('rainable', 'rainable_type', 'rainable_id');
        }    
}
