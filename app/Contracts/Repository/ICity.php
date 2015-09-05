<?php

namespace App\Contracts\Repository;

use App\City;

/**
 * Current Repository Interface
 * 
 * @package WeatherForcast
 */
interface ICity extends ICacheAble
{   
        /**
         * To get first model  or create new instance model
         * 
         * @param \App\City     $city
         * @return \App\WeatherHourlyStat
         */
        public function firstOrCreateWeatherHouryStat(City $city);
        
        /**
         * To get first model or create new instance model
         * 
         * @param \App\City     $city
         * @return \App\WeatherCurrent  
         */
        public function firstOrCreateWeatherCurrent(City $city);
        
        /**
         * To get first model  or create new instance model
         * 
         * @param \App\City     $city
         * @return \App\Weather\DailyStat
         */
        public function firstOrCreateWeatherDailyStat(City $city);
        
       /**
         * To delete old hourly weather lists belongs to given City  model
         * 
         * @param \App\City $city $city
         * @return int|null
         */
        public function deleteOldHourlyLists(City $city);       
        
        /**
         * To get WeatherList model belongs to Weather HourlyStat by given city model
         * 
         * @param \App\City $city
         * @return \Illuminate\Database\Eloquent\Collection
         */
        public function getAllHourlyListByCity(City $city);

        /**
         * To get Weather Hourly Stat model belengs to given model
         * 
         * @param  \App\City $city
         * @return \App\WeatherHourlyStat
         */
        public function getHourlyStatByCity(City $city);
        
        /**
         * To get Weather Daily Stat model belengs to given model
         * 
         * @param  \App\City $city
         * @return \App\WeatherDailyStat
         */
        public function getDailyStatByCity(City $city);        
        
         /**
         * To get WeatherList model belongs to Weather Daily Stat by given city model
         * 
         * @param \App\City $city
         * @return \Illuminate\Database\Eloquent\Collection
         */
        public function getAllDailyListByCity(City $city);
        
        /**
         * To delete old  daily weather lists belongs to given City  model
         * 
         * @param \App\City $city $city
         * @return int|null
         */
        public function deleteOldDailyLists(City $city);        
        
        /**
         * To deletes old  hourly and daily weather list models
         * 
         * @param App\City $city
         * @return int  deletes records
         */
        public function deleteOldListsByCity(City $city);
        
         /***
         * To find city by given ID
         * 
         * @param int $cityId 
         * @return \App\City|null
         */
        public function find($cityId);
        
        /**
         * To get model by given slug
         * 
         * @param string $citySlug
         * @return \App\City|null
         */
        public function findBySlug($citySlug);        
        
        /**
         * To update City
         * 
         * 
         * @param int $cityID
         * @param array $attributes
         * @return bool|int
         * @throws \InvalidArgumentException
         */
        public function update($cityID, array $attributes);
        
        /**
         * To get all cities has weather data
         * 
         * @return \Illuminate\Database\Eloquent\Collection
         */
        public function getAllOnlyOnesHasWeatherData();
        
        /**
         * To get all cities has weather data by filtering elements
         * 
         * @return array
         */
        public function getCitiesHasWeatherDataByFiteringInArray(array $elements);  
}