<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 19/04/2017
 * Time: 10:11 AM
 */

Route::get('packing/etapa/reg',['as'=>'viewEtapa','uses'=>'Packing\EtapaController@viewEtapaReg']);
Route::get('packing/etapa/get/{id}',['as'=>'viewEtapaEdit','uses'=>'Packing\EtapaController@viewEdit']);
Route::get('packing/etapa/viewAll',['as'=>'viewEtapaAll','uses'=>'Packing\EtapaController@viewAllEtapa']);

//inserts
Route::post('packing/etapa/reg',
    ['as'=>'apiSeleccionReg','uses'=>'Packing\EtapaController@apiSeleccionReg']);
Route::post('packing/etapa/editar',
    ['as'=>'apiSeleccionEdit','uses'=>'Packing\EtapaController@apiSeleccionEdit']);

