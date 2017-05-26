@extends('layouts/packing')

@section('header')
    <h1>
        Etapas de packing
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('viewEtapaAll') }}"><i class="fa fa-dashboard"></i> Etapa</a></li>
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
                <h3 class="box-title">Ingreso de Etapa : <small>{{$opcion}}</small></h3>
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
                    <input type="hidden" id="ruta_empleados" value="{{ url() }}">

                    <form action="{{route('apiSeleccionReg')}}" method="post">
                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />

                        @if($opcion == 'nuevo')
                            <input type="hidden" id="url_send" value="{{route('apiSeleccionReg')}}">
                        @else
                            <input type="hidden" id="url_send" value="{{route('apiSeleccionEdit')}}">
                        @endif
                        <input type="hidden" id="opcion" value="{{ $opcion or ''  }}">
                        <input type="hidden" id="id_etapa" value="{{ $etapa or ''  }}">
                        <div class="col-lg-2 ">
                            <label for="tipo">Tipo</label>
                            <select @change="changeTipo()" v-model="tipo" name="tipo" class="form-control" title="Tipo de Ingreso">
                                <option value="normal">Normal</option>
                                <option value="peso_fijo">Peso Fijo</option>
                            </select>

                        </div>
                        <div class="col-md-8 ">

                            <div class="row">
                                <div class="col-xs-4" data-opcion="normal">
                                    <div v-if="etapa.seleccion_estado == 0 ">
                                        <h3 >C. Selección <i style="color: red" class="fa fa-barcode"></i> </h3>
                                    </div>
                                    <div v-else >
                                        <h3>C. Selección <i style="color: green" class="fa fa-barcode"></i> </h3>
                                    </div>

                                </div>
                                <div class="col-xs-4" data-opcion="normal">
                                    <div v-if="etapa.pesaje_estado == 0 ">
                                        <h3>C. Pesaje <i style="color: red" class="fa fa-barcode"></i> </h3>
                                    </div>
                                    <div v-else >
                                        <h3>C. Pesaje  <i style="color: green" class="fa fa-barcode"></i> </h3>
                                    </div>

                                </div>
                                <div class="col-xs-4" data-opcion="normal">
                                    <div v-if="etapa.embalaje_estado == 0 ">
                                        <h3>C. Embalaje <i style="color: red" class="fa fa-barcode"></i> </h3>
                                    </div>
                                    <div v-else >
                                        <h3>C. Embalaje  <i style="color: green" class="fa fa-barcode"></i> </h3>
                                    </div>
                                </div>

                                <!--peso fijo -->

                                <div class="col-xs-12" data-opcion="peso_fijo">
                                    <div v-if="etapa.embalaje_estado == 0 ">
                                        <h3>C. Peso Fijo <i style="color: red" class="fa fa-barcode"></i> </h3>
                                    </div>
                                    <div v-else >
                                        <h3>C. Peso Fijo  <i style="color: green" class="fa fa-barcode"></i> </h3>
                                    </div>
                                </div>

                                <!--./peso fijo -->

                            </div>

                            <div class="row">

                                <div class="col-xs-4" data-opcion="normal">
                                    <input class="form-control input-lg" @keyup="etapaWrite('s')" @keyup.enter="getTrabajador(etapa.seleccion,'s')" v-model="etapa.seleccion" type="text" required>
                                </div>

                                <div class="col-xs-4" data-opcion="normal">
                                    <input class="form-control input-lg" @keyup="etapaWrite('p')" @keyup.enter="getTrabajador(etapa.pesaje,'p')" v-model="etapa.pesaje" type="text" required>
                                </div>

                                <div class="col-xs-4" data-opcion="normal">
                                    <input class="form-control input-lg" @keyup="etapaWrite('e')" @keyup.enter="getTrabajador(etapa.embalaje,'e')" v-model="etapa.embalaje" type="text" required>
                                </div>

                                <div class="col-xs-12" data-opcion="peso_fijo">
                                    <input class="form-control input-lg" @keyup="etapaWrite('e')" @keyup.enter="getTrabajador(etapa.peso_fijo,'f')" v-model="etapa.peso_fijo" type="text" required>
                                </div>

                                <!--
                                <div class="col-xs-2">
                                    <a class="btn bg-olive btn-flat btn-lg pull-right">
                                        <i class="fa  fa-search "></i>
                                    </a>
                                </div>
                                -->

                            </div>
                            <br>

                            <div class="row">

                                <!--
                                <div class="col-xs-3">
                                    <label for="uva">Uva</label>
                                    <select class="form-control" name="uva" id="uva" v-model="etapa.uva" required>
                                        <option value="Red Globe">Red Globe</option>
                                        <option value="Crimson">Crimson</option>
                                        <option value="otro">Otro</option>
                                    </select>

                                </div>
                                -->
                                <div class="col-xs-6">
                                    <label for="calibre">Calibre</label>
                                    <select class="form-control" name="calibre" id="calibre" v-model="etapa.calibre" required>
                                        <option value="12">12</option>
                                        <option value="11">11</option>
                                        <option value="13">13</option>
                                    </select>
                                </div>
                                <!--
                                <div class="col-xs-3">
                                    <label for="calibre">Peso</label>
                                    <input type="text" class="form-control" id="peso" v-model="etapa.peso" name="peso">
                                </div>
                                -->

                                <div class="col-xs-6">
                                    <label for="calibre">T. Caja</label>
                                    <input type="text" class="form-control" id="t_caja" v-model="etapa.t_caja" name="t_caja">
                                </div>

                            </div>

                            <br>

                            <div class="row">
                                <div class="col-xs-12">
                                    <a id="btnEnviar" @click="sendData()" class="btn btn-block btn-success btn-lg">
                                        <i class="fa fa-save "></i> Guardar
                                    </a>
                                </div>
                            </div>

                            <div class="row" id="codigo">
                                <div class="col-xs-12">
                                    <h2>Código : <strong>@{{ codigo }}</strong></h2>
                                </div>

                            </div>

                        </div>
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
    <!-- /.row (Row Filter) -->

    <!-- Row Data-->
    <div class="row">

    </div>
    <!-- /.row (Row Data) -->


@stop

@section('scripts')

    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('templates/lte2/plugins/select2/select2.min.css')}}">

    <!-- Select2 -->
    <script src="{{asset('templates/lte2/plugins/select2/select2.full.min.js')}}"></script>
    <script>
        $(".select2").select2();
    </script>

    <!-- vue JS -->
    <script  src="{{asset('js/vue.js')}}"></script>
    <script  src="{{asset('js/mods/packing/etapa.js')}}"></script>

@stop