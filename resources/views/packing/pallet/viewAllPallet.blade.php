@extends('layouts/packing')

@section('header')
    <h1>
        Pallets
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

        <input type="hidden" id="ruta" value="{{url('')}}">
        <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Mostrar Pallet</h3>
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
                        <form  class="form-inline" method="get">

                            <div class="form-group">
                                <label for="fecha">Rango de Fechas </label>
                                <input type="text" class="form-control" name="fecha" >
                            </div>

                            <button type="submit" class="btn btn-default">Buscar</button>

                            <div class="form-group" style="margin-left: 30px">

                                <a class="btn btn-success" href="{{route('viewNewPallet')}}">Nuevo</a>
                            </div>
                        </form>

                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Codido Pallet</th>
                                <th>Descripcion</th>
                                <th>Registrador</th>
                                <th>Fecha Venciminento</th>
                                <th>Estado</th>
                                <th colspan="2">Opciones</th>
                            </tr>

                            </thead>
                            <tbody>
                            @foreach($pallets as $item)
                                <tr>
                                    <td>{{$item->codigo}}</td>
                                    <td>{{$item->descripcion}}</td>
                                    <td>{{$item->registrador}}</td>
                                    <td>{{$item->fecha_vencimiento}}</td>
                                    <td>{{$item->estado}}</td>
                                    <td><a class="btn btn-default" @click="viewPallet({{$item->id}})"><i class="fa fa-eye"></i></a></td>

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



        <div class="modal fade" role="dialog" id="modalPallet">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Traza del Pallet</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <table class="table">
                                    <thead>
                                    <th>Caja</th>
                                    <th>Selección</th>
                                    <th>Pesaje</th>
                                    <th>Embalaje</th>
                                    </thead>
                                    <tbody>
                                    <tr v-for="item in detalles">
                                        <td>@{{ item.cod_caja }}</td>
                                        <td>@{{ item.seleccion }}</td>
                                        <td>@{{ item.pesaje }}</td>
                                        <td>@{{ item.embalaje}}</td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

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


    <!-- vue JS -->
    <script  src="{{asset('js/vue.js')}}"></script>
    <script  src="{{asset('js/mods/packing/pallet.js')}}"></script>


@stop