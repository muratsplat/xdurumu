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
    protected $fillable = ['country', 'sunrise', 'sunset'];    
    
        /**
         * TO define an  inverse one to one relation
         * 
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function current() {
            
            return $this->belongsTo('App\WeatherCurrent', 'weather_current_id','id');
        }       
            
        /**
         * Define a polymorphic, inverse one-to-one or many relationship.
         * 
         * @return \Illuminate\Database\Eloquent\Relations\MorphTo
         */
        public function sysable()
        {
            return $this->morphTo('sysable', 'sysable_type', 'sysable_id');
        }
    
}
