@extends('layouts/packing')

@section('header')
    <h1>
        Dashboard
        <small>Manejo de Packing</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">All</li>
    </ol>

@stop

@section('head_options')
@stop

@section('content')

    <div class="row" id="app">
        <input type="hidden" id="ruta" value="{{ url() }}">

        <div class="col-lg-5">
            <div class="box box-danger">
                <div class="box-header" >
                    <i class="ion ion-clipboard"></i>

                    <h3 class="box-title">Pallets <small>- Hoy</small></h3>

                    <div class="box-tools pull-right">
                        <span class="badge">@{{ cant_pallets }}</span>
                    </div>

                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
                    <ul class="todo-list ui-sortable">
                        <li v-for="item in pallet">
                            <!-- drag handle -->
                            <span class="handle ui-sortable-handle">
                                <i class="fa fa-ellipsis-v"></i>
                                <i class="fa fa-ellipsis-v"></i>
                            </span>
                            <!-- todo text -->
                            <span class="text">Pallet : codigo: @{{ item.codigo }},   fecha : @{{ item.fecha_registro }}</span>
                            <!-- General tools such as edit or delete-->
                            <div class="tools">
                                <a style="cursor: pointer"  @click='getCajasPallet(item.codigo)'><i class="fa fa-eye"></i></a>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix no-border">
                  <v-paginator :resource_url="resource_url_pallet" @update="updateResource"></v-paginator>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="box box-primary">
                <div class="box-header ui-sortable-handle" style="cursor: move;">
                    <i class="ion ion-clipboard"></i>

                    <h3 class="box-title">Cajas</h3>

                    <div class="box-tools pull-right">
                        <span class="badge">@{{ cajas.length }}</span>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <div class="col-lg-6" id="">

                        <div class="list-group" style="height: 210px;overflow: scroll;overflow-x: hidden;">
                            <a href="#" @click="detailCaja(item)" class="list-group-item" v-for="item in cajas">
                                @{{ item.codigo  }} | Calibre: @{{ item.calibre }} | Tipo: @{{ item.t_caja }}
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6">

                        <ul class="list-group">
                            <li class="list-group-item active">
                              <strong>Caja Código:</strong>   @{{ personas.codigo }}
                            </li>
                            <li class="list-group-item">
                              <strong>Seleccion:</strong>   @{{ personas.seleccion }}
                            </li>
                            <li class="list-group-item">
                                <strong>Pesaje:</strong>   @{{ personas.pesaje }}
                            </li>
                            <li class="list-group-item">
                                <strong>Embalaje:</strong>  @{{ personas.embalaje }}
                            </li>
                            <li class="list-group-item">
                                <strong>Peso Fijo:</strong>  @{{ personas.peso_fijo }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs pull-right">
                    <li class="active"><a href="#t_caja_bar" data-toggle="tab" @click="getBarCaja('t_caja')">Tipo Caja</a></li>
                    <li class=""><a href="" data-toggle="tab" aria-expanded="false" @click="getBarCaja('calibre')">Calibre</a></li>
                    <li class="pull-left header"><i class="fa fa-inbox"></i> Cajas</li>
                </ul>
                <div class="tab-content no-padding">
                    <div class="chart tab-pane active" id="t_cajapxar">
                        <div id="revenue-chart" style="height:180px">

                        </div>
                        <hr>

                       <i>Cajas del Dia de Hoy</i>
                    </div>
                </div>
            </div>
        </div>




    </div>


@stop

@section('scripts')

    <!-- Daterangepicker css -->
    <link rel="stylesheet" href="{{asset('css/daterangepicker/daterangepicker-bs3.css')}}">
    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script>


        $('input[name="fecha"]').daterangepicker({
            format : "DD/MM/YYYY"
        });

    </script>

    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('templates/lte2/plugins/select2/select2.min.css')}}">

    <!-- Select2 -->
    <script src="{{asset('templates/lte2/plugins/select2/select2.full.min.js')}}"></script>
    <script>
        $(".select2").select2();
    </script>
    <script  src="{{asset('js/vue.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/vuejs-paginator/2.0.0/vuejs-paginator.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.7.0/vue-resource.min.js"></script>
    <script  src="{{asset('js/mods/packing/main.js')}}"></script>

@stop