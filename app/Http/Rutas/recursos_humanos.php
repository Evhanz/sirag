<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 02/09/2016
 * Time: 10:03 AM
 */

Route::group(['middleware' => 'roles','roles'=>['ADMIN','RH']], function () {
//------ llamada a las views de rh ----------------- RH
    Route::get('rh/',['as'=>'modRH']);
    Route::get('rh/rep/viewPersonal',['as'=>'viewPersonal','uses'=>'RecursoshController@viewPersonal']);
    Route::get('rh/rep/HistorialContrato/{ficha}',['as'=>'viewHistoryContract','uses'=>'RecursoshController@viewHistoryContract']);
    Route::post('rh/addNewRenovacion',['as'=>'addNewRenovacion','uses'=>'RecursoshController@addNewRenovacion']);
    Route::post('rh/deleteRenovacion',['as'=>'deleteRenovacion','uses'=>'RecursoshController@deleteRenovacion']);
    Route::get('rh/rep/viewTelecredito',['as'=>'viewTelecredito','uses'=>'RecursoshController@viewTelecredito']);
    Route::get('rh/rep/viewPlanilla',['as'=>'viewPlanilla','uses'=>'RecursoshController@viewPlanilla']);
    Route::get('rh/rep/viewPlame',['as'=>'viewPlame','uses'=>'RecursoshController@viewPlame']);
    Route::get('rh/rep/viewGetLiquidacion',['as'=>'viewGetLiquidacion','uses'=>'RecursoshController@viewGetLiquidacion']);
    Route::get('rh/rep/viewGetAFPNet',['as'=>'viewGetAFPNet','uses'=>'RecursoshController@viewGetAFPNet']);
    Route::get('rh/rep/viewGetCostoMOFundoParron',['as'=>'viewGetCostoMOFundoParron',
        'uses'=>'RecursoshController@viewGetCostoMOFundoParron']);
    Route::get('rh/rep/viewRegJornales',['as'=>'viewRegJornales','uses'=>'RecursoshController@viewRegJornales']);
    Route::get('rh/rep/viewDeleteMovimientos',['as'=>'viewDeleteMovimientos','uses'=>'RecursoshController@viewDeleteMovimientos']);
    Route::get('rh/rep/viewGetBoletaPago',['as'=>'viewGetBoletaPago','uses'=>'RecursoshController@viewGetBoletaPago']);
    Route::get('rh/rep/viewFeriado',['as'=>'viewFeriado','uses'=>'RecursoshController@viewFeriado']);

});

Route::get('rh/viewCambioCargo',['as'=>'viewCambioCargo','uses'=>'RecursoshController@viewCambioCargo']);

Route::get('rh/viewMantenedorPersonal',['as'=>'viewMantenedorPersonal','uses'=>'RecursoshController@viewMantenedorPersonal']);
Route::get('rh/api/getGentabcod/{tipo}',['as'=>'getGentabcod','uses'=>'RecursoshController@getGentabcod']);
Route::get('rh/api/getArea/{area}',['as'=>'getArea','uses'=>'RecursoshController@getArea']);


//llamada a API
Route::get('rh/api/getTrabajadorBy/{ficha}',['as'=>'getTrabajadorByFicha','uses'=>'RecursoshController@getTrabajadorByFicha']);
Route::get('rh/api/getContratos/{ficha}',['as'=>'getContratos','uses'=>'RecursoshController@getContratos']);
Route::get('rh/api/getRenovacionesByFicha/{ficha}',['as'=>'getRenovacionesByFicha','uses'=>'RecursoshController@getRenovacionesByFicha']);
Route::get('rh/api/getVacacionesByFicha/{ficha}',['as'=>'getVacacionesByFicha','uses'=>'RecursoshController@getVacacionesByFicha']);
Route::post('rh/api/getTelecredito',['as'=>'getTelecredito','uses'=>'RecursoshController@getTelecredito']);
Route::get('rh/api/getCargos',['as'=>'getCargos','uses'=>'RecursoshController@getCargos']);
Route::get('rh/api/getDepartamentos',['as'=>'getDepartamentos','uses'=>'RecursoshController@getDepartamentos']);
Route::post('rh/api/getPlanilla',['as'=>'getPlanilla','uses'=>'RecursoshController@getPlanilla']);
Route::post('rh/api/getPlanillaAgrario',['as'=>'getPlanillaAgrario','uses'=>'RecursoshController@getPlanillaAgrario']);
Route::get('rh/api/getCostoMOPorFundo',['as'=>'getCostoMOPorFundo','uses'=>'RecursoshController@getCostoMOPorFundo']);
Route::post('rh/api/getPlameRem',['as'=>'getPlameRem','uses'=>'RecursoshController@getPlameRem']);
Route::post('rh/api/getPlameRemSNL',['as'=>'getPlameRemSNL','uses'=>'RecursoshController@getPlameRemSNL']);
Route::post('rh/api/getPlameJOR',['as'=>'getPlameJOR','uses'=>'RecursoshController@getPlameJOR']);
Route::get('rh/api/getDetailLiquidacion',['as'=>'getDetailLiquidacion','uses'=>'RecursoshController@getDetailLiquidacion']);
Route::post('rh/api/getMovimientosByFichaAndPeriodo',['as'=>'getMovimientosByFichaAndPeriodo'
    ,'uses'=>'RecursoshController@getMovimientosByFichaAndPeriodo']);
Route::post('rh/api/deleteMovimientoByPeriodoFicha',['as'=>'deleteMovimientoByPeriodoFicha'
    ,'uses'=>'RecursoshController@deleteMovimientoByPeriodoFicha']);
Route::get('rh/api/getAllTrabajadores',['as'=>'getAllTrabajadores'
    ,'uses'=>'RecursoshController@getAllTrabajadores']);
Route::get('rh/api/getCentroCostoInterno',['as'=>'getCentroCostoInterno'
    ,'uses'=>'RecursoshController@getCentroCostoInterno']);
Route::post('rh/api/getLaborByCodigo',['as'=>'getLaborByCodigo','uses'=>'RecursoshController@getLaborByCodigo']);
Route::post('rh/api/getMarcacionDICONTrabajadorByFecha',['as'=>'getMarcacionDICONTrabajadorByFecha'
    ,'uses'=>'RecursoshController@getMarcacionDICONTrabajadorByFecha']);
Route::get('rh/api/CodigoActividad',['as'=>'CodigoActividad','uses'=>'RecursoshController@CodigoActividad']);
Route::post('rh/api/getJornalesByFechas',['as'=>'getJornalesByFechas','uses'=>'RecursoshController@getJornalesByFechas']);
Route::post('rh/api/processdominical',['as'=>'processdominical','uses'=>'RecursoshController@processdominical']);
Route::get('rh/api/getJefeByFicha/{ficha}',['as'=>'getJefeByFicha','uses'=>'RecursoshController@getJefeByFicha']);
Route::get('rh/api/getTrabajadorByFichaAndActive/{ficha}',['as'=>'getTrabajadorByFichaAndActive','uses'=>'RecursoshController@getTrabajadorByFichaAndActive']);






//inserts
Route::post('rh/store/regJornales',['as'=>'regJornales','uses'=>'RecursoshController@regJornales']);
Route::post('rh/store/regFeriados',['as'=>'regFeriados','uses'=>'RecursoshController@regFeriados']);

//edits
Route::post('rh/store/editJornal',['as'=>'editJornal','uses'=>'RecursoshController@editJornal']);
Route::post('rh/vacaciones/editPeriodo',['as'=>'editPeriodoVac','uses'=>'RecursoshController@editPeriodoVac']);
Route::post('rh/cargo/editCargo',['as'=>'editCargo','uses'=>'RecursoshController@editCargo']);

//deletes
Route::post('rh/delete/deleteJornales',['as'=>'deleteJornales','uses'=>'RecursoshController@deleteJornales']);




//para descargar archivos o visualizar fotos
Route::get('archivo/getTeecredito',['as'=>'getTxtTelecredito','uses'=>'RecursoshController@getTxtTelecredito']);


//esto e para los txt
Route::get('archivo/getTxtPlameRem/{periodo}',['as'=>'getTxtPlameRem','uses'=>'RecursoshController@getTxtPlameRem']);
Route::get('archivo/getTxtPlameSNL/{periodo}',['as'=>'getTxtPlameSNL','uses'=>'RecursoshController@getTxtPlameSNL']);
Route::get('archivo/getTxtPlameJOR/{periodo}',['as'=>'getTxtPlameJOR','uses'=>'RecursoshController@getTxtPlameJOR']);


//esto es para los pdf
Route::post('rh/archivos/getLiquidacion',['as'=>'getLiquidacion','uses'=>'RecursoshController@getLiquidacion']);
Route::post('rh/archivos/getBoletaPago',['as'=>'getBoletaPago','uses'=>'RecursoshController@getBoletaPago']);


//esto es para los archivos excel
Route::post('rh/archivos/getExcelAFPNet',['as'=>'getExcelAFPNet','uses'=>'RecursoshController@getExcelAFPNet']);
Route::post('rh/archivos/getExcelCostoMOPorFundo',['as'=>'getExcelCostoMOPorFundo',
    'uses'=>'RecursoshController@getExcelCostoMOPorFundo']);
Route::post('rh/archivos/getExcelJornales',['as'=>'getExcelJornales',
    'uses'=>'RecursoshController@getExcelJornales']);


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
Route::post('rh/txt/telecredito/',['as'=>'txt','uses'=>'RecursoshController@gettxt']);

