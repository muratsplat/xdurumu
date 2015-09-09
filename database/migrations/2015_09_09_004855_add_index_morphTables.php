<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexMorphTables extends Migration
{
    
    private $clouds = 'weather_clouds';
    private $winds  = "weather_winds";
    private $rains  = "weather_rains";
    private $mains  = 'weather_mains';
    private $sys    = 'weather_sys';
    private $snows  = "weather_snows";
    private $lists  = 'weather_lists';
    private $conditions = 'weather_condition_ables';
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * weather_clouds
         */
        \Schema::table($this->clouds, function(Blueprint $t) {
            
            $t->index(['cloudsable_id', 'cloudsable_type']);
        });
        
        /**
         * weather_clouds
         */
        \Schema::table($this->winds, function(Blueprint $t) {
            
            $t->index(['windable_id', 'windable_type']);
        });
        
        /**
         * weather_rains
         */
        \Schema::table($this->rains, function(Blueprint $t) {
            
            $t->index(['rainable_id', 'rainable_type']);
        });
        
        /**
         * weather_mains
         */
        \Schema::table($this->mains, function(Blueprint $t) {
            
            $t->index(['mainable_id', 'mainable_type']);
        });
        
        /**
         * weather_sys
         */
        \Schema::table($this->sys, function(Blueprint $t) {
            
            $t->index(['sysable_id', 'sysable_type']);
        });  
        
        /**
         * weather_snows
         */
        \Schema::table($this->snows, function(Blueprint $t) {
            
            $t->index(['snowable_id', 'snowable_type']);
        });
        
        /**
         * weather_lists
         */
        \Schema::table($this->lists, function(Blueprint $t) {
            
            $t->index(['listable_id', 'listable_type']);
        });
        
//        /**
//         * weather_condition_ables
//         */
//        \Schema::table($this->conditions, function(Blueprint $t) {
//            
//            $t->index(['weather_condition_able_id', 'weather_condition_id', 'weather_condition_able_type']);
//        });
        
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::table($this->clouds, function(Blueprint $t) {
            
            $t->dropIndex(['cloudsable_id', 'cloudsable_type']);
        });
        
        \Schema::table($this->winds, function(Blueprint $t) {
            
            $t->dropIndex(['windable_id', 'windable_type']);
        });
        
        \Schema::table($this->rains, function(Blueprint $t) {
            
            $t->dropIndex(['rainable_id', 'rainable_type']);
        });
        
        \Schema::table($this->mains, function(Blueprint $t) {
            
            $t->dropIndex(['mainable_id', 'mainable_type']);
        });
        
               
        \Schema::table($this->sys, function(Blueprint $t) {
            
            $t->dropIndex(['sysable_id', 'sysable_type']);
        }); 
        
        \Schema::table($this->snows, function(Blueprint $t) {
            
            $t->dropIndex(['snowable_id', 'snowable_type']);
        });
        
        \Schema::table($this->lists, function(Blueprint $t) {
            
            $t->dropIndex(['listable_id', 'listable_type']);
        });
        
//        \Schema::table($this->conditions, function(Blueprint $t) {
//            
//            $t->dropIndex(['weather_condition_able_id', 'weather_condition_id', 'weather_condition_able_type']);
//        });
    }
}
