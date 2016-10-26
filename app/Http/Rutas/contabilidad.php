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



//------ API

Route::post('contabilidad/api/getBalanceByNiveles',['as'=>'getBalanceByNivelesApi',
    'uses'=>'ContabilidadController@getBalanceByNiveles']);
/* se comento por que lo compartes con comercial
Route::post('contabilidad/api/getOrdenCompraForControl',['as'=>'getOrdenCompraForControl',
    'uses'=>'ContabilidadController@getOrdenCompraForControl']);*/
Route::post('contabilidad/api/getGuiasAtendidasOfOC',['as'=>'getGuiasAtendidasOfOC',
    'uses'=>'ContabilidadController@getGuiasAtendidasOfOC']);

// ----- para los txt

Route::post('contabilidad/txt/pdbTxtCompras',['as'=>'pdbTxtCompras','uses'=>'ContabilidadController@pdbTxtCompras']);
Route::get('contabilidad/txt/getPdbTxtCompras/{periodo}',['as'=>'getPdbTxtCompras','uses'=>'ContabilidadController@getTxtCompras']);

//----- para los excel
