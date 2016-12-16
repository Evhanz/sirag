<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 21/10/2016
 * Time: 05:17 PM
 */



Route::group(['middleware' => 'roles','roles'=>['ADMIN','CONTABILIDAD']], function () {
    /*empieza las rutas par alos reportes de comercial*/
    //aca solo estas las vistas
    Route::get('comercial/',['as'=>'modComercial']);
    Route::get('comercial/rep/viewDocumentos',['as'=>'viewDocumentos','uses'=>'ComercialController@viewDocumentos']);
    Route::get('comercial/rep/viewRepProductos',['as'=>'viewRepProductos','uses'=>'ComercialController@viewRepProductos']);
    Route::get('comercial/rep/viewOrdenCompra',['as'=>'viewOrdenCompra','uses'=>'ComercialController@viewOrdenCompra']);
    Route::get('comercial/rep/viewControlOrdenCompraComercial',['as'=>'viewControlOrdenCompraComercial','uses'=>'ComercialController@viewControlOrdenCompra']);
    Route::get('comercial/rep/viewKardex',['as'=>'viewKardex','uses'=>'ComercialController@viewKardex']);
});





/*API para treer todos los documentos de acuerdos a sus parametros*/
Route::post('comercial/ap/getDocsByParameters',['as'=>'api_getDocsByParameters',
    'uses'=>'ComercialController@getAllDocumentosByParameters']);
Route::get('comercial/api/getDetalByIdDoc/{id}',['as'=>'api_getDetalByIdDoc',
    'uses'=>'ComercialController@getDetalleByIdDoc']);
Route::get('comercial/api/getAllTipoDocumentos',['as'=>'api_getAllTipoDocumentos',
    'uses'=>'ComercialController@getAllDocumentos']);
Route::post('comercial/api/getKardexSalida',['as'=>'api_getKardexSalida',
    'uses'=>'ComercialController@apiGetKardexSalida']);
Route::post('comercial/api/getKardexEntrada',['as'=>'api_getKardexEntrada',
    'uses'=>'ComercialController@apiGetKardexEntrada']);
Route::post('comercial/api/apiGetKardex',['as'=>'api_getKardex',
    'uses'=>'ComercialController@getKardex']);

//esta ruta se comparte con contabilidad
Route::post('contabilidad/api/getOrdenCompraForControl',['as'=>'getOrdenCompraForControl',
    'uses'=>'ContabilidadController@getOrdenCompraForControl']);