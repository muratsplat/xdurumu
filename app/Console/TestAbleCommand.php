<?php

namespace App\Console;

use Illuminate\Console\Command;

/**
 * Testable Console Commands Class
 * 
 * This class writes to help for unit testing
 * There is no known way to manipulate $ouput proberty while testing..
 * 
 *
 * @author muratsplat
 */
abstract class TestAbleCommand extends Command
{
    
    /**
     * For Testing
     *
     * @var bool 
     */
    protected $test = false;

   
        /**
         * it is enabled for testing
         */
        public function enableTesting()
        {
            $this->test = true;
        }
        
        /**
         * To write message on console
         * 
         * @param string $message
         * @return void
         */
        protected function writeInfo($message)
        {
            if ($this->test) {
                
                return;
            }
            
            $this->info(PHP_EOL . $message . PHP_EOL );
        }
        
        /**
         * To write commnet on console
         * 
         * @param string $message
         * @return void
         */
        protected function writeComment($message)
        {
            if ($this->test) { return; }
            
            $this->comment(PHP_EOL . $message);
        }        
        
        /**
         * To write error on console
         * 
         * @param string $message
         * @return void
         */
        protected function writeError($message)
        {
            if ($this->test) { return; }
            
            $this-error($message);
        }
}
