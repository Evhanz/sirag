<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/','WelcomeController@index');


/*empieza las rutas par alos reportes de comercial*/
Route::get('comercial/',['as'=>'modComercial']);
Route::get('comercial/rep/viewDocumentos',['as'=>'viewDocumentos','uses'=>'ComercialController@viewDocumentos']);
Route::get('comercial/rep/viewRepProductos',['as'=>'viewRepProductos','uses'=>'ComercialController@viewRepProductos']);
Route::get('comercial/rep/viewOrdenCompra',['as'=>'viewOrdenCompra','uses'=>'ComercialController@viewOrdenCompra']);


/*API para treer todos los documentos de acuerdos a sus parametros*/
Route::post('comercial/ap/getDocsByParameters',['as'=>'api_getDocsByParameters',
    'uses'=>'ComercialController@getAllDocumentosByParameters']);
Route::get('comercial/api/getDetalByIdDoc/{id}',['as'=>'api_getDetalByIdDoc',
    'uses'=>'ComercialController@getDetalleByIdDoc']);
Route::get('comercial/api/getAllTipoDocumentos',['as'=>'api_getAllTipoDocumentos',
    'uses'=>'ComercialController@getAllDocumentos']);

/*API  para los proveedores*/
Route::post('comercial/api/getProveedoresByRazonAndRUC',['as'=>'getProveedoresByRazonAndRUC',
    'uses'=>'ComercialController@getProveedoresByRazonAndRUC']);
Route::get('comercial/api/getProductosComercioProveedor/{ruc}',['as'=>'getProductosComercioProveedor',
    'uses'=>'ComercialController@getProductosComercioProveedor']);

//API PARA TRAER LOS REPORTES DE LAS FAMILIAS Y PROCDUCTO POR FILTRO
Route::get('comercial/api/getAllFamilias',['as'=>'getAllFamilias','uses'=>'ComercialController@getAllFamilias']);
Route::get('comercial/api/getAllSubFamilias',['as'=>'getAllSubFamilias','uses'=>'ComercialController@getAllSubFamilias']);
Route::post('comercial/api/getAllProductosByProveedor',['as'=>'getAllProductosByProveedor',
    'uses'=>'ComercialController@getAllProductosByProveedor']);
Route::post('comercial/api/getDetailProductoCompra',['as'=>'getDetailProductoCompra',
    'uses'=>'ComercialController@getDetailProductoCompra']);

//API para traer a las ordenes de compra
Route::post('comercial/api/getOrdenesCompra',['as'=>'getOrdenesCompra','uses'=>'ComercialController@getOrdenesCompra']);
Route::get('comercial/api/getDetailOrden/{id}',['as'=>'getDetailOrden','uses'=>'ComercialController@getDetailOrden']);




//------ llamada a las views de rh
Route::get('rh/',['as'=>'modRH']);
Route::get('rh/rep/viewPersonal',['as'=>'viewPersonal','uses'=>'RecursoshController@viewPersonal']);


//----para traer todos los trabajadores
Route::post('rh/api/getAllTrabajadoresByParameter',['as'=>'getAllTrabajadoresByParameter',
    'uses'=>'RecursoshController@getAllTrabajadoresByParameter']);
Route::post('rh/api/getTrabajadoresByParamOutDates',['as'=>'getTrabajadoresByParamOutDates',
    'uses'=>'RecursoshController@getTrabajadoresByParamOutDates']);


/*para imprimir pdf*/
Route::get('comercial/pdf/getPDFProductProveedor/{glosa}/{subfamilia}/{familia}',['as'=>'getPDFProductProveedor',
    'uses'=>'ComercialController@getPDFProductProveedor']);


//para rutinas de emergencia

Route::get('rutina/changeProveedores',['as'=>'changeProveedores',
    'uses'=>'RutinaController@changeProveedores']);