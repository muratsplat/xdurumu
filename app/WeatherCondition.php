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
     * Slug options
     *
     * @var array 
     */
    protected $sluggable = [
            
            'build_from' => 'name',
            'save_to'    => 'slug',
    ];
    
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
        * Scope a query to only include ones of the given open_weather_map_id
        *
        * @return \Illuminate\Database\Eloquent\Builder
        */
        public function scopeOfOpenWetherMapId($query, $id)
        {
           return $query->where('open_weather_map_id', $id);
        } 

        /**
         * Defining one-to-many relations
         * 
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function currents()
        {
            return $this->belongsTo('App\WeatherCurrent', 'weather_condition_id', 'id');            
        }
        
       /**
        * Find a model by its primary key or return new static.
        *
        * @param  mixed  $id
        * @param  array  $columns
        * @return \Illuminate\Support\Collection|static
        */
       public static function findOpenWeatherMapIdOrNew($id, $columns = ['*'])
       {
           if (!is_null($model = static::q)) {
               return $model;
           }

           return new static;
       }
   }