<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 28/11/16
 * Time: 04:14 PM
 */


Route::get('packing/inicio',['as'=>'inicioPacking','uses'=>'Packing\InicioController@index']);

//esto va a ser para colocar el calibre y el tipo de caja en los pallets
Route::get('packing/inicio/getOpcionesGenerales/{tipo}',['as'=>'getOpcionesGenerales',
    'uses'=>'Packing\InicioController@getOpcionesGenerales']);