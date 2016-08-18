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


/*empieza las rutas par alos reportes de comercil*/
Route::get('comercial/',['as'=>'modComercial']);
Route::get('comercial/rep/viewDocumentos',['as'=>'viewDocumentos','uses'=>'ComercialController@viewDocumentos']);
Route::get('comercial/rep/viewRepProductos',['as'=>'viewRepProductos','uses'=>'ComercialController@viewRepProductos']);


/*API para treer todos los documentos de acuerdos a sus parametros*/
Route::post('comercial/ap/getDocsByParameters',['as'=>'api_getDocsByParameters',
    'uses'=>'ComercialController@getAllDocumentosByParameters']);
Route::get('comercial/api/getDetalByIdDoc/{id}',['as'=>'api_getDetalByIdDoc',
    'uses'=>'ComercialController@getDetalleByIdDoc']);
Route::get('comercial/api/getAllTipoDocumentos',['as'=>'api_getAllTipoDocumentos',
    'uses'=>'ComercialController@getAllDocumentos']);

//API PARA TRAER LOS REPORTES DE LAS FAMILIAS Y PROCDUCTO POR FILTRO
Route::get('comercial/api/getAllFamilias',['as'=>'getAllFamilias','uses'=>'ComercialController@getAllFamilias']);
Route::get('comercial/api/getAllSubFamilias',['as'=>'getAllSubFamilias','uses'=>'ComercialController@getAllSubFamilias']);
Route::post('comercial/api/getAllProductosByProveedor',['as'=>'getAllProductosByProveedor',
    'uses'=>'ComercialController@getAllProductosByProveedor']);
Route::post('comercial/api/getDetailProductoCompra',['as'=>'getDetailProductoCompra',
    'uses'=>'ComercialController@getDetailProductoCompra']);