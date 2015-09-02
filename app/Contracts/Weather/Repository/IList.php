<?php

namespace App\Contracts\Weather\Repository;

use App\WeatherHourlyStat                       as HourlyStatModel;
use App\Weather\DailyStat                       as DailyStatModel;
use App\Libs\Weather\DataType\WeatherHourly     as HourlyData;
use App\Libs\Weather\DataType\WeatherDaily      as DailyData;

/**
 * Weather List Repository Interface
 * 
 * @package WeatherForcast
 */
interface IList extends IBase
{        
    
        /**
         * To create many list by given hourly model via the relationships
         * 
         * @param   \App\WeatherHourlyStat                    $hourly
         * @param   \App\Libs\Weather\DataType\WeatherHourly    $data
         * @return  \Illuminate\Support\Collection    created WeatherList instances
         */
        public function createListsByHourlyStat(HourlyStatModel $hourly ,  HourlyData $data);
        
        /**
         * To create many list by given daily model via the relationships
         * 
         * @param   \App\Weather\DailyStat                      $daily
         * @param   App\Libs\Weather\DataType\WeatherDaily      $data
         * @return  \Illuminate\Support\Collection    created WeatherList instances
         */
        public function createListsByDailyStat(DailyStatModel $daily, DailyData $data);
        
        /**
         * To get all of models belongs to \App\WeatherHourlyStat
         * 
         * @return \Illuminate\Database\Eloquent\Collection
         */
        public function getAllHourlyList();
        
        /**
         * To get all of model belongs to \App\WeatherDailyStat
         * 
         * @return \Illuminate\Database\Eloquent\Collection
         */
        public function getAllDailyList();        
        
        /**
         * To get last list models by given model
         * 
         * @param object $model
         * @return \Illuminate\Database\Eloquent\Collection
         * @throws \InvalidArgumentException
         */
        public function getLastListsByModel($model);
        
        /**
         * To get only last models belong to passed  hourlystat model
         * 
         * @param \App\Weather\DailyStat $model
         * @param int $amount 37
         * @return \Illuminate\Database\Eloquent\Collection
         */
        public function getLastListByHourlyStat(HourlyStatModel $model, $amount = 37);
        
        /**
         * To get only last models belong to passed  hourlystat model
         * 
         * @param \App\Weather\DailyStat $model
         * @param int  $amount 16
         * @return \Illuminate\Database\Eloquent\Collection
         */
        public function getLastListByDailyStat(DailyStatModel $model, $amount = 16);
}