<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Weather Clouds
 * 
 * @package WaetherForcast
 */
class WeatherCloud extends Model
{   
      
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'weather_clouds';
    
    
    /**
     * Disable default timestamps
     *
     * @var bool
     */
    public $timestamps = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */            
    protected $fillable = ['all'];    
    
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [ 'cloudsable_type', 'cloudsable_id'];    
        
        /**
         * Define a polymorphic, inverse one-to-one or many relationship.
         * 
         * @return \Illuminate\Database\Eloquent\Relations\MorphTo
         */
        public function cloudsable()
        {
            return $this->morphTo('cloudsable', 'cloudsable_type', 'cloudsable_id');
        }
        
         /**
         * Defining an inverse one to one relation
         * 
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function hourlyStat()
        {
            return $this->belongsTo('App\WeatherHourlyStat', 'weather_hourly_id', 'id');        
        }
        
}
