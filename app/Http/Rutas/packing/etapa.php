<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 19/04/2017
 * Time: 10:11 AM
 */
Route::get('packing/',['as'=>'modPacking']);
Route::get('packing/etapa/reg',['as'=>'viewNewEtapa','uses'=>'Packing\EtapaController@viewEtapaReg']);
Route::get('packing/etapa/getById/{id}',['as'=>'viewEtapaEdit','uses'=>'Packing\EtapaController@viewEdit']);
Route::get('packing/etapa/viewAll',['as'=>'viewEtapaAll','uses'=>'Packing\EtapaController@viewAllEtapa']);
Route::get('packing/etapa/getEtapaByParameter',['as'=>'getEtapaByParameter','uses'=>'Packing\EtapaController@getEtapaByParameter']);
Route::get('packing/etapa/viewEtapaRep',['as'=>'viewEtapaRep','uses'=>'Packing\EtapaController@viewEtapaRep']);
Route::get('packing/etapa/viewEtapaByCodigo/{codigo}',['as'=>'viewEtapaByCodigo','uses'=>'Packing\EtapaController@viewEtapaByCodigo']);
Route::get('packing/etapa/viewConfigEtiquetas',['as'=>'viewConfigEtiquetas','uses'=>'Packing\EtapaController@viewConfigEtiquetas']);



//inserts
Route::post('packing/etapa/reg',
    ['as'=>'apiSeleccionReg','uses'=>'Packing\EtapaController@apiSeleccionReg']);
Route::post('packing/etapa/editar',
    ['as'=>'apiSeleccionEdit','uses'=>'Packing\EtapaController@apiSeleccionEdit']);
Route::post('packing/etapa/regCodigoCaja',
    ['as'=>'regCodigoCaja','uses'=>'Packing\EtapaController@regCodigoCaja']);

//api
Route::get('packing/etapa/api/getById/{id}',['as'=>'apiGetEtapaById','uses'=>'Packing\EtapaController@apiGetById']);
Route::get('packing/etapa/api/getByCodigoPallet/{codigo}',['as'=>'apiGetEtapaByCodigoPallet'
    ,'uses'=>'Packing\EtapaController@apiGetEtapaByCodigoPallet']);
Route::get('packing/etapa/api/getByCodigo/{codigo}/{opcion}',['as'=>'apiGetByCodigo','uses'=>'Packing\EtapaController@apiGetByCodigo']);
Route::get('packing/etapa/api/getEmpleadoByFichaTipo/{ficha}/{tipo}',
    ['as'=>'getEmpleadoByFichaTipo','uses'=>'Packing\EtapaController@getEmpleadoByFichaTipo']);

