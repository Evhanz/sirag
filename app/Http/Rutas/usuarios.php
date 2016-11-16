<?php

Route::get('user/api/getAllUsersAndRoles',['as'=>'getAllUsersAndRoles',
    'uses'=>'AdministracionUserController@getAllUsersAndRoles']);

Route::get('user/view/getViewAdminUsuarios',['as'=>'getViewAdminUsuarios','uses'=>'AdministracionUserController@getViewAdminUsuarios']);
Route::post('user/updateRoles',['as'=>'updateRolesUsuarios','uses'=>'AdministracionUserController@updateRolesUsuarios']);


