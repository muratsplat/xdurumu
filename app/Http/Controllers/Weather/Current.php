<?php

namespace App\Http\Controllers\Weather;

use Illuminate\Http\Request;
use App\Contracts\Weather\Repository\ICurrent;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class Current extends Controller
{
    
    /**
     * @var \App\Contracts\Weather\Repository\ICurrent 
     */
    private $current;
    
        /**
         * Create Instance
         * 
         * @param \App\Contracts\Weather\Repository\ICurrent $current
         */
        public function __construct(ICurrent $current)
        {
            $this->current = $current;
        }
        /**
         * Display a listing of the resource.
         *
         * @return Response
         */
        public function index()
        {          
            return $this->current->enableCache()->all();
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
