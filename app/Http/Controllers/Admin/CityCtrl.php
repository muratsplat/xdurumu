<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\CityUpdateRequest;
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
         * @param  \App\Http\Requests\Admin\CityUpdateRequest  $request
         * @param  int  $id
         * @return Response
         */
        public function update(CityUpdateRequest $request, $id)
        {
           $attributes = $this->getUpdateData($request);           
           
           $result  = $this->city->update($id, $attributes);    
           
           return $result
                   
                   ? response()->json([], 204) 
                   
                   : response()->json(['code' => '500', 'msg' => 'City is not updated'], 500);
        }        
        
        /**
         * To get only  update attributes
         * 
         * @param \App\Http\Requests\Admin\CityUpdateRequest $request
         * @return array
         */
        private function getUpdateData(CityUpdateRequest $request)
        {               
            return $request->only([
                
                'name',
                'slug',
                'enable',
                'priority',                
            ]);
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
