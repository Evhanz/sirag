<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 16/05/2017
 * Time: 05:40 PM
 */

Route::get('costo/',['as'=>'modCosto']);

Route::get('costo/viewDistribucionCosto',
    ['as'=>'viewDistribucionCosto','uses'=>'CostoController@viewDistribucionCosto']);
