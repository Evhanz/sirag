<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use sirag\Entities\Obj;
use sirag\Helpers\HelpFunct;
use sirag\Repositories\PersonalRep;



class PresupuestosController extends Controller
{

    public function viewMantenedorCci(){
        return view('presupuestos/viewMantenedorCci');
    }

}