@extends('layouts/packing')

@section('header')
    <h1 >
        Dashboard
        <small>Módulo Materia Prima</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Modulo: Materia Prima</a></li>
        <li class="active">Ver ngresos </li>
    </ol>





@stop

@section('head_options')
@stop

@section('content')

    <!-- Row Filter-->
    <div class="row" id="content">

        <div class="row" style="padding-left: 15px; padding-right: 15px;">
            <!-- Box (with bar chart) -->
            <div class="box box-default" >
                <div class="box-header">
                    <ul class="nav nav-tabs" id="tab_filtros">
                        <li class="active"><a data-toggle="tab" href="#home">Detalle</a></li>
                    </ul>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                    <div class="row" style="padding-left: 15px;">
                        <div class="col-lg-12">
                            <div class="tab-content">
                                <div id="home" class="tab-pane fade in active">
                                    <div class="row">
                                        <input type="hidden" id="_token" value="{{ csrf_token() }}" />
                                        <form method="post" action="{{route('viewAllMPPrameters')}}" class="form-inline" style="padding: 15px" >
                                            <input name="_token" type="hidden" id="_token" value="{{ csrf_token() }}" />
                                            <div class="form-group">
                                                <label>Rango de Fechas</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input class="form-control " name="daterange" id="reservation" type="text">
                                                </div><!-- /.input group -->
                                            </div>

                                            <div class="form-group">
                                                <button class="btn btn-success" id="btnBuscarDoc" ng-click="getDataAll()">
                                                    <i class="fa fa-search fa-lg"></i>
                                                </button>
                                            </div>
                                            <div class="form-group">
                                                <a href="{{route('viewStorePMateriaPrima')}}" class="btn btn-info" id="btnBuscarDoc" >
                                                    Nuevo Ingreso
                                                </a>
                                            </div>
                                        </form>

                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>*</th>
                                                    <th>Fecha</th>
                                                    <th>Guia Trans.</th>
                                                    <th>H.I - H.F</th>
                                                    <th>Opciones</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($res as $item)
                                                    <tr>
                                                        <td>{{$item->id}}</td>
                                                        <td>{{$item->fecha}}</td>
                                                        <td>{{$item->guia_transportista}}</td>
                                                        <td>{{$item->h_inicio}} - {{$item->h_fin}}</td>
                                                        <td>
                                                            <a href="{{route('viewEditIMP',['id'=>$item->id])}}" class="btn btn-warning">Edit </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                                <!-- Tab filtro documento -->
                                <div id="menu1" class="tab-pane fade">
                                    <h3>Menu 1</h3>
                                    <p>Some content in menu 1.</p>

                                    <label>Date range:</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input class="form-control " name="daterange" id="reservation" type="text">
                                    </div><!-- /.input group -->


                                </div>
                                <div id="menu2" class="tab-pane fade">
                                    <h3>Menu 2</h3>
                                    <p>Some content in menu 2.</p>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.row - inside box -->
                </div><!-- /.box-body -->
                <div class="box-footer">

                </div><!-- /.box-footer -->
            </div><!-- /.box -->


            <div class="col-lg-12">



            </div>
        </div>








    </div>
    <!-- /.row (Row Data) -->


@stop

@section('scripts')

    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('templates/lte2/plugins/select2/select2.min.css')}}">
    <!-- Select2 -->
    <script src="{{asset('templates/lte2/plugins/select2/select2.full.min.js')}}"></script>
    <!-- bootstrap time picker -->
    <script src="{{asset('templates/lte2/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="{{asset('templates/lte2/plugins/timepicker/bootstrap-timepicker.min.css')}}">


    <!-- Daterangepicker css -->
    <link rel="stylesheet" href="{{asset('css/daterangepicker/daterangepicker-bs3.css')}}">
    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>

    <script src="{{ asset('js/plugins/angular/angular-ui-bootstrap-0.3.0.min.js') }}"></script>
    <script>

        /*funciones de jquery*/

        $('input[name="daterange"]').daterangepicker({
            format : "DD/MM/YYYY"
        });
        $('[data-toggle="tooltip"]').tooltip();


    </script>


@stop