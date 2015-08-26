<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use App\CacheAbleEloquent;


/**
 * App\City
 *
 * 
 */
class City extends  CacheAbleEloquent implements SluggableInterface
{
    
    use SoftDeletes, SluggableTrait;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cities';
    
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
    protected $fillable = ['name', 'latitude', 'longitude', 'country', 'open_weather_map_id', 'priority'];
    
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['open_weather_map_id', 'deleted_at'];
    
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
         * Defining one to one relationship
         * 
         * @return \Illuminate\Database\Eloquent\Relations\HasOne
         */
        public function weatherCurrent()
        {
            return  $this->hasOne('App\WeatherCurrent', 'city_id', 'id');        
        }
        
        /**
         * Defining one to one relationship
         * 
         * @return \Illuminate\Database\Eloquent\Relations\HasOne
         */
        public function weatherHourlyStat()
        {
            return  $this->hasOne('App\WeatherHourlyStat', 'city_id', 'id');        
        }
        
       /**
         * To get weather daily stat model in relationship
         * 
         * @return \Illuminate\Database\Eloquent\Relations\HasOne
         */
        public function weatherDailyStat()
        {
            return  $this->hasOne('App\Weather\DailyStat', 'city_id', 'id');        
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
        public function scopeOfCountry($query, $code)
        {
            return $query->where('country', $code);
        }        
        
        /**
         * To set Priority attribute
         * 
         * @param int $value
         * @return int
         */
        public function setPriorityAttribute($value)
        {
            $num = (integer) $value;
            
            switch($num) {
                
                case $num < 0 : return $this->attributes['priority'] = 0;
                    
                case $num >= 4 : return $this->attributes['priority'] = 4;             
            }
            
            return $this->attributes['priority'] = $num;
       }
       
       /**
        * To increase priority attribute by one
        * 
        * @return type
        */
       public function incPriority()
       {
           return $this->increment('priority');
       }
       
       /**
        * To decrease priority attribute by one
        * 
        * @return type
        */
       public function decPriority()
       {
           return $this->decrement('priority');
       }
        
    
}
