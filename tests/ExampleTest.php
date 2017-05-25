<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {

        /*
        $this->visit('/')
             ->see('Laravel 5');*/

       $nombre =  \sirag\Helpers\NumberToLetter::convert('2.12');
       echo $nombre;
    }
}
