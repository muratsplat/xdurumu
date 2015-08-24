<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/**
 * Admin Panel
 */
Route::group(['prefix' => 'back'], function(){    
    
    /**
     * Static index page for AngularJS
     */
    Route::get('index', function(){
        
        return view('back.indexAngular', array());
    });    
    
    
    Route::group(['namespace' => 'Admin'], function() {

        /**
         * City Resource
         */
        Route::resource('city', 'CityCtrl');  
        
    });
   
    
});


