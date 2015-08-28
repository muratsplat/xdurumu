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
    protected $fillable = ['speed', 'deg'];
    
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['windable_type', 'windable_id'];   
    
    
        /**
         * Define a polymorphic, inverse one-to-one or many relationship.
         * 
         * @return \Illuminate\Database\Eloquent\Relations\MorphTo
         */
        public function windable()
        {
            return $this->morphTo('windable', 'windable_type', 'windable_id');
        }
}
