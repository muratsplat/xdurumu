<?php

namespace App\Http\Controllers\Weather;

use App\City;
//use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Contracts\Repository\ICity;
//use Illuminate\Http\Request;
//use Roumen\Sitemap\Sitemap as Map;


class SiteMap extends Controller
{
    
    /**
     * @var \Roumen\Sitemap\Sitemap 
     */
    private $sitemap;
    
    /**
     * @var App\Contracts\Repository\ICity 
     */
    private $city;    
    
        /**
         * Create instance controller
         * 
         */
        public function __construct(ICity $city)
        {
            $this->sitemap = \App::make('sitemap');
            
            $this->sitemap->setCache('hava.sitemap',3600*1); // one day
            
            $this->city = $city;
        }
    
    
        /**
         * Display a listing of the resource.
         *
         * @return Response
         */
        public function index()
        {
            if ( $this->sitemap->isCached()) {
                
                return $this->sitemap->render('xml');
            }
            
            $this->addAllCitiesShowingPage();
            
            $this->addCityIndexPage();
            
            return $this->sitemap->render('xml');
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
         * To add City Forecast Urls
         * 
         * @return void
         */
        protected function addAllCitiesShowingPage()
        {           
            foreach ($this->getAllOnlyCitiesHasWeatherData() as $city) {
                
                $url = $this->createShowCityUrl($city);
                
                $priority = $this->createPriority($city);
                
                $this->sitemap->add($url, $city->weatherCurrent->updated_at->toIso8601String(), $priority, 'hourly', [], $city->name . 'hava durumu');           
            }
                
        }
        
        /**
         * To add City Forecast Intex Url
         * 
         * @return void
         */
        protected function addCityIndexPage()
        {          
            $name   = '1000 Aşkın Konumun Hava Durumu - Günlük, Saatlik, Anlık';
            
            $url    = action('Weather\Forecast@index');
          
            $cities = $this->getAllOnlyCitiesHasWeatherData();
            
            if ( $cities->count() === 0 ) { return; }
            
            $random = $cities->random();
            
            $time = $random->weatherCurrent->updated_at->toIso8601String();            
                
            $this->sitemap->add($url, $time, 1.0, 'hourly', [], $name . 'hava durumu');                            
        }        
        
        /**
         * To create url to access city forecast page
         * 
         * @param \App\City $city
         * @return string   url
         */
        private function createShowCityUrl(City $city) 
        {
            return action('Weather\Forecast@show', $city->slug);
        }
        
        /**
         * To create priority 
         * 
         * @param \App\City $city
         * @return floay
         */
        private function createPriority(City $city)
        {
            switch ($city->priority) {
                
                case 0 : return  1.0;
                case 1 : return  0.9;
                case 2 : return  0.8;
                case 3 : return  0.7;     
                case 4 : return  0.6;
            }
        }
      
}
