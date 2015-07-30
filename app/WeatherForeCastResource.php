<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 *  Weather Forecast Resources Model
 * 
 *  @package WeatherForeCast 
 */
class WeatherForeCastResource extends Model
{
 
    use SoftDeletes;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'weather_forecast_resources';
    
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
    protected $fillable = ['name', 'description', 'url', 'api_url', 'enable', 'paid'];
    
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['id', 'api_calls_count'];    
        
        /**
         * Defining one to many relations 
         * 
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function currents()
        {
            return $this->hasMany('App\WeatherCurrent', 'weather_forecast_resource_id', 'id');
        }
    
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
         * Scope a query to only include users of a given type.
         *
         * @return \Illuminate\Database\Eloquent\Builder
         */
        public function scopePaid($query)
        {
            return $query->where('paid', 1);
        }
        
        /**
         * Scope a query to only include users of a given type.
         *
         * @return \Illuminate\Database\Eloquent\Builder
         */
        public function scopeFree($query)
        {
            return $query->where('paid', 0);
        }
        
        /**
         * Scope a query to only include users of a given type.
         *
         * @return \Illuminate\Database\Eloquent\Builder
         */
        public function scopeOfName($query, $name)
        {
            return $query->where('name', $name);
        }
        /**
         * Scope a query to only include resources of a apiable.
         *
         * @return \Illuminate\Database\Eloquent\Builder
         */
        public function scopeApiable($query)
        {
            return $query->where('apiable', 1);
        }
        
        
}
