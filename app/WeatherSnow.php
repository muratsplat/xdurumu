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
         * Define a polymorphic, inverse one-to-one or many relationship.
         * 
         * @return \Illuminate\Database\Eloquent\Relations\MorphTo
         */
        public function snowable()
        {
            return $this->morphTo('snowable', 'snowable_type', 'snowable_id');
        }
        
      
}
