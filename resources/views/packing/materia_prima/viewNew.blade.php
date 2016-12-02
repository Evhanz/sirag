@extends('layouts/packing')

@section('header')
    <h1>
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
    <div class="row">

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

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>PRODUCTOR</label>
                            <input class="form-control input-sm" value="AGRO EXPORTACIONES GRACE S.A.C." type="text" disabled>
                        </div>
                        <div class="form-group">
                            <label>CHOFER</label>
                            <select class="form-control select2" style="width: 100%;" id="selChofer">
                            </select>
                        </div>
                        <div class="form-group">
                            <label>N° PLACA</label>
                            <input class="form-control input-sm" type="text" >
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>GUIA TRANSPORTISTAS</label>
                            <input class="form-control input-sm"  type="text" >
                        </div>
                        <div class="form-group">
                            <label>RESPONSABLE</label>
                            <select class="form-control select2" style="width: 100%;" id="selResponsable">
                            </select>
                        </div>
                        <div class="form-group">
                            <label>CONTROLADOR</label>
                            <select class="form-control select2" style="width: 100%;" id="selControlador">
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>FECHA</label>
                            <input type="text" class="form-control pull-right" id="datepicker">
                        </div>
                        <div class="form-group">
                            <label>H. INICIO</label>
                            <input class="form-control timepicker" type="text">

                        </div>
                        <div class="form-group">
                            <label>H. FIN</label>
                            <input class="form-control timepicker" type="text">
                        </div>
                    </div>



                    <!-- /.col -->
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
    <!-- bootstrap time picker -->
    <script src="{{asset('templates/lte2/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="{{asset('templates/lte2/plugins/timepicker/bootstrap-timepicker.min.css')}}">
    <script>

        //Date picker
        $('#datepicker').datepicker({
            autoclose: true
        });
        //Timepicker
        $(".timepicker").timepicker({
            showInputs: false
        });


        //primero traeremos toda la data de las personas

        var ruta = "{{ route('getTrabajadores') }}";
        var personal = [];

        getInitData();
        
        function getInitData() {

            $.getJSON( ruta, function( data ) {
               // console.log( data );
                fillDataSelects(data);
            });

            function fillDataSelects(data)
            {
                data.forEach(function (item) {
                    item.id = item.dni;
                    item.text = item.nombre;
                });


                $("#selChofer").select2({
                    data: data
                });
                $("#selResponsable").select2({
                    data: data
                });
                $("#selControlador").select2({
                    data: data
                });
            }

        }


    </script>

@stop