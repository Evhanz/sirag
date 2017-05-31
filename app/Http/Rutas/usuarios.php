<?php


Route::get('user',['as'=>'modUser']);

Route::get('user/api/getAllUsersAndRoles',['as'=>'getAllUsersAndRoles',
    'uses'=>'AdministracionUserController@getAllUsersAndRoles']);

Route::get('user/view/getViewAdminUsuarios',['as'=>'getViewAdminUsuarios','uses'=>'AdministracionUserController@getViewAdminUsuarios']);
Route::post('user/updateRoles',['as'=>'updateRolesUsuarios','uses'=>'AdministracionUserController@updateRolesUsuarios']);



Route::get('user/api/getModulosAndSubModulos',['as'=>'getModulosAndSubModulos',
    'uses'=>'AdministracionUserController@getModulosAndSubModulos']);
Route::get('user/api/changeModulo/{idModulo}/{usr}/{tipo}',['as'=>'apiChangeModulo','uses'=>'AdministracionUserController@apiChangeModulo']);
Route::get('user/api/getModulesOfUser/{usr}',['as'=>'apiGetModulesOfUser','uses'=>'AdministracionUserController@getAllAccesos']);

