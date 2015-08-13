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
         * To create many list by given hourly model via the relationships
         * 
         * @param \App\WeatherHourlyStat $hourly
         * @param array $list
         * @return array    created instances
         */
        public function createManyListByHourlyStat(Hourly $hourly , array $list);
    
}