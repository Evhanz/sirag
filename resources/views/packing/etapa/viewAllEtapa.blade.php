@extends('layouts/packing')

@section('header')
    <h1>
        Etapas de packing
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">All</li>
    </ol>

@stop

@section('head_options')
@stop

@section('content')

    <!-- Row Filter-->
    <div class="row" id="content">
        <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Mostrar Etapa</h3>
                <!--
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                </div>
                -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">

                <div class="row">
                    <div class="col-lg-12">
                        <form  class="form-inline" action="{{route('getEtapaByParameter')}}" method="get">

                            <div class="hidden-xs form-group">
                                <label for="fecha">Rango de Fechas </label>
                                <input type="text" class="form-control" name="fecha" >
                            </div>

                            <button type="submit" class="hidden-xs btn btn-default">Buscar</button>

                            <div class="hidden-xs form-group" style="margin-left: 30px">

                                <a class="btn btn-success" href="{{route('viewNewEtapa')}}">
                                    <i class="fa fa-cubes"></i>Nuevo</a>
                            </div>

                            <!--Esto se va a ver solo en el mobil -->
                            <a class="visible-xs  btn btn-success" href="{{route('viewNewEtapa')}}">
                                Nuevo <strong> <i class="fa fa-cubes"></i></strong></a>
                        </form>

                    </div>

                    <hr>

                    <div class="visible-xs col-lg-12">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                            <input type="email" class="form-control" placeholder="Codigo de caja">
                        </div>
                    </div>
                </div>

                <br>

                <!--Esta tabla solo se vera en dispositivos grandes -->
                <div class="hidden-xs row">
                    <div class="col-lg-12">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Codigo Caja</th>
                                <th>Tipo Caja</th>
                                <th>Tipo Uva</th>
                                <th>Calibre</th>
                                <th>Peso</th>
                                <th>P. Seleccion</th>
                                <th>P. Pesaje</th>
                                <th>P. Embalaje</th>
                                <th>Fecha</th>
                                <th>Opciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($etapa as $item)
                                <tr>
                                    <td>{{$item->codigo}}</td>
                                    <td>{{$item->t_caja}}</td>
                                    <td>{{$item->uva}}</td>
                                    <td>{{$item->calibre}}</td>
                                    <td>{{$item->peso}}</td>
                                    <td>{{$item->u_seleccion}}</td>
                                    <td>{{$item->u_pesaje}}</td>
                                    <td>{{$item->u_embalaje}}</td>
                                    <td>{{$item->fecha}}</td>
                                    <td><a class="btn btn-info" href="{{route('viewEtapaEdit',['id'=>$item->id])}}">
                                            <i class="fa fa-edit"></i>
                                        </a></td>

                                </tr>
                            @endforeach
                            </tbody>

                        </table>

                    </div>
                </div>



                <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">



            </div>
        </div>
        <!-- /.box -->

    </div>
    <!-- /.row (Row Filter) -->

    <!-- Row Data-->
    <div class="row">

    </div>
    <!-- /.row (Row Data) -->


@stop

@section('scripts')

    <style>
        .form-group{
            margin-right: 20px;
        }
    </style>

    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('templates/lte2/plugins/select2/select2.min.css')}}">

    <!-- Select2 -->
    <script src="{{asset('templates/lte2/plugins/select2/select2.full.min.js')}}"></script>
    <!-- Daterangepicker css -->
    <link rel="stylesheet" href="{{asset('css/daterangepicker/daterangepicker-bs3.css')}}">
    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script>
        $(".select2").select2();

        $('input[name="fecha"]').daterangepicker({
            format : "DD/MM/YYYY"
        });

    </script>



@stop