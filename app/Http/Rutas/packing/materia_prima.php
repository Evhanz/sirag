<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 01/12/16
 * Time: 06:01 PM
 */

Route::get('packing/materiaPrima/index',['as'=>'inicioPMateriaPrima','uses'=>'Packing\MateriaPrimaController@index']);
Route::get('packing/viewStore',
    ['as'=>'viewStorePMateriaPrima','uses'=>'Packing\MateriaPrimaController@viewStorePMateriaPrima']);

//api
Route::get('packing/materiaPrima/getAllMteriaPrima',
    ['as'=>'getAllMteriaPrima','uses'=>'Packing\MateriaPrimaController@getAllMteriaPrima']);
Route::get('packing/materiaPrima/get',
    ['as'=>'inicioPacking','uses'=>'Packing\MateriaPrimaController@index']);

//  esto es un api externaa  se usó para no tener
//  problemas con el acceso a compartir rutas
//  y usar rutas independientes por módulos

Route::get('packing/materiaPrima/getTrabajadores',
    ['as'=>'getTrabajadores','uses'=>'Packing\MateriaPrimaController@getTrabajadores']);


