<?php

namespace App\Http\Controllers\Weather;

use App\City;
use Carbon\Carbon;
use App\Weather\DailyStat;
//use App\WeatherHourlyStat;
use Illuminate\Http\Request;
use App\Contracts\Repository\ICity;
use App\Http\Controllers\Controller;
use App\Contracts\Weather\Repository\IList;
use App\Contracts\Weather\Repository\IDaily;
use Illuminate\Database\Eloquent\Collection;
//use App\Contracts\Weather\Repository\IHourly;
use App\Contracts\Weather\Repository\ICurrent;


class Weekend extends Controller
{
    
    /**
     * @var App\Contracts\Repository\ICity 
     */
    private $city;    
    
    /**
     * @var \App\Contracts\Weather\Repository\IHourly
     */
   // private $hourly;
    
    /**
     * @var \App\Contracts\Weather\Repository\IDaily
     */
    private $daily;
    
    /**
     * @var \App\Contracts\Weather\Repository\ICurrent; 
     */
    private $current;
    
    /**
     * @var \App\Contracts\Weather\Repository\IList 
     */
    private $list;
           
    
        
        public function __construct(ICity $city, /** IHourly $hourly,*/ IDaily $daily,ICurrent $current,IList $list )
        {
            $this->city     = $city;
            
            //$this->hourly   = $hourly;
            
            $this->daily    = $daily;
            
            $this->current  = $current;
            
            $this->list     = $list;          
        }
       
        
        /**
         * to Find City model by slug attribute 
         * 
         * @param string $slug
         * @return \Illuminate\Database\Eloquent\Collection
         */
        protected function findCityBySlug($slug)
        {
            return $this->getAllOnlyCitiesHasWeatherData()->filter(function($item) use ($slug) {                
                      
                return $slug === $item->slug;                                
            });                    
        } 

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return Response
         */
        public function show(Request $request, $name)
        {             
            $findsBySlug = $this->findCityBySlug($name);
            
            if ( ! $findsBySlug->isEmpty() ) {
                
                $city   = $findsBySlug->first(); 
                
                $data   = $this->getAllweatherDataForShow($city);                    
                
                return view('front.weather.weekend.show')->with(compact('city', 'data'));
            }
            
            return redirect()->action('Weather\Forecast@index', ['name' => $name]);           
        } 
        
        /**
         * To get Weather data for show action
         * 
         * @param \App\City $city
         * @return array current, hourly, daily
         */
        private function getWeatherData(City $city)
        {               
            return [                
                $city->weatherCurrent,
                //$city->weatherHourlyStat,                
                $city->weatherDailyStat,
           ];              
        }  
        
        /**
         * To get all weather data for show action 
         * 
         * @param \App\City $city
         * @return array    current, hourly, daily, dailyList, hourlyList
         */
        private function getAllweatherDataForShow(City $city)
        {
            list($current,/* $hourly,*/ $daily) = $this->getWeatherData($city);
            
            return [
                
                'currentStat'   => $current,
          
                'dailyStat'     => $daily,
                
                'dailyList'     => ! is_null($daily) ? $this->getOnlyNextWeekendDaysList($daily) : new Collection(),
               
            ];           
        }
        
        /**
         * To get last lists by daily stat model
         * 
         * @param   \App\Weather\DailyStat   $daily
         * @return  \Illuminate\Database\Eloquent\Collection
         */
        private function getDailyLists(DailyStat $daily)
        {
           return $this->list->getLastListByDailyStat($daily)->sortBy('dt');
        }  
        
        
        /**
         * To get only next weekend daily list
         * 
         * @param \App\Weather\DailyStat $daily
         * @return \Illuminate\Database\Eloquent\Collection
         */
        private function getOnlyNextWeekendDaysList(DailyStat $daily)
        {
            return $this->getDailyLists($daily)->filter(function($item) {
                
                $unixDateTime = $item->dt;
                
                $carbon = Carbon::createFromTimestamp($unixDateTime);
                
                return $carbon->isWeekend();               
            });
            
        }
        
        /**
         * To get All cities which have weather data
         * 
         * @return \Illuminate\Database\Eloquent\Collection
         */
        protected function getAllOnlyCitiesHasWeatherData()
        {
            return $this->city->getAllOnlyOnesHasWeatherData();              
        }
   
}
