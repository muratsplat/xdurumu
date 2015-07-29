<?php

namespace App\Repositories;

use App\City;

/**
 * City Repository Class
 * 
 * @package WeatherForcast
 */
class CityRepository 
{  
    
    /**
     * @var \App\City 
     */
    private $city;
    
    /**
     * @var \Illuminate\Database\Query\Builder
     */
    private $queryBuilder;
    
    /**
     * @var \Illuminate\Database\Eloquent\Collection
     */
    private $all;
    
        /**
         * Constructer
         * 
         * @param App\City $city
         */
        public function __construct(City $city) 
        {            
            $this->city         = $city;            
        }     
 
        
        public function create(array $current)
        {
            
            
        }        
        
        public function update($cityID, array $current)
        {
            
        }
        
        public function delete($cityID)
        {
            
        }
        
        /***
         * To find city by given ID
         * 
         * @return \App\City|null
         */
        public function find($cityID)
        {           
            return $this->onModel()->find($cityID);
        }
        
        /**
         * To get model by given slug
         * 
         * @param string $citySlug
         * @return \App\City|null
         */
        public function findBySlug($citySlug)
        {            
            return $this->onModel()->findBySlug($citySlug);                      
        }
        
        /**
         * To get all of city 
         * 
         * @return \Illuminate\Database\Eloquent\Collection|static[]
         */
        public function all() 
        {
            return is_null($this->queryBuilder) ? $this->onModel()->all() : $this->queryBuilder->get();                   
        }
        
        /**
         * To set source database for reading
         * 
         * @return \App\Repositories\CityRepository
         */
        public function onModel() 
        {
            return  $this->getMainModel();
                    
        }
        
        /**
         * To apply enable scope on current query
         * 
         * @return \App\Repositories\CityRepository
         */
        public function enable() 
        {
            $this->queryBuilder = $this->onModel()->enable();            
            
            return $this;
        }
        
        
        /**
         * To get Weather City model
         * 
         * @return \App\City
         */
        public function getMainModel()                 
        {
            return $this->city;            
        }
}
