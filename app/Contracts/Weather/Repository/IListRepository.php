<?php

namespace App\Contracts\Weather\Repository;

use App\WeatherHourlyStat                       as HourlyStatModel;
use App\Libs\Weather\DataType\WeatherHourly     as HourlyData;

/**
 * Weather List Repository Interface
 * 
 * @package WeatherForcast
 */
interface IListRepository extends IBaseRepository
{        
    
        /**
         * To create many list by given hourly model via the relationships
         * 
         * @param   \App\WeatherHourlyStat                    $hourly
         * @param   \App\Libs\Weather\DataType\WeatherHourly    $data
         * @return  \Illuminate\Support\Collection    created WeatherList instances
         */
        public function createListsByHourlyStat(HourlyStatModel $hourly ,  HourlyData $data);
}