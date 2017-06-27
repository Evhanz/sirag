<?php

//------ llamada a las views de Presupuesto ----------------- 
Route::get('presupuestos/viewMantenedorCci',['as'=>'viewMantenedorCci','uses'=>'PresupuestosController@viewMantenedorCci']);

//llamada a API