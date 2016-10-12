<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 14/09/2016
 * Time: 05:41 PM
 */

//------ llamada a las views de rh ----------------- RH
Route::get('contabilidad/',['as'=>'modContabilidad']);
Route::get('contabilidad/rep/viewSaldoCCByCuentaAndPeriodo',['as'=>'viewCentroCosto','uses'=>'CentroCostoController@viewSaldoCCByCuentaAndPeriodo']);
Route::get('contabilidad/rep/viewBalanceGeneral',
	['as'=>'viewBalanceGeneral','uses'=>'ContabilidadController@viewBalanceGeneral']);

//------ API

Route::post('contabilidad/api/getBalanceByNiveles',['as'=>'getBalanceByNivelesApi',
    'uses'=>'ContabilidadController@getBalanceByNiveles']);