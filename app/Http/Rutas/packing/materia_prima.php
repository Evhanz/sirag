<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 01/12/16
 * Time: 06:01 PM
 */

Route::get('packing/materiaPrima/index',['as'=>'inicioPMateriaPrima','uses'=>'Packing\MateriaPrimaController@index']);
Route::get('packing/materiaPrima/viewStore',
    ['as'=>'viewStorePMateriaPrima','uses'=>'Packing\MateriaPrimaController@viewStorePMateriaPrima']);
Route::get('packing/materiaPrima/viewAllMP',
    ['as'=>'viewAllMP','uses'=>'Packing\MateriaPrimaController@viewAllMP']);
Route::get('packing/materiaPrima/Get/{id}',
    ['as'=>'viewEditIMP','uses'=>'Packing\MateriaPrimaController@viewEditIMP']);

Route::post('packing/materiaPrima/viewAllMP',
    ['as'=>'viewAllMPPrameters','uses'=>'Packing\MateriaPrimaController@viewAllMPPrameters']);

//api
Route::get('packing/materiaPrima/getAllMteriaPrima',
    ['as'=>'getAllMteriaPrima','uses'=>'Packing\MateriaPrimaController@getAllMteriaPrima']);
Route::get('packing/materiaPrima/get',
    ['as'=>'inicioPacking','uses'=>'Packing\MateriaPrimaController@index']);
Route::post('packing/materiaPrima/storeNew',
    ['as'=>'materiaPrimaStoreNew','uses'=>'Packing\MateriaPrimaController@materiaPrimaStoreNew']);
Route::get('packing/materiaPrima/api/getIMPById/{id}',
    ['as'=>'apiGetIMPById','uses'=>'Packing\MateriaPrimaController@getIMPById']);
Route::post('packing/materiaPrima/updateIMP',
    ['as'=>'updateIMP','uses'=>'Packing\MateriaPrimaController@updateIMP']);

//  esto es un api externaa  se usó para no tener
//  problemas con el acceso a compartir rutas
//  y usar rutas independientes por módulos

Route::get('packing/materiaPrima/getTrabajadores',
    ['as'=>'getTrabajadores','uses'=>'Packing\MateriaPrimaController@getTrabajadores']);


