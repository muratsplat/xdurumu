<?php

namespace App\Http\Controllers\Api\Weather;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Contracts\Weather\Repository\ICurrent;
//use App\Http\Requests\Front\Weather\CurrentIndexRequest;
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
        public function index(Request $request)
        {   
            $mode   = $request->get('mode', null);
            $cnt    = $request->get('cnt', null);                              
       
            if ( ! is_null($mode) && $mode === 'rand' ) {
                
                $randoms =  $this->random($cnt);
                
                return $this->jsonResponse($randoms);
            }
            
            $collections =  $this->current->enableCache()->all();
            
            return $this->jsonResponse($collections->toArray());
        }        
        
        /**
         * To get randomly a listing of the resource
         * 
         * 
         * @param int $amount default  value is 10
         * @return \Illuminate\Database\Eloquent\Collection|static[]
         */
        protected function random($amount=10) 
        {            
            $number = is_numeric($amount) && $amount > 0 ? $amount : 1;         
            
            if ( $number < $this->currentsCount() ) {
                
                return $this->current->takeRandomOnAll($number);                   
            }
            
            return  $this->current->enableCache()->all()->toArray();       
        }   
        
        /**
         * To create JSON Response
         * 
         * @param \ArrayAccess $value
         * @return Json Response
         */
        private function jsonResponse(array $value)
        {
            $date           = Carbon::now()->addHour();
            
            return response()->json($value)->setExpires($date);
        }
        
        /**
         * To get number of weather currents models
         * 
         * @param int
         */
        protected function currentsCount()
        {            
            return $this->current->enableCache()->all()->count();
        }       

}
