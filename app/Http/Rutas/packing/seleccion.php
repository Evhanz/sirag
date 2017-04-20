<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 19/04/2017
 * Time: 10:11 AM
 */

Route::get('packing/etapa/seleccion/reg',['as'=>'viewSeleccionReg','uses'=>'Packing\EtapaController@viewSeleccionReg']);

//inserts
Route::post('packing/etapa/seleccion/reg',
    ['as'=>'apiSeleccionReg','uses'=>'Packing\EtapaController@apiSeleccionReg']);