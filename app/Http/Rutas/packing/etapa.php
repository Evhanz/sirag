<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 19/04/2017
 * Time: 10:11 AM
 */

Route::get('packing/etapa/reg',['as'=>'viewEtapa','uses'=>'Packing\EtapaController@viewEtapaReg']);

//inserts
Route::post('packing/etapa/reg',
    ['as'=>'apiSeleccionReg','uses'=>'Packing\EtapaController@apiSeleccionReg']);

