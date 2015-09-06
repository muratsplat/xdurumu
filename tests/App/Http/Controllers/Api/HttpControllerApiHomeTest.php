<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
//use Illuminate\Foundation\Testing\DatabaseTransactions;

//use Mockery as m;


/**
 * This test file is written for 'App\Http\Controllers\Api\City' Controller
 * 
 */
class HttpControllerApiHomeTest extends TestCase
{
    
   // use WithoutMiddleware;
    
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {                       
        $res = $this->action('GET', 'Api\Home@index');
        
        $this->assertResponseStatus(302);
        
        $this->assertRedirectedTo('http://durumum.dev');        
    }
    
    
    
}
