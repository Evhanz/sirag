<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 21/10/2016
 * Time: 05:17 PM
 */



/*empieza las rutas par alos reportes de comercial*/
Route::get('comercial/',['as'=>'modComercial']);
Route::get('comercial/rep/viewDocumentos',['as'=>'viewDocumentos','uses'=>'ComercialController@viewDocumentos']);
Route::get('comercial/rep/viewRepProductos',['as'=>'viewRepProductos','uses'=>'ComercialController@viewRepProductos']);
Route::get('comercial/rep/viewOrdenCompra',['as'=>'viewOrdenCompra','uses'=>'ComercialController@viewOrdenCompra']);
Route::get('comercial/rep/viewControlOrdenCompraComercial',['as'=>'viewControlOrdenCompraComercial','uses'=>'ComercialController@viewControlOrdenCompra']);
Route::get('comercial/rep/viewKardex',['as'=>'viewKardex','uses'=>'ComercialController@viewKardex']);
Route::get('comercial/rep/viewConsumoByFundo',['as'=>'viewConsumoByFundoComercial','uses'=>'ComercialController@viewConsumoByFundoComercial']);
Route::get('comercial/rep/viewSeguimientoGuia',['as'=>'viewSeguimientoGuia','uses'=>'ComercialController@viewSeguimientoGuia']);


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
Route::post('comercial/api/apiGetKardex',['as'=>'api_getKardex','uses'=>'ComercialController@getKardex']);
Route::post('comercial/api/getGuiaFaltaFactura',['as'=>'getGuiaFaltaFactura','uses'=>'ComercialController@getGuiaFaltaFactura']);



//esta ruta se comparte con contabilidad
Route::post('contabilidad/api/getOrdenCompraForControl',['as'=>'getOrdenCompraForControl',
    'uses'=>'ContabilidadController@getOrdenCompraForControl']);

//rutas para reportes excel
Route::post('comercial/excel/ControlOrdenCompraComercial',['as'=>'excelControlOrdenCompraComercial',
    'uses'=>'ComercialController@excelControlOrdenCompraComercial']);
Route::post('comercial/excel/consumoPorCCI',['as'=>'excelConsumoPorCCI',
    'uses'=>'ComercialController@excelConsumoPorCCI']);
Route::post('comercial/excel/getExcelRequerimiento',['as'=>'getExcelRequerimiento',
    'uses'=>'ComercialController@getExcelRequerimiento']);


