<?php

namespace App\Libs\Weather;

use App\WeatherForeCastResource;  
use App\Contracts\Weather\Accessor;
use App\Contracts\Weather\ApiClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\ConnectException;

/**
 * The class send get request to access weather data from Open Weather Map API
 * 
 * Api Documentation : http://openweathermap.org/api
 * 
 * @package WeatherForcast
 */
class OpenWeatherMapClient extends ApiRequest implements ApiClient
{
    
    /**
     * Client header attributes
     *
     * @var array
     */
    protected $defaultHeaderAttributes = [
        
        'Accept-Encoding'   => 'gzip',
        'Accept'            => 'application/json'        
    ];    
    
    /**
     * The quries should be for Open Weather Map API
     *
     * @var type 
     */
    protected $shouldBeQueries = [
        
        'APPID'     =>  null,
        'units'     => 'metric',
        'lang'      => 'tr',
        'mode'      => 'json',
    ];
    
    /**
     * Client Queries
     * 
     * Look at: http://guzzle.readthedocs.org/en/latest/request-options.html#query
     *
     * @var array
     */
    protected $queries;
    
    /**
     * The number of milliseconds to delay before sending the request.
     *
     * @var integer 
     */
    protected $delay = 1000; // one second     
    
    /**
     * a url to access currently weather data from api 
     *
     * @var string 
     */
    protected $currentlyUrl = 'weather';
    
    /**
     * a url to access hourly weather data from api 
     *
     * @var string 
     */
    protected $hourlyUrl    = 'forecast';
    
    /**
     * a url to access daily weather data from api 
     *
     * @var string 
     */
    protected $dailyUrl     = 'forecast/daily';  
    
        /**
         * Create a new Instance of http client
         * 
         * @param \App\Contracts\Weather\Accessor $accessor
         * @param \App\WeatherForeCastResource $source
         */
        public function __construct(Accessor $accessor, WeatherForeCastResource $source)
        {
            parent::__construct($accessor, $source);
            
            $config = \App::make('config');
            
            $this->shouldBeQueries['APPID'] = $config->get('api.open_weather_map_api');
        }
        
        /**
         * To get City id for Open Weather Map API
         * 
         * @return int
         */
        public function getCityId()
        {
           return $this->getCity()->getAttribute('open_weather_map_id');
        }         
        
        /**
         * To get all query
         * 
         * @return array
         */
        protected function getAllQueries()
        {
            return array_merge($this->shouldBeQueries, $this->queries);            
        }        
        
        /**
         * To send http request to api server
         * 
         * @return \App\Contracts\Weather\Accessor|null
         * 
         */
        public function sendRequest()
        {
            try {
                
                $response   = $this->sendGetRequest();
                
                $content    = $response->getBody()->getContents();
                
                $this->fireApiCalled($response);
                
                return $this->createNewAccessor($content);
                
            } catch (ConnectException $ex) {        
                
                $this->sendMessageToLogService($ex); 
                
                throw $ex;
            
            } catch (ClientException $ex) {
                
              /**
               * TODO:  If Returned status code is about 
               * statment of server fails casuse of timout, 
               * server busy, bad request, etc
               * request should be send again!! 
               * 
               * It should be write methods to determine that situation..             
               */                
                $this->sendMessageToLogService($ex); 
                
                throw $ex;
                
            } catch (ServerException $ex) {                
                
                $this->sendMessageToLogService($ex);              
                
                throw $ex;               
                
            } catch (RequestException $ex) {
                
                $this->sendMessageToLogService($ex);                 
                    
                throw $ex;       
                
            } catch (\ErrorException $ex) {
                
                $this->log->error('Unknow error!', ['msg' => $ex->getMessage(), 'line' => $ex->getLine()]);   
                
                throw $ex;   
            }
        }
        
        /**
         * To send Error message to Laravel log service
         * 
         * @param \GuzzleHttp\Exception\RequestException $ex
         */
        protected function sendMessageToLogService(RequestException $ex, $type='error')
        {             
            $message = [   
                'request_url'           => $ex->getRequest()->getUri()->getPath(),
                'request_query'         => $ex->getRequest()->getUri()->getQuery(),
                'response_headers'      => $ex->getResponse(),
                'response_status_code'  => null,
                'msg'                   => $ex->getMessage(), 
                'line'                  => $ex->getFile()
            ];
            
            if ($ex->hasResponse()) {
                
                $message['response_status_code'] = $ex->getResponse()->getStatusCode();
            }                
                
            $this->log->{$type}('The request is unsuccess !', $message);
        }
        
        /**
         * To send get request to get weather data
         * 
         * @return \Psr\Http\Message\ResponseInterface
         */
        protected function sendGetRequest()
        {
            $url        = $this->getUrl();          
            
            $options    = $this->getClientOptions();
            
            $queries    = $this->getQueries();       
       
            $client     = $this->createNewClient($options);                      
            
            return $client->get($url, ['query' => $queries]);
        }
        
        /**
         * To get header attributes for sending request
         * 
         * @return array
         */
        protected function getHeaders()
        {
            return $this->defaultHeaderAttributes;
        }        
       
        
        /**
         * To get options for http client
         * 
         * @return array
         */
        protected function getClientOptions()
        {
            return [
                
                'base_uri'          => $this->getHostName(),
                'connect_timeout'   => $this->getConnectionTimeout(),
                'timeout'           => $this->getTimeout(),
                'delay'             => $this->getDelay(),
                'headers'           => $this->defaultHeaderAttributes,                    
            ];
        }
        
        /**
         * To get queries
         * 
         * @return array
         */
        protected function getQueries()
        {
            $id     = $this->getCityId();
            
            $this->addQuery('id', $id);
            
            if ( $this->isDaily() ) {
                /**
                 * You can seach 16 day weather forecast 
                 * with daily average parameters by city name.
                 * 
                 */
                $this->addQuery('cnt', 16);
            }
            
            return array_merge($this->queries, $this->shouldBeQueries); 
        }       
       
}    