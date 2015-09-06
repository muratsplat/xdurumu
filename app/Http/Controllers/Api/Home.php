<?php

namespace App\Http\Controllers\Api;

//use Illuminate\Http\Request;

//use App\Http\Requests;
use App\Http\Controllers\Controller;

class Home extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
         /**
         * To avoid domain conflicts when 
         * the app runs on test, local, production env.. 
         */
        $domain = config('app.domain');
        
        return redirect('http://' . $domain);     
    }
}
