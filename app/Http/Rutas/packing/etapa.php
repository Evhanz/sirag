<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 19/04/2017
 * Time: 10:11 AM
 */

Route::get('packing/etapa/reg',['as'=>'viewNewEtapa','uses'=>'Packing\EtapaController@viewEtapaReg']);
Route::get('packing/etapa/getById/{id}',['as'=>'viewEtapaEdit','uses'=>'Packing\EtapaController@viewEdit']);
Route::get('packing/etapa/viewAll',['as'=>'viewEtapaAll','uses'=>'Packing\EtapaController@viewAllEtapa']);
Route::get('packing/etapa/getEtapaByParameter',['as'=>'getEtapaByParameter','uses'=>'Packing\EtapaController@getEtapaByParameter']);

//inserts
Route::post('packing/etapa/reg',
    ['as'=>'apiSeleccionReg','uses'=>'Packing\EtapaController@apiSeleccionReg']);
Route::post('packing/etapa/editar',
    ['as'=>'apiSeleccionEdit','uses'=>'Packing\EtapaController@apiSeleccionEdit']);
//api
Route::get('packing/etapa/api/getById/{id}',['as'=>'apiGetEtapaById','uses'=>'Packing\EtapaController@apiGetById']);

Route::get('packing/etapa/api/getByCodigo/{codigo}',['as'=>'apiGetByCodigo','uses'=>'Packing\EtapaController@apiGetByCodigo']);
Route::get('packing/etapa/api/getEmpleadoByFichaTipo/{ficha}/{tipo}',
    ['as'=>'getEmpleadoByFichaTipo','uses'=>'Packing\EtapaController@getEmpleadoByFichaTipo']);

