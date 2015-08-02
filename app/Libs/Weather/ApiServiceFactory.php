<?php

namespace App\Libs\Weather;

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
         * Create a new connection factory instance.
         *
         * @param  \Illuminate\Contracts\Container\Container  $container
         * @return void
         */
        public function __construct(Container $container)
        {
            $this->container = $container;
        }        
        
}
