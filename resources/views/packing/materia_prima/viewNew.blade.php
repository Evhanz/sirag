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
                            <input class="form-control input-sm" type="text" id="n_placa">
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
                                <table class="table table-bordered table-hover" id="detUva">
                                    <thead>
                                    <tr>
                                        <th >I</th>
                                        <th>Pesadas</th>
                                        <th>Guia </th>
                                        <th>Variedad</th>
                                        <th>F.</th>
                                        <th>P.</th>
                                        <th>L Prod.</th>
                                        <th>N° Jaba</th>
                                        <th>Tara Jaba</th>
                                        <th>Tara Parihuela</th>
                                        <th>Peso Bruto</th>
                                        <th> <button class="btn btn-info btn-sm" v-on:click="addDetalleUva()"> + </button> </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for=" item in detallesUva" >
                                        <td>@{{ item.correlativo }}</td>
                                        <td><input style="width: 3em" v-model="item.n_pesadas" class="form-control input-sm" v-on:keyup="validateInput(item.correlativo,item.n_pesadas,'number','2')"></td>
                                        <td><input v-model="item.guia" class="form-control input-sm" type="text" maxlength="12"></td>
                                        <td>
                                            <select class="form-control input-sm" v-model="item.variedad">
                                                <option value="Superior">Superior</option>
                                                <option value="Red Globe">Red Globe</option>
                                                <option value="Red Globe">Crimson</option>
                                            </select>

                                        </td>
                                        <td><input v-model="item.fundo" style="width: 3em" class="form-control input-sm" type="text" v-on:keyup="validateInput(item.correlativo,item.fundo,'number','2')"></td>
                                        <td><input v-model="item.parron" style="width: 3em" class="form-control input-sm" type="text" v-on:keyup="validateInput(item.correlativo,item.parron,'number','2')"></td>
                                        <td><input v-model="item.l_produccion" class="form-control input-sm" type="text"></td>
                                        <td><input v-model="item.n_jaba" class="form-control input-sm" type="text"></td>
                                        <td><input v-model="item.tara_jaba" step="any" min="0.00" class="form-control input-sm" type="text"></td>
                                        <td><input v-model="item.tara_parihuela" step="any" min="0.00" class="form-control input-sm" type="text"></td>
                                        <td><input v-model="item.peso_bruto" step="any" min="0.00" class="form-control input-sm" type="text" ></td>
                                        <td><button class="btn btn-default btn-sm" v-on:click="deteleDetail(item.correlativo)"> - </button></td>
                                        <!-- por aqui se guarda esto: @keyup.tab="addDetalleUva()" -->
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div id="menu1" class="tab-pane fade">
                        <div class="row">
                            <div class="col-lg-12 table-responsive">
                                <table class="table table-bordered table-hover" id="detUva">
                                    <thead>
                                    <tr>
                                        <th >I</th>
                                        <th>Pesadas</th>
                                        <th>Guia </th>
                                        <th>Variedad</th>
                                        <th>F.</th>
                                        <th>P.</th>
                                        <th>L Prod.</th>
                                        <th>N° Jaba</th>
                                        <th>Tara Jaba</th>
                                        <th>Tara Parihuela</th>
                                        <th>Peso Bruto</th>
                                        <th> <button class="btn btn-info btn-sm" v-on:click="addDetalleUva()"> + </button> </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for=" item in detallesUva" >
                                        <td>@{{ item.correlativo }}</td>
                                        <td><input style="width: 3em" v-model="item.n_pesadas" class="form-control input-sm" v-on:keyup="validateInput(item.correlativo,item.n_pesadas,'number','2')"></td>
                                        <td><input v-model="item.guia" class="form-control input-sm" type="text" maxlength="12"></td>
                                        <td>
                                            <select class="form-control input-sm" v-model="item.variedad">
                                                <option value="Superior">Superior</option>
                                                <option value="Red Globe">Red Globe</option>
                                                <option value="Red Globe">Crimson</option>
                                            </select>

                                        </td>
                                        <td><input v-model="item.fundo" style="width: 3em" class="form-control input-sm" type="text" v-on:keyup="validateInput(item.correlativo,item.fundo,'number','2')"></td>
                                        <td><input v-model="item.parron" style="width: 3em" class="form-control input-sm" type="text" v-on:keyup="validateInput(item.correlativo,item.parron,'number','2')"></td>
                                        <td><input v-model="item.l_produccion" class="form-control input-sm" type="text"></td>
                                        <td><input v-model="item.n_jaba" class="form-control input-sm" type="text"></td>
                                        <td><input v-model="item.tara_jaba" step="any" min="0.00" class="form-control input-sm" type="text"></td>
                                        <td><input v-model="item.tara_parihuela" step="any" min="0.00" class="form-control input-sm" type="text"></td>
                                        <td><input v-model="item.peso_bruto" step="any" min="0.00" class="form-control input-sm" type="text" ></td>
                                        <td><button class="btn btn-default btn-sm" v-on:click="deteleDetail(item.correlativo)"> - </button></td>
                                    <!-- por aqui se guarda esto: @keyup.tab="addDetalleUva()" -->
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- /.box -->


        <div class="col-lg-12">

            <pre>
                 @{{ $data }}
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


        function validar() {
            alert("as");
        }

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



    <!-- vue JS -->
    <script  src="{{asset('js/vue.js')}}"></script>

    <script>

        Vue.component('detUva_template',{
            template:''
        });

        new Vue({

            el:"#content",
            data: {
                formValidate:0,
                detallesUva:[
                    {
                        correlativo:1,
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
                    }
                ]
            },
            methods:{
                addDetalleUva: function () {

                    var detalle  = {
                        correlativo:0,
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
                    };
                    detalle.correlativo = (this.detallesUva.length)+1;
                    this.detallesUva.push(detalle);
                },
                validateInput: function (ubicacion,dato,type,len) {

                    var bandera = 0;
                    ubicacion --;

                    if (type=='number'){

                        var bandera_tipo = 0;
                        //si dato es un numero tirará falso
                        if(!isNaN(dato) ) {

                            //primero generamos 9's para validar la cantidad
                            //máxima de número
                            var num = '';
                            for(var i=0;i<len;i++){
                                num += '9'+'';
                            }
                            //mayor (pasar eso a otra funcion)
                            if(Number(dato) > Number(num)){
                                bandera=1;
                            }

                        }else{
                            bandera = 1;
                        }

                    }

                    if(bandera == 1){

                        $("#detUva tbody").find('tr:eq('+ubicacion+')').css({"background-color":"rgb(255, 107, 107)","color":"white"});

                    }else {
                        $("#detUva tbody").find('tr:eq('+ubicacion+')').css({"background-color":"#FFF","color":"black"});
                    }


                    this.formValidate = bandera;
                    
                },
                deteleDetail : function (correlativo) {
                    var r = confirm("Seguro que quieres eliminar esta fila ?");
                    if (r == true) {
                        correlativo--;
                        this.detallesUva.splice(correlativo, 1);
                    }


                }
            }

        });

    </script>

@stop