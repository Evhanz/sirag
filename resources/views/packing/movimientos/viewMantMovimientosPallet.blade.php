@extends('layouts/packing')

@section('header')
    <h1>
        Movimientos de :
        <small>Pallets</small>
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

        <input type="hidden" id="url" value="{{url('')}}">

        <!-- SELECT2 EXAMPLE -->

        <div class="col-lg-7 hidden-xs">

            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Mostrar Movimiento</h3>
                    <!--
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                    </div>
                    -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <form class="form-inline" style="padding: 15px" action="{{route('getMovimientosPalletParams')}}" method="post">
                        <input type="hidden" name="_token" id="_token2" value="{{ csrf_token() }}" />
                        <div class="form-group">
                            <label>Rango de Fechas</label><br>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input class="form-control " name="daterange" id="reservation" type="text" required>
                            </div><!-- /.input group -->
                        </div>
                        <div class="form-group">
                            <label for="">Tipo</label><br>
                            <select class="form-control" name="tipo" >
                                <option value="salida">Salida</option>
                            </select>

                        </div>

                        <div class="form-group">
                            <br>
                            <button value="query" class="btn btn-info">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>

                        <div class="form-group">
                            <br>
                            <button value="excel" class="btn btn-success" >
                                <i class="fa fa-file-excel-o"></i>
                            </button>
                        </div>

                    </form>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">

                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-dorded">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Codigo</th>
                                    <th>C.Pallet.</th>
                                    <th>Fecha</th>
                                    <th>Descripcion</th>
                                    <th>Origen</th>
                                    <th>Destino</th>
                                </tr>
                                </thead>
                                @if(isset($movimientos))
                                    <tbody>
                                    @foreach($movimientos as $item)
                                        <tr>
                                            <td>{{$item->id}}</td>
                                            <td>{{$item->codigo}}</td>
                                            <td>{{$item->cant_pallet}}</td>
                                            <td>{{date_format( date_create($item->fecha),'d-m-Y')}}</td>
                                            <td>{{$item->descripcion}}</td>
                                            <td>{{$item->origen}}</td>
                                            <td>{{$item->destino}}</td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                @endif

                            </table>
                        </div>
                    </div>


                </div>
            </div>
            <!-- /.box -->
        </div>

        <div class="col-lg-5">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Registrar Movimiento </h3>
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
                        <form id="form_movimiento" class="form" method="post" style="padding: 15px" action="{{route('insertOrUpdateMovimientoPallet')}}">
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
                            <input type="hidden" name="opcion" id="opcion" value="nuevo" />
                            <input type="hidden" name="origen" id="origen" :value="origen" />
                            <input type="hidden" name="destino" id="destino" :value="destino" />
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <label>Codigo de Container</label>
                                    </div>
                                    <div class="col-xs-6">
                                        <input name="codigo" class="form-control" type="text" v-model="codigo">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Tipo</label>
                                <select class="form-control" name="tipo" id="" v-model="tipo">
                                    <option value="salida">Salida</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th colspan="2">Código </th>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input id="code_pallet"  @keyup.enter="gePallet(pallet)" v-model="pallet" type="text" class="form-control" >
                                        </td>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr v-for="(item, index) in detalles">
                                        <td>
                                            <a class="btn btn-danger btn-xs" @click="quitDetail(index)"> <i class="fa fa-minus-circle"></i> </a>
                                        </td>
                                        <td><!-- el id_caja es el codigo de la caja  -->
                                            <input name="detalle[]" type="text" :value="item.codigo" readonly>
                                        <!-- <input :id="index" @keyup.enter="getCaja(item.id_caja,item,index)" v-model="item.id_caja" type="text" class="form-control"> -->
                                        </td>
                                    </tr>
                                    </tbody>

                                </table>
                            </div>

                            <div class="from-group">
                                <a @click="sendData()" class="btn btn-success" style="width:100%">Guardar</a>
                            </div>

                            @if (session('accion'))
                                <div class="from-group">
                                    Correcto!! ....
                                </div>
                            @endif



                        </form>

                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                </div>
            </div>
            <!-- /.box -->
        </div>






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



    </script>


    <!-- vue JS -->
    <script  src="{{asset('js/vue.js')}}"></script>
    <script  src="{{asset('js/mods/packing/movimientos.js')}}"></script>


@stop