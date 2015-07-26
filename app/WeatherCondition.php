<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

/**
 * Weather Conditions
 * 
 * @package WeatherForecast
 */
class WeatherCondition extends Model implements SluggableInterface
{

    use SoftDeletes, SluggableTrait;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'weather_conditions';
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */            
    protected $fillable = ['name', 'description', 'orgin_name', 'orgin_description','icon', 'slug'];
    
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['id', 'open_weather_map_id'];
    
        /**
        * Scope a query to only enebled.
        *
        * @return \Illuminate\Database\Eloquent\Builder
        */
        public function scopeEnable($query)
        {
           return $query->where('enable', 1);
        }       
        
        /**
         * Defining one-to-many relations
         * 
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function currents()
        {
            return $this->hasMany('App\WeatherCurrent', 'weather_condition_id', 'id');            
        }
}