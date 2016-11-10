<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 14/09/2016
 * Time: 05:41 PM
 */

//------ llamada a las views de contabiidad ----------------- contabilidad
Route::get('contabilidad/',['as'=>'modContabilidad']);
Route::get('contabilidad/rep/viewSaldoCCByCuentaAndPeriodo',['as'=>'viewCentroCosto','uses'=>'CentroCostoController@viewSaldoCCByCuentaAndPeriodo']);
Route::get('contabilidad/rep/viewBalanceGeneral',
	['as'=>'viewBalanceGeneral','uses'=>'ContabilidadController@viewBalanceGeneral']);
Route::get('contabilidad/rep/viewControlOrdenCompra',
	['as'=>'viewControlOrdenCompra','uses'=>'ContabilidadController@viewControlOrdenCompra']);
Route::get('contabilidad/rep/viewPDB',['as'=>'viewPDB','uses'=>'ContabilidadController@viewPDB']);
Route::get('contabilidad/rep/viewConsumoByFundo',['as'=>'viewConsumoByFundo','uses'=>'ContabilidadController@viewConsumoByFundo']);



//------ API

Route::post('contabilidad/api/getBalanceByNiveles',['as'=>'getBalanceByNivelesApi',
    'uses'=>'ContabilidadController@getBalanceByNiveles']);
/* se comento por que lo compartes con comercial
Route::post('contabilidad/api/getOrdenCompraForControl',['as'=>'getOrdenCompraForControl',
    'uses'=>'ContabilidadController@getOrdenCompraForControl']);*/
Route::post('contabilidad/api/getGuiasAtendidasOfOC',['as'=>'getGuiasAtendidasOfOC',
    'uses'=>'ContabilidadController@getGuiasAtendidasOfOC']);

Route::get('contabilidad/api/getFamiliasProductos',['as'=>'getFamiliasProductos','uses'=>'ContabilidadController@getFamiliasProductos']);
Route::get('contabilidad/api/getAllSubFamiliasProductos',['as'=>'getAllSubFamiliasProductos','uses'=>'ContabilidadController@getAllSubFamiliasProductos']);

Route::get('contabilidad/api/getAllInitDataConsumoReporte',['as'=>'getAllInitDataConsumoReporte','uses'=>'ContabilidadController@getAllInitDataConsumoReporte']);

Route::get('contabilidad/api/getParronByFundo/{fundo}',['as'=>'getParronByFundo','uses'=>'ContabilidadController@getParronByFundo']);

Route::post('contabilidad/sendDataForExcelConsumo',['as'=>'sendDataForExcelConsumo','uses'=>'ContabilidadController@sendDataForExcelConsumo']);




// ----- para los txt

Route::post('contabilidad/txt/pdbTxtCompras',['as'=>'pdbTxtCompras','uses'=>'ContabilidadController@pdbTxtCompras']);
Route::get('contabilidad/txt/getPdbTxtCompras/{periodo}',['as'=>'getPdbTxtCompras','uses'=>'ContabilidadController@getTxtCompras']);
Route::post('contabilidad/txt/pdbTxtVentas',['as'=>'pdbTxtVentas','uses'=>'ContabilidadController@pdbTxtVentas']);
Route::get('contabilidad/txt/getPdbTxtVentas/{periodo}',['as'=>'getPdbTxtVentas','uses'=>'ContabilidadController@getTxtVentas']);
Route::post('contabilidad/txt/getTipoCambio',['as'=>'getTipoCambio','uses'=>'ContabilidadController@getTipoCambio']);
Route::get('contabilidad/txt/getTxtTipoCambio',['as'=>'getTxtTipoCambio','uses'=>'ContabilidadController@getTxtTipoCambio']);



//----- para los excel
Route::get('contabilidad/excel/pdbExcelCompras/{periodo}',['as'=>'pdbExcelCompras','uses'=>'ContabilidadController@pdbExcelCompras']);

Route::get('contabilidad/excel/getExcelConsumoByFundo',['as'=>'getExcelConsumoByFundo','uses'=>'ContabilidadController@getExcelConsumoByFundo']);