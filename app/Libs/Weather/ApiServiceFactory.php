<?php

namespace App\Libs\Weather;

use Illuminate\Contracts\Container\Container;
use App\Contracts\Weather\IForecastResourceRepository as Resource;
use App\WeatherForeCastResource as ResourceModel;
use App\Libs\Weather\OpenWeatherMap;
use InvalidArgumentException;
use LogicException;
use UnexpectedValueException;
//use Illuminate\Contracts\Logging\Log;

/**
 * This class injectes all weather api objects to Laravel IoC
 */
class ApiServiceFactory
{    
    /**
     * The IoC container instance.
     *
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;
    
    /**
     * @var \App\Contracts\Weather\IForecastResourceRepository
     */
    private $resource;
    
    /**
     * Current Weather Forecast Resource Priority
     *
     * @var integer
     */
    private $currentPriority;
    
    /**
     * Laravel Log Service
     *
     * @var \Illuminate\Contracts\Logging\Log
     */
    private $log;
    
    
        /**
         * Create a new connection factory instance.
         *
         * @param  \Illuminate\Contracts\Container\Container  $container
         * @return void
         */
        public function __construct(Container $container)
        {
            $this->container    = $container;
            
            $resource           = $container->make('App\Contracts\Weather\IForecastResourceRepository');
            
            $this->log          = $container->make('log');
            
            $this->setForeCastResource($resource);
        }        
        
        /**
         * To set Weather Forecast Resource Repository
         * 
         * @param \App\Contracts\Weather\IForecastResourceRepository
         * @return void
         */
        private function setForeCastResource(Resource $resource)
        {
            $this->resource = $resource;                  
        } 
        
        /**
         * 
         * @return \App\WeatherForeCastResource
         */
        private function getDefaultResource()
        {
            $first =  $this->getResourcesByHighestPriority()->first();            
            
            if (! is_null($first)) {
                
                return $first;               
            }
            
            throw new LogicException('It is needed to a default "Weather ForeCaset Resource" record but it is not found any resource!');            
        }
        
        /**
         * To get default accessor
         * 
         * @return App\Libs\Weather\OpenWeatherMap
         */
        public function defaultAccessor()
        {
            $resource   = $this->getDefaultResource();
            $name       = $resource->getAttribute('name');
            
            $this->setCurrentResourcePriority($resource);           
                
            return  $this->createAccessor($name);      
        }
        
        /**
         * To get next accessor
         * 
         * @return App\Libs\Weather\OpenWeatherMap
         */
        public function nextAccessor($priority=1)
        {
            try {            
                
                $next               = $this->whereOnResourceColletion($priority);              
                
                if (is_null($next)) {
                    
                    return $this->defaultAccessor();
                }              
                
                $name = $next->getAttribute('name');
                
                return $this->createAccessor($name);
                
            } catch (InvalidArgumentException $ex) {     
                
                $context = ['msg' => $ex->getMessage(), 'line' => $ex->getLine()];
                
                $this->log()->alert("For next resource an accessor is not founded !", $context);
                        
                return $this->defaultAccessor();

            }        
        }
        
        /**
         * To get next one by given priority
         * 
         * @param int $priority
         * @return \App\WeatherForeCastResource|null
         */
        private function whereOnResourceColletion($priority)
        {
            $nextPriority = $this->getCurrentResourcePriority() + $priority;
            
            return $this->getForeCastResource()->all()->where('priority', $nextPriority, true)->first();            
        }
        
        /**
         * To create accessor to access weather forecast datas.
         * 
         * @param string $name
         * @return App\Libs\Weather\OpenWeatherMap
         * @throws InvalidArgumentException
         */
        public function createAccessor($name='openweathermap')
        {            
            switch ($name)
            {
                case 'openweathermap':                    
                    return new OpenWeatherMap();
            }
            
            throw new InvalidArgumentException("[$name] is not supported !");    
        }

        /**
         * To find ForeCast Resource by given name
         * 
         * @param string $name
         * @return \App\WeatherForeCastResource|null 
         */
        protected function getReourceByName($name)
        {
           return $this->getForeCastResource()->findByName($name);
        }        
        
        /**
         * To get all resources
         * 
         * @return \Illuminate\Database\Eloquent\Collection|static[]
         */
        private function getResourcesByHighestPriority()
        {
            return $this->getForeCastResource()->enableCache()->all();
        }
        
        /**
         * To get Weather Forecast Resource Repository
         * 
         * @return \App\Contracts\Weather\IForecastResourceRepository
         */
        private function getForeCastResource()
        {
            return $this->resource;           
        } 
        
        /**
         * To set current resource priority
         * 
         * @param \App\WeatherForeCastResource   $resoruce
         * @throws \UnexpectedValueException
         */
        private function setCurrentResourcePriority(ResourceModel $resoruce)                
        {           
            $this->currentPriority = (integer) $resoruce->priority;                       
        }
        
        /**
         * To get current resource priority
         * 
         * @return integer $number
         * @throws \UnexpectedValueException
         */
        private function getCurrentResourcePriority()                
        {
            if ( ! is_null($this->currentPriority)) {
                
                return $this->currentPriority;
            }
            
            throw new UnexpectedValueException('Current Priority value is not setted !');            
        }         
        
        /**
         * To access laravel log instance
         * 
         * @return \Illuminate\Contracts\Logging\Log
         */
        private function log()
        {
            return $this->log;
        }
}