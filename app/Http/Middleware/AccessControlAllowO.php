<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Http\Request;


/**
 * The MiddleWare allows adding header about accees controll policy
 * 
 * More details : 
 *  https://developer.mozilla.org/en-US/docs/Web/HTTP/Access_control_CORS
 */
class AccessControlAllowO
{
    
    /**
     * @var \Illuminate\Http\Response 
     */
    private $response;

    /**
     * @var \Illuminate\Http\Request 
     */
    private $request;
    
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @param   string subdomain to allow
         * @return mixed
         */
        public function handle($request, Closure $next, $subdomain)
        {
            $this->setResponse( $next($request) ); 
            
            $this->setRequest($request);            

            $this->addAccessControlAllowOrigin($subdomain);

            return $this->response;       
        }    

        /**
         * To create acces controll allow origin header for passed url 
         * 
         * @param string $subdomain
         * @return void
         */
        private function addAccessControlAllowOrigin($subdomain)
        {       
            $protocol   = $this->request->isSecure() ? 'https://' : 'http://';
            
            $fullUrl    = $protocol . $subdomain . '.' . $this->getMainHost();            
            
            $this->response->header('Access-Control-Allow-Origin',  $fullUrl);        
        }

        /**
         * To create acces controll allow method header for passed methods
         * 
         * @param array $methods
         * @return void
         */
        private function addAccessControlAllowMethods(array $methods)
        {        
            $this->response->header('Access-Control-Allow-Methods', implode(',', $methods));        
        }

        /**
         * To set Response Object
         * 
         * @param \Illuminate\Http\Response $response
         */
        protected function setResponse(Response $response)
        {
            $this->response = $response;
        }
        
        /**
         * To set Request Object 
         * 
         * @param \Illuminate\Http\Request $request
         */
        protected function setRequest(Request $request)
        {
            $this->request = $request;
        }
        
        
        /**
         * To get main host without subdomain
         * 
         * @return string  foo.com
         */
        public function getMainHost()
        {
            $url = $this->request->getHttpHost(); // return foo.bar.com
            
            $segments = explode('.', $url);
            
            if ( count($segments)  > 2 ) {
                
                $segments = array_slice($segments, -2);
            }
            
            return implode('.', $segments);
        }
}
