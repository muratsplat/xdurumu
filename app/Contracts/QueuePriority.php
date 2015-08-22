<?php

namespace App\Contracts;

/**
 * Description of QueuePriority
 *
 * @author murat
 */
trait QueuePriority
{
    
        public function createQueueName($priority=4)
        {
            $num = (integer) $priority;
            
            switch ($num) {
                
                case 0  : return 'highest';
                case 1  : return 'high';
                case 2  : return 'medium';
                case 3  : return 'low';
                case 4  : return 'lower';       
            }
            
            return 'lower';
        }
}
