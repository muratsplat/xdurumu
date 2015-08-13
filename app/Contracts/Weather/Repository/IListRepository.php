<?php

namespace App\Contracts\Weather\Repository;

/**
 * Current Repository Interface
 * 
 * @package WeatherForcast
 */
interface IListRepository extends IBaseRepository
{        
    
        /**
         * To create Weatherlist Model by given hourly model via passed WeatherList Data
         * 
         * @param   \App\WeatherHourlyStat                    $hourly
         * @param   \App\Libs\Weather\DataType\WeatherList    $data
         * @return  \App\WeatherList    created instances
         */
        public function createListByHourlyStat(Hourly $hourly , WeatherListData $data);    
}