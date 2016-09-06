<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 02/09/2016
 * Time: 10:03 AM
 */

//------ llamada a las views de rh ----------------- RH
Route::get('rh/',['as'=>'modRH']);
Route::get('rh/rep/viewPersonal',['as'=>'viewPersonal','uses'=>'RecursoshController@viewPersonal']);
Route::get('rh/rep/HistorialContrato/{ficha}',['as'=>'viewHistoryContract','uses'=>'RecursoshController@viewHistoryContract']);
Route::post('rh/addNewRenovacion',['as'=>'addNewRenovacion','uses'=>'RecursoshController@addNewRenovacion']);


//llamada a API
Route::get('rh/api/getTrabajadorBy/{ficha}',['as'=>'getTrabajadorByFicha','uses'=>'RecursoshController@getTrabajadorByFicha']);
Route::get('rh/api/getContratos/{ficha}',['as'=>'getContratos','uses'=>'RecursoshController@getContratos']);
Route::get('rh/api/getRenovacionesByFicha/{ficha}',['as'=>'getRenovacionesByFicha','uses'=>'RecursoshController@getRenovacionesByFicha']);

