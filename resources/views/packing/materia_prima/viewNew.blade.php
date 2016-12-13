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

    <!--
    <span id="prueba">
        <h1>Bienvenido, @{{ name}}</h1>

        <input type="text" v-model="name">

        <hr>

        <pre>

        @{{ $data | json }}
        </pre>

    </span>

    -->




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
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#home">DETALLE UVA</a></li>
                    <li><a data-toggle="tab" href="#menu1">DETALLE DESCARTE</a></li>
                </ul>

                <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">

                        <div class="row">
                            <div class="col-lg-12 table-responsive">
                                <table class="table table-bordered table-hover" >
                                    <thead>
                                    <tr>
                                        <th>I</th>
                                        <th>N° Pesadas</th>
                                        <th>Guia</th>
                                        <th>Variedad</th>
                                        <th>Fundo</th>
                                        <th>Parron</th>
                                        <th>L Produccion</th>
                                        <th>N° Jaba</th>
                                        <th>Tara Jaba</th>
                                        <th>Tara Parihuela</th>
                                        <th>Peso Bruto</th>
                                        <th> <button class="btn btn-info btn-sm"> + </button> </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td><input class="form-control" type="text"></td>
                                        <td><input class="form-control" type="text"></td>
                                        <td><input class="form-control" type="text"></td>
                                        <td><input class="form-control" type="text"></td>
                                        <td><input class="form-control" type="text"></td>
                                        <td><input class="form-control" type="text"></td>
                                        <td><input class="form-control" type="text"></td>
                                        <td><input class="form-control" type="text"></td>
                                        <td><input class="form-control" type="text"></td>
                                        <td><input class="form-control" type="text"></td>
                                        <td><button class="btn btn-default btn-sm"> - </button></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div id="menu1" class="tab-pane fade">
                        <h3>Menu 1</h3>
                        <p>Some content in menu 1.</p>
                    </div>
                </div>

            </div>
        </div>
        <!-- /.box -->


        <div class="col-lg-12">

            <pre>
                 @{{ $data | json }}
            </pre>

        </div>



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
        }

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




    </script>

    <!-- Templates -->

    <script type="text/template" id="detUva_template">

        <td>@{{$index}}</td>
        <td><input v-model="n_pesadas" class="form-control" type="text"></td>
        <td><input v-model="guia" class="form-control" type="text"></td>
        <td><input v-model="variedad" class="form-control" type="text"></td>
        <td><input v-model="fundo" class="form-control" type="text"></td>
        <td><input v-model="parron" class="form-control" type="text"></td>
        <td><input v-model="l_produccion" class="form-control" type="text"></td>
        <td><input v-model="n_jaba" class="form-control" type="text"></td>
        <td><input v-model="tara_jaba" class="form-control" type="text"></td>
        <td><input v-model="tara_parihuela" class="form-control" type="text"></td>
        <td><input v-model="peso_bruto" class="form-control" type="text"></td>
        <td><button v-model="n_pesadas" class="btn btn-default btn-sm"> - </button></td>

    </script>



    <!-- ./ Templates -->




    <!-- vue JS -->
    <script  src="{{asset('js/vue.js')}}"></script>

    <script>

        Vue.component('detUva_template',{

            template:''

        });

        new Vue({

            el:"#content",
            data: {
                name: "eidelman",
                detallesUva:[],
                new_detalleUva:[
                        {
                            n_pesadas:'',
                            guia:'',
                            variedad:'',
                            fundo: '',
                            parron: '',
                            l_produccion:'',
                            n_jaba: '',
                            tara_jaba: '',
                            tara_parihuela: '',
                            peso_bruto: ''
                        }]
            },
            methods:{
                createDetalleUva: function () {
                    this.detallesUva.push(this.new_detalleUva);
                }
            }

        });

    </script>

@stop