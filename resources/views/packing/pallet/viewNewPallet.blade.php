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

                <div class="row">
                    <div class="col-lg-4">

                    </div>
                    <div class="col-lg-4">

                    </div>
                    <div class="col-lg-4">

                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <a href="">
                            <i class="fa fa-plus-circle fa-5x" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="table">
                            <thead>
                            <tr>
                                <th>*</th>
                                <th>Código</th>
                                <th>Descripcion</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>

                            </tr>
                            </tbody>
                        </div>
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





@stop