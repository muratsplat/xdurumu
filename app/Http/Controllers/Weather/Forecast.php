<?php

namespace App\Http\Controllers\Weather;

use App\City;
use App\Http\Requests;
use App\WeatherCurrent;
use App\Weather\DailyStat;
use App\WeatherHourlyStat;
use Illuminate\Http\Request;
use App\Contracts\Repository\ICity;
use App\Http\Controllers\Controller;
use App\Contracts\Weather\Repository\IHourly;
use App\Contracts\Weather\Repository\IDaily;
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
     * @var \App\WeatherCurrent; 
     */
    private $current;
    
    
        
        public function __construct(ICity $city, IHourly $hourly, IDaily $daily,ICurrent $current )
        {
            $this->city     = $city;
            
            $this->hourly   = $hourly;
            
            $this->daily    = $daily;
            
            $this->current  = $current;
        }
        
        /**
         * Display a listing of the resource.
         *
         * @return Response
         */
        public function index(Request $request)
        {

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
                
                list($current, $hourly, $daily ) = $this->prepareShowBindedData($city);
            
                
                return view('front.weather.forecast.show')->with(compact('city', 'current', 'hourly', 'daily' ));
            }
            
            
            return $request->all();
           
            
        }      
        
        /**
         * To prepare binded data for show action
         * 
         * @param \App\City $city
         * @return array current, hourly, daily
         */
        private function prepareShowBindedData(City $city)
        {               
            return [           
                
                $this->findCurrent($city),
                $city->weatherHourlyStat,                
                $this->findDaily($city),
           ];              
        }
        
        /**
         * To find Daily Model
         * 
         * @param \App\City $city
         * @return \App\Weather\DailyStat
         */
        private function findDaily(City $city) 
        {
            $daily = $city->weatherDailyStat;
            
            if ( is_null($daily) ) { return null; }
            
            return $this->daily->find($daily->id);
        }       
        
        /**
         * To find Hourly Model
         * 
         * @param \App\City $city
         * @return \App\WeatherHourlyStat
         */
        private function findHourly(City $city) 
        {
            $daily = $city->weatherHourlyStat;
            
            if ( is_null($daily) ) { return null;  }
            
            return $this->hourly->find($daily->id);
        }   
        
    
        
        /**
         * To find Current Model
         * 
         * @param \App\City $city
         * @return \App\WeatherCurrent

         */
        private function findCurrent(City $city) 
        {
            $daily = $city->weatherCurrent;
            
            if ( is_null($daily) ) { return null;  }
            
            return $this->current->find($daily->id);
        }
        
        
        
        /**
         * to Find City model by name attribute 
         * 
         * @param string $name
         * @return \Illuminate\Database\Eloquent\Collection
         */
        protected function findCityByName($name)
        {
            return $this->city->getAllOnlyOnesHasWeatherData()->filter(function($item) use ($name) {
                
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
            return $this->city->getAllOnlyOnesHasWeatherData()->filter(function($item) use ($slug) {
                
                return $slug === $item->slug;                                
            });                    
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
