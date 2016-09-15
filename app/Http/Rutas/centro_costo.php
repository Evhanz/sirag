<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 14/09/2016
 * Time: 05:41 PM
 */

//------ llamada a las views de rh ----------------- RH
Route::get('cc/',['as'=>'modCC']);
Route::get('cc/rep/viewSaldoCCByCuentaAndPeriodo',['as'=>'viewCentroCosto','uses'=>'CentroCostoController@viewSaldoCCByCuentaAndPeriodo']);

//------ API

Route::post('cc/api/getSaldoCCByCuentaAndPeriodo',['as'=>'getSaldoCCByCuentaAndPeriodo',
    'uses'=>'CentroCostoController@getSaldoCCByCuentaAndPeriodo']);