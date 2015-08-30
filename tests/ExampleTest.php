<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
//use Illuminate\Foundation\Testing\DatabaseTransactions;

use GuzzleHttp\Client;


class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->visit('/')
             ->see('durumum.NET');
    }
    
    public function testSimpleGuzzleTest()
    {        
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://google.com.tr',
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);

        $response = $client->get('https://www.google.com.tr');
        
        $this->assertTrue($response->getStatusCode() === 200);        
    }   
    
}
