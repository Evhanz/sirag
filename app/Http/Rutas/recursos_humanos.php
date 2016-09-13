<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 02/09/2016
 * Time: 10:03 AM
 */

//------ llamada a las views de rh ----------------- RH
Route::get('rh/',['as'=>'modRH']);
Route::get('rh/rep/viewPersonal',['as'=>'viewPersonal','uses'=>'RecursoshController@viewPersonal']);
Route::get('rh/rep/HistorialContrato/{ficha}',['as'=>'viewHistoryContract','uses'=>'RecursoshController@viewHistoryContract']);
Route::post('rh/addNewRenovacion',['as'=>'addNewRenovacion','uses'=>'RecursoshController@addNewRenovacion']);
Route::post('rh/deleteRenovacion',['as'=>'deleteRenovacion','uses'=>'RecursoshController@deleteRenovacion']);


//llamada a API
Route::get('rh/api/getTrabajadorBy/{ficha}',['as'=>'getTrabajadorByFicha','uses'=>'RecursoshController@getTrabajadorByFicha']);
Route::get('rh/api/getContratos/{ficha}',['as'=>'getContratos','uses'=>'RecursoshController@getContratos']);
Route::get('rh/api/getRenovacionesByFicha/{ficha}',['as'=>'getRenovacionesByFicha','uses'=>'RecursoshController@getRenovacionesByFicha']);
Route::get('rh/api/getVacacionesByFicha/{ficha}',['as'=>'getVacacionesByFicha','uses'=>'RecursoshController@getVacacionesByFicha']);

//solo pruebas
Route::get('pruebas',function (){


    $data['body'] = "prueba de contenido";


    //se envia el array y la vista lo recibe en llaves individuales {{ $email }} , {{ $subject }}...
    \Mail::send('email', $data, function($message)
    {
        //remitente
        $message->from('ehernandez@agrograce.com.pe', 'Sistema Sirag');

        //asunto
        $message->subject('Contratos por vencer');

        //receptor
        $message->to('eidelhs@gmail.com','Eidelman ');

    });


    echo 'si salio';

});

Route::get('pruebas/api',['as'=>'pruebaApi','uses'=>'RecursoshController@getContratosPorVencer']);