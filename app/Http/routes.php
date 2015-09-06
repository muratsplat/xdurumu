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


/**
 * To avoid domain conflicts when 
 * the app runs on test, local, production env.. 
 */
$domain = config('app.domain');

/**
 * api.durumum.net   
 */
Route::group(['domain' => "api.$domain", 'namespace' => 'Api'], function() use($domain) { 
    
    Route::get('/', 'Home@index');        
    
    /**
     * Restfull Services
     */
    Route::group(['middleware' => 'aca:hava'], function() {   
        
        /**
         *  Restful Paths of City Resource
         */
        Route::resource('city', 'City', ['only' => ['index']]);           
        
        /**
         * Weather Forecast
         */
        Route::group(['prefix' => 'weather'], function(){
            
            /**
            * Weather Current Restful Paths         
            */
           Route::resource('current', 'Weather\Current', ['only' => ['index']]);            
            
        });      
        
        
    });
   
});

/**
 * hava.durumum.net   
 */
Route::group(['domain' => "hava.$domain", 'namespace' => 'Weather'], function () {
    
    /**
     * Controller Namespace : App\Http\Controllers\Forecast
     */    
    Route::resource('havadurumu', 'Forecast', ['only' => ['index', 'show']]);
    
     /**
     * Controller Namespace : App\Http\Controllers\SiteMap
     */    
    Route::resource('sitemap', 'SiteMap', ['only' => ['index']]);
    
    Route::get('/', 'Home@index', ['only' => ['index']]);
    
    /**
     * Weather Current Restful Paths
     * 
     * This rule will move to into api sub-domian groups !!
     */
    Route::resource('anlik', 'Current', ['only' => ['index']]);
    
});

/**
 * Main Domain Routes
 * 
 * All main domain routes should be defined after sub-domain routes !!
 */
Route::get('/', 'Home@index');

/**
 * Authentication
 */    
Route::group(['prefix' => 'auth'], function(){

    // Authentication routes...
    Route::get('login', 'Auth\AuthController@getLogin');
    Route::post('login', 'Auth\AuthController@postLogin');
    Route::get('auth/logout', 'Auth\AuthController@getLogout');


    // Registration routes...
//        Route::get('auth/register', 'Auth\AuthController@getRegister');
//        Route::post('auth/register', 'Auth\AuthController@postRegister');
});
    

/**
 * Admin Panel
 */
Route::group(['prefix' => 'back', 'namespace' => 'Admin','middleware' => 'auth'], function() {       

    /**
     * Static index page for AngularJS
     */
    Route::get('index', 'Home@index');    
  
    /**
     * City Resource
     */
    Route::resource('city', 'CityCtrl', ['only' => ['index', 'update', 'show']]);          

    
});
