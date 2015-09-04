<?php

namespace App\Http\Controllers\Weather;

use App\City;
use Carbon\Carbon;
use App\Http\Requests;
use App\WeatherCurrent;
use App\Weather\DailyStat;
use App\WeatherHourlyStat;
use Illuminate\Http\Request;
use App\Contracts\Repository\ICity;
use App\Http\Controllers\Controller;
use App\Contracts\Weather\Repository\IList;
use App\Contracts\Weather\Repository\IDaily;
use Illuminate\Database\Eloquent\Collection;
use App\Contracts\Weather\Repository\IHourly;
use App\Contracts\Weather\Repository\ICurrent;


class Forecast extends Controller
{   
    
    /**
     * @var App\Contracts\Repository\ICity 
     */
    private $city;    
    
    /**
     * @var \App\Contracts\Weather\Repository\IHourly
     */
    private $hourly;
    
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
    
    
        
        public function __construct(ICity $city, IHourly $hourly, IDaily $daily,ICurrent $current,IList $list )
        {
            $this->city     = $city;
            
            $this->hourly   = $hourly;
            
            $this->daily    = $daily;
            
            $this->current  = $current;
            
            $this->list     = $list;   
            
            setlocale(LC_ALL, 'tr_TR.utf8');
         
        }
        
        /**
         * Display a listing of the resource.
         *
         * @return Response
         */
        public function index(Request $request)
        {
            $name = $request->get('name', null);
            
            if (! is_null($name)) {
                
                $currents = $this->current->enableCache()->all()->filter(function($item) use ($name){
                    
                    return $item->city->name === $name;                   
                });
                
                return view('front.weather.forecast.index')->with(compact('currents'));                  
            }            
           
            $currents = $this->current->enableCache()->all();
            
            return view('front.weather.forecast.index')->with(compact('currents'));           
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return Response
         */
        public function create()
        {
            //
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  Request  $request
         * @return Response
         */
        public function store(Request $request)
        {
            //
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
                
                return view('front.weather.forecast.show')->with(compact('city', 'data'));
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
                $city->weatherHourlyStat,                
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
            list($current, $hourly, $daily) = $this->getWeatherData($city);
            
            return [
                
                'currentStat'   => $current,
                
                'hourlyStat'    => $hourly,
                
                'dailyStat'     => $daily,
                
                'dailyList'     => ! is_null($daily) ? $this->getDailyLists($daily) : new Collection(),
                
                'hourlyList'    => ! is_null($hourly) ? $this->getHourlyLists($hourly) : new Collection(),           
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
            /**
             * Todo: Daily lists includes repeated lists.
             * It houlf be care later
             * 
             */
           return $this->list->getLastListByDailyStat($daily)->sortBy('dt');
        }  
        
        /**
         * To get last lists by hourly stat model
         * 
         * @param   \App\WeatherHourlyStat   $hourly
         * @return  \Illuminate\Database\Eloquent\Collection
         */
        private function getHourlyLists(WeatherHourlyStat $hourly)
        {
           $list = $this->list->getLastListByHourlyStat($hourly);            
           
           return $list->each(function($item) {
               
               if (is_null($item->dt) ) { return; }              
                             
               $carbon = Carbon::createFromTimestampUTC($item->dt);  
               
               $carbon->setLocale('tr');               
               
               $item->date =  $carbon->formatLocalized('%A %d %B');      
               
               $item->day =  $carbon->formatLocalized('%d');      
               
           })->sort()->groupBy('day');       
        } 
        
        /**
         * to Find City model by name attribute 
         * 
         * @param string $name
         * @return \Illuminate\Database\Eloquent\Collection
         */
        protected function findCityByName($name)
        {
            return $this->getAllOnlyCitiesHasWeatherData()->filter(function($item) use ($name) {
                
                return $name === $item->name;                                
            });                    
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
         * To get All cities which have weather data
         * 
         * @return \Illuminate\Database\Eloquent\Collection
         */
        protected function getAllOnlyCitiesHasWeatherData()
        {
            return $this->city->getAllOnlyOnesHasWeatherData();              
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return Response
         */
        public function edit($id)
        {
            //
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  Request  $request
         * @param  int  $id
         * @return Response
         */
        public function update(Request $request, $id)
        {
            //
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return Response
         */
        public function destroy($id)
        {
            //
        }
}
