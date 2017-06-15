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
        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
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
                        <div  class="form-inline" >

                            <div class="form-group hidden-xs">
                                <label for="fecha">Codigo Pallet </label>
                                <input id="codigoPallet" @keyup.enter="getPalletByCodigo()" type="text" class="form-control"  >
                            </div>


                            <form action="{{route('getPalletByFechas')}}" method="post" class="form-group">
                                <div class="form-group hidden-xs">
                                    <label for="fecha">Rango de Fechas </label>
                                    <input  id='fecha' type="text" class="form-control" name="fecha" >
                                </div>
                                <a type="submit" class="btn btn-default hidden-xs" @click="getPalletByFechas()">Buscar</a>
                                <div class="form-group hidden-xs" style="margin-left: 30px">
                                    <a class="btn btn-success" href="{{route('viewNewPallet')}}">Nuevo</a>
                                </div>
                            </form>



                            <!--Esto se va a ver solo en el mobil -->
                            <a class="visible-xs  btn btn-success" href="{{route('viewNewPallet')}}">
                                Nuevo <strong> <i class="fa fa-cubes"></i></strong></a>


                            <div class="visible-xs ">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-search"></i></span>
                                    <input type="email" class="form-control" placeholder="Codigo de pallet">
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                <br>

                <div class="row hidden-xs">
                    <div class="col-lg-12">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Codido Pallet</th>
                                <th>Calibre</th>
                                <th>Tipo Caja</th>
                                <th>Cant. Cajas</th>
                                <th>Fecha Registro</th>
                                <th colspan="2">Opciones</th>
                            </tr>

                            </thead>
                            <tbody v-for="item in pallets">
                            <tr >
                                <td>@{{item.codigo}}</td>
                                <td>@{{item.calibre}}</td>
                                <td>@{{item.t_caja}}</td>
                                <td>@{{item.cant_cajas}}</td>
                                <td>@{{item.fecha_registro}}</td>
                                <td><button class="btn btn-default btn-xs" @click="viewDetail(item)">
                                        <i class="fa fa-eye"></i>
                                    </button></td>
                            </tr>
                            <transition name="fade">
                                <tr v-if="item.detail_show">
                                    <td colspan="6">
                                        <table class="table">
                                            <tr v-for="detalle in item.detalles">
                                                <td>@{{ detalle.t_caja }}</td>
                                                <td>@{{ detalle.calibre }}</td>
                                                <td>@{{ detalle.cod_caja }}</td>
                                                <td>@{{ detalle.seleccion }}</td>
                                                <td>@{{ detalle.pesaje }}</td>
                                                <td>@{{ detalle.embalaje }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </transition>


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
                                    <tr >


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

        .fade-enter-active, .fade-leave-active {
            transition: opacity .5s
        }
        .fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
            opacity: 0
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
    <script  src="{{asset('js/mods/packing/palletRep.js')}}"></script>


@stop