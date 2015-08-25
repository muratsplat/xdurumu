<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

//use App\Http\Requests\Request;
use App\Http\Controllers\Controller;
use App\Contracts\Repository\ICity;

/**
 * City Controller 
 * 
 */
class CityCtrl extends Controller
{
    
    /**
     * @var \App\Contracts\Repository\ICity
     */
    private $city;    
    
    
        public function __construct(ICity $city)
        {
            $this->city = $city;
        }
        
        /**
         * Display a listing of the resource.
         *
         * @return Response
         */
        public function index()
        {                
            return $this->city->enableCache()->all();
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
            return $this->city->find($id);
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
