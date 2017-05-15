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

//apis
Route::post('packing/pallet/regPallet',['as'=>'regPallet','uses'=>'Packing\PalletController@regPallet']);
Route::post('packing/pallet/editPallet',['as'=>'editPallet','uses'=>'Packing\PalletController@editPallet']);
Route::get('packing/pallet/getPallet/{id}',['as'=>'getPalletById','uses'=>'Packing\PalletController@getPalletById']);
Route::get('packing/pallet/getDetailsPallet/{id}',['as'=>'getPalletById','uses'=>'Packing\PalletController@getDetailsPallet']);
