<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 10/05/2017
 * Time: 11:22 AM
 */

Route::get('packing/pallet/viewReg',['as'=>'viewNewPallet','uses'=>'Packing\PalletController@viewNewPallet']);
Route::get('packing/pallet/viewEdit',['as'=>'viewEditPallet','uses'=>'Packing\PalletController@viewEdit']);
Route::get('packing/pallet/viewAll',['as'=>'viewAllPallet','uses'=>'Packing\PalletController@viewAll']);
Route::get('packing/pallet/viewPalletRep',['as'=>'viewPalletRep','uses'=>'Packing\PalletController@viewPalletRep']);

//apis
Route::post('packing/pallet/regPallet',['as'=>'regPallet','uses'=>'Packing\PalletController@regPallet']);
Route::post('packing/pallet/editPallet',['as'=>'editPallet','uses'=>'Packing\PalletController@editPallet']);
Route::get('packing/pallet/getPallet/{id}',['as'=>'getPalletById','uses'=>'Packing\PalletController@getPalletById']);
Route::get('packing/pallet/getDetailsPallet/{id}',['as'=>'getPalletById','uses'=>'Packing\PalletController@getDetailsPallet']);
Route::get('packing/pallet/getPalletBy/{codigo}',['as'=>'getPalletByCodigo','uses'=>'Packing\PalletController@getPalletByCodigo']);
Route::get('packing/pallet/getAllPalletPaginate',['as'=>'getAllPalletPaginate','uses'=>'Packing\PalletController@getAllPalletPaginate']);
Route::get('packing/pallet/getCountNowPallet',['as'=>'getCountNowPallet','uses'=>'Packing\PalletController@getCountNowPallet']);
Route::get('packing/pallet/getPalletPaginateByFechas/{f_i?}/{f_f?}',['as'=>'getAllPalletPaginateFechas'
    ,'uses'=>'Packing\PalletController@getAllPalletPaginateFechas']);
Route::post('packing/pallet/getPalletByCodigoWithDetails',['as'=>'getPalletByCodigoWithDetails',
    'uses'=>'Packing\PalletController@getPalletByCodigoWithDetails']);
Route::post('packing/pallet/getPalletByFechas',['as'=>'getPalletByFechas'
    ,'uses'=>'Packing\PalletController@getPalletByFechas']);

//excel
