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
Route::get('/',['as'=>'home','uses'=>'WelcomeController@index']); //ruta de inicio

Route::group(['middleware' => 'roles','roles'=>['Admin','COMERCIAL']], function () {
    require __DIR__ . '/Rutas/comercial.php';
});

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


/*Estas son de Recursos Humanos*/

Route::group(['middleware' => 'roles','roles'=>['ADMIN','RH']], function () {
    require __DIR__ . '/Rutas/recursos_humanos.php';
});



/*Estas dos son de contabilidad*/
Route::group(['middleware' => 'roles','roles'=>['ADMIN','CONTABILIDAD']], function () {
    require __DIR__ . '/Rutas/centro_costo.php';
    require __DIR__ . '/Rutas/contabilidad.php';
});



//----para traer todos los trabajadores
Route::post('rh/api/getAllTrabajadoresByParameter',['as'=>'getAllTrabajadoresByParameter',
    'uses'=>'RecursoshController@getAllTrabajadoresByParameter']);
Route::post('rh/api/getTrabajadoresByParamOutDates',['as'=>'getTrabajadoresByParamOutDates',
    'uses'=>'RecursoshController@getTrabajadoresByParamOutDates']);


/*para imprimir pdf*/
Route::get('comercial/pdf/getPDFProductProveedor/{glosa}/{subfamilia}/{familia}',['as'=>'getPDFProductProveedor',
    'uses'=>'ComercialController@getPDFProductProveedor']);


//para rutinas de emergencia // no usar

/*

Route::get('rutina/changeProveedores',['as'=>'changeProveedores',
    'uses'=>'RutinaController@changeProveedores']);*/


/*para los usuarios ----------------------*/

Route::get('administracion/usuarios',['as'=>'usuarios','uses'=>'AdministracionUserController@index']);

//para el login
Route::resource('log','LogController');
Route::get('inicio',['as'=>'inicio','uses'=>'AdministracionUserController@inicio']);
Route::get('outLogin',['as'=>'outLogin','uses'=>'LogController@logOut']);


//pruebas de inicio de sesion

Route::group(['middleware' => 'roles','roles'=>'ADMIN'], function () {
    Route::get('prueba/user',function (){
        echo "Bienvenido Usuario";
    });
});

//para lo de la adminsitracion de roles

Route::group(['middleware' => 'roles','roles'=>['ADMIN']], function () {
    require __DIR__ . '/Rutas/usuarios.php';
});


//aqui empieza packing
require __DIR__ . '/Rutas/packing/inicio.php';

