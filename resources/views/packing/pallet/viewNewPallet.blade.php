@extends('layouts/packing')

@section('header')
    <h1 xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
        Dashboard
        <small>Módulo Materia Prima</small>
    </h1>
    <ol class="breadcrumb">
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

        <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Formulario de ingreso </h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

                <div class="row" >
                    <div class="col-xs-4 col-xs-offset-1" >

                        <h1>PALLET</h1>

                    </div>

                </div>
                <br>

                <div class="row">

                    <div class="col-xs-4 col-xs-offset-1">
                        DESCRIPCION <BR>
                        <input type="text" class="form-control" v-model="pallet.descripcion">

                    </div>
                    <div class="col-xs-4">
                        Fecha de Vencimiento
                        <input type="date" class="form-control" v-model="pallet.fecha_vencimiento">

                    </div>
                </div>
                <br><br>

                <div class="row">
                    <div class="col-xs-8 col-xs-offset-1" style="text-align: center">
                        <a   @click="addDetail()" style="cursor: pointer">
                            <i class="fa fa-plus-circle fa-5x" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-xs-8 col-xs-offset-1" >
                        <table class="table">
                            <thead>
                            <tr>
                                <th>*</th>
                                <th>Código</th>
                                <th>Descripcion</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(item, index) in detalles">
                                <td>
                                    <a class="btn btn-danger btn-xs" @click="quitDetail(index)"> <i class="fa fa-minus-circle"></i> </a>
                                </td>
                                <td>
                                    <input :id="index" @keyup.enter="getCaja(item.id_caja,item,index)" v-model="item.id_caja" type="text" class="form-control">
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
                        <a @click="saveData()" class="btn btn-success btn-lg"> Guardar  <i class="fa fa-save"></i></a>
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





@stop