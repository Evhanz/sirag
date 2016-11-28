<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 28/11/16
 * Time: 04:14 PM
 */


Route::get('packing/inicio',['as'=>'inicioPacking','uses'=>'Packing\InicioController@index']);