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
}