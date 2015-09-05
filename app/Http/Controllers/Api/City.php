<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Contracts\Repository\ICity;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;

/**
 * City Controller
 * 
 */
class City extends Controller
{
    /**
     *
     * @var \App\Contracts\Repository\ICity; 
     */
    private $city;
    
        /**
         * Create Instance
         * 
         * @param \App\Contracts\Repository\ICity $city
         */
        public function __construct(ICity $city)
        {
            $this->city = $city;
        }
        
        /**
         * Display a listing of the resource.
         *
         * @return Response
         */
        public function index(Request $request)
        {                       
            $attributes     = $request->get('only', 'id,name,slug');
            
            $elements       = explode(',', $attributes);
            
            $cities         = $this->city->getCitiesHasWeatherDataByFiteringInArray($elements);             
            
            $removeStringKeys = array_values($cities);
            
            $date           = Carbon::now()->addHours(2);
            
            return response()->json($removeStringKeys)->setExpires($date);
        }       
        

        /**
         * 
         * @param \Illuminate\Database\Eloquent\Collection $collection
         * @return array
         */
        protected function convertToArrayList(Collection $collection)
        {           
            return $collection->toArray();
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
        public function show($id)
        {
            //
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
