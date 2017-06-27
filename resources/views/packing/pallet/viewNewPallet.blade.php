@extends('layouts/packing')

@section('header')
    <h1 class="hidden-xs" xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
        Dashboard
        <small>Módulo Materia Prima</small>
    </h1>
    <ol class="breadcrumb hidden-xs">
        <li><a href="#"><i class="fa fa-dashboard"></i> Modulo: Materia Prima</a></li>
        <li class="active">New</li>
    </ol>
@stop

@section('head_options')
@stop

@section('content')

    <!-- Row Filter-->
    <div class="row" id="content">

        <input type="hidden" id="ruta" value="{{url()}}">
        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />

        <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">
            <div class="hidden-xs box-header with-border">
                <h3 class="box-title">Formulario de ingreso </h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

                <div class="row" >
                    <div class="col-xs-4 col-sm-offset-1" >
                        <h2>PALLET: </h2>
                    </div>
                    <div class="col-xs-6 col-sm-7 " style="text-align: center">
                        <label for="">&nbsp;</label>
                        <input id="codigo_pallet" @keyup.enter="validateCodePallet(codigo_pallet)" type="text" class="form-control" v-model="codigo_pallet">
                    </div>
                    <div class="col-xs-2" >
                        <label for="">&nbsp;</label>
                        <button  @click="reset()" class="btn btn-warning visible-xs" >
                            <i class="fa fa-eercast" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-xs-10 col-sm-offset-1">

                        <table class="table">
                            <tr>
                                <th >Código </th>
                            </tr>
                            <tr>
                                <td>
                                    <input id="code_caja"  @keyup.enter="getCaja(caja)" v-model="caja" type="text" class="form-control" :disabled="isDisabled">
                                </td>
                            </tr>
                        </table>

                    </div>
                    <div>
                        <div class="col-xs-1">
                            <table class="table">
                                <tr>
                                    <th>*</th>
                                </tr>
                                <tr>
                                   <td> <span class="badge">@{{ detalles.length }}</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12" >
                        <table class="table details" id="details">
                            <thead>
                            <tr>
                                <th>*</th>
                                <th style="width: 80%">Código</th>
                                <th>Estado</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr v-for="(item, index) in detalles">
                                <td>
                                    <a class="btn btn-danger btn-xs" @click="quitDetail(index)"> <i class="fa fa-minus-circle"></i> </a>
                                </td>
                                <td><!-- el id_caja es el codigo de la caja  -->
                                    @{{ item.id_caja }}
                                   <!-- <input :id="index" @keyup.enter="getCaja(item.id_caja,item,index)" v-model="item.id_caja" type="text" class="form-control"> -->
                                </td>
                                <td>
                                    -
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xs-8 col-xs-offset-1" style="text-align: right">
                        <a id="btnEnviar" @click="saveData()" class="btn btn-success btn-lg"> Guardar  <i class="fa fa-save"></i></a>
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
    <!-- vue JS -->
    <script  src="{{asset('js/vue.js')}}"></script>
    <script  src="{{asset('js/mods/packing/pallet.js')}}"></script>

    <style>
        @media (max-width: 770px) {

            .content-header{
                padding: 0px;
            }
            .content{
                padding-top: 0px;
            }

        }

        .detalle{
            animation-name: example;
            animation-duration: 3s;
            animation-delay: 0.3s;
        }

        /* Standard syntax */
        @keyframes example {
            0%   { color: #1be7dc;background-color: #41a48e ;}
            25%  { color: #91beae;background-color: #41a48e ;}
            50%  { color: #1be7dc;background-color: #41a48e ;}
            75%  { color: #91beae;background-color: #41a48e ;}
            100% { color: black;background-color: white ;}
        }


    </style>

@stop