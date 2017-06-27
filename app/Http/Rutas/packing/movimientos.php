<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 21/06/2017
 * Time: 10:21 AM
 */

Route::get('packing/movimiento/viewMantMovimientosPallet', ['as'=>'viewMantMovimientosPallet',
    'uses'=>'Packing\MovimientosPalletController@viewMantMovimientosPallet']);
Route::post('packing/movimiento/insertOrUpdateMovimiento',['as'=>'insertOrUpdateMovimientoPallet',
    'uses'=>'Packing\MovimientosPalletController@insertOrUpdateMovimiento']);
Route::post('packing/movimiento/getPalletByCodigoMovimiento',['as'=>'getPalletByCodigoMovimiento',
    'uses'=>'Packing\MovimientosPalletController@getPalletByCodigoMovimiento']);
Route::post('packing/movimiento/viewMantMovimientosPallet',['as'=>'getMovimientosPalletParams',
    'uses'=>'Packing\MovimientosPalletController@getMovimientosPalletParams']);