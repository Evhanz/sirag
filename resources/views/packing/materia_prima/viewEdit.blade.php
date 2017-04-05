@extends('layouts/packing')

@section('header')
    <h1 xmlns:v-on="http://www.w3.org/1999/xhtml" xmlns:v-on="http://www.w3.org/1999/xhtml">
        Dashboard
        <small>Módulo Materia Prima</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Modulo: Materia Prima</a></li>
        <li class="active">Editar</li>
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
                    <input name="_token" type="hidden" id="_token" value="{{ csrf_token() }}" />
                    <input name="idIMP" type="hidden" id="idIMP" value="{{ $id }}" />
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>PRODUCTOR</label>
                            <input class="form-control input-sm" value="AGRO EXPORTACIONES GRACE S.A.C." type="text" disabled>
                        </div>
                        <div class="form-group">
                            <label>CHOFERES: @{{ conductores.length }}</label><br>
                            <button class="btn btn-success"  v-on:click="addChoferes()">
                                Agregar  choferes <i class="fa fa-users"></i>
                            </button>

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>GUIA TRANSPORTISTAS</label>
                            <input class="form-control input-sm" id="selGuiaTransportistas"  type="text" >
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
                            <input class="form-control timepicker" type="text" id="h_inicio">

                        </div>
                        <div class="form-group">
                            <label>H. FIN</label>
                            <input class="form-control timepicker" type="text" id="h_fin">
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
                    <li><a data-toggle="tab" href="#menu1"  v-on:click="generateDetDescarte()">DETALLE DESCARTE</a></li>
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
                                        <th>F.</th>
                                        <th>P.</th>
                                        <th>Variedad</th>
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
                                        <td><input v-model="item.n_guia" class="form-control input-sm" type="text" maxlength="12"></td>
                                        <td><input v-model="item.fundo" style="width: 3em" class="form-control input-sm" type="text" v-on:keyup="validateInput(item.correlativo,item.fundo,'number','2')"></td>
                                        <td><input v-model="item.parron" style="width: 3em" class="form-control input-sm" type="text" v-on:keyup="validateInput(item.correlativo,item.parron,'number','2')"></td>
                                        <td>
                                            <select class="form-control input-sm" v-model="item.variedad">
                                                <option value="Superior">Superior</option>
                                                <option value="Red Globe">Red Globe</option>
                                                <option value="Crimson">Crimson</option>
                                            </select>
                                        </td>
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
                                        <th>F/P</th>
                                        <th>Variedad</th>
                                        <th>Racimo</th>
                                        <th>KL</th>
                                        <th>Baya</th>
                                        <th>KL</th>
                                        <th>Total</th>
                                        <th>%</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for=" item in detalleDescarte" >
                                        <td>@{{ item.correlativo }}</td>
                                        <td><input v-model="item.fundo_parron" class="form-control input-sm" type="text"></td>
                                        <td><input v-model="item.variedad" step="any" min="0.00" class="form-control input-sm" type="text"></td>
                                        <td><input v-model="item.racimo" step="any" min="0.00" class="form-control input-sm" type="text"></td>
                                        <td><input v-model="item.kl_racimo" step="any" min="0.00" class="form-control input-sm" type="text"></td>
                                        <td><input v-model="item.baya" step="any" min="0.00" class="form-control input-sm" type="text"></td>
                                        <td><input v-model="item.kl_baya" step="any" min="0.00" class="form-control input-sm" type="text"></td>
                                        <td><input v-model="item.total" step="any" min="0.00" class="form-control input-sm" type="text"></td>
                                        <td><input v-model="item.porcentaje" step="any" min="0.00" class="form-control input-sm" type="text"></td>

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

                <button class="btn btn-success btn-lg"  v-on:click="saveData()"> <i class="fa fa-floppy-o fa-lg"></i> Guardar</button>
            <!--   @{{ $data }} -->
            </pre>

        </div>



        <div id="modalTrbajadores" class="modal fade bs-example-modal-lg"  role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="row">
                        <div class="col-xs-6">

                            <div class="box box-default">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Personal </h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">

                                    <div class="row">
                                        <div class="col-xs-7">
                                            <label>Chofer</label>
                                            <select class="form-control select2" style="width: 100%" id="selChofer">
                                            </select>
                                        </div>
                                        <div class="col-xs-3">
                                            <label>Placa</label>
                                            <input class="form-control" id="n_placa" type="text">
                                        </div>
                                        <div class="col-xs-2">

                                            <br>
                                            <button class="btn btn-primary btn-sm" v-on:click="addNewChofer()">></button>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <!-- /.box-body -->

                            </div>

                        </div>
                        <div class="col-xs-6">

                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Conductores </h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td>DNI</td>
                                            <td>Chofer</td>
                                            <td>Placa</td>
                                        </tr>
                                        <tr v-for=" (item, index) in conductores" >
                                            <td>@{{ item.dni }}</td>
                                            <td>@{{ item.chofer }}</td>
                                            <td>@{{ item.placa }}</td>
                                            <td><button class="btn btn-danger btn-sm" v-on:click="quitChofer(index)"><</button></td>
                                        </tr>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>






        </div>
        <!-- /.row (Row Filter) -->



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
                item.id = item.EMPLEADO;
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

            $('#datepicker').datepicker({
                format: 'dd/mm/yyyy'
            });

            //Timepicker
            $(".timepicker").timepicker({
                showInputs: false
            });


        }

    </script>



    <!-- vue JS -->
    <script  src="{{asset('js/vue.js')}}"></script>

    <script>


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
                ],
                conductores:[ ],
                detalleDescarte:[]

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


                },
                addChoferes:   function () {

                    $("#modalTrbajadores").modal('show');

                },
                addNewChofer: function () {

                    var dni  = $("#selChofer").val();
                    var placa = $('#n_placa').val();
                    var bandera = 0;
                    var chofer = $("#selChofer option:selected").html();

                    this.conductores.forEach(function (element, index) {

                        if(element.dni == dni || element.placa == placa){
                            bandera = 1;
                        }

                    });

                    if(bandera==0){
                        chofer = {
                            dni:dni,
                            placa:placa,
                            chofer:chofer
                        };

                        this.conductores.push(chofer);
                    }else{
                        alert('ya se encuentra ingresado un dato');
                    }

                },
                quitChofer: function (index) {

                    var r = confirm("Seguro que quieres eliminar esta fila ?");
                    if (r == true) {

                        this.conductores.splice(index, 1);
                    }

                },
                cambio : function (variedad,fundo,parron) {

                    //primero buscmos la variedad en el detalle descarte



                    var bandera = 0;


                    this.detalleDescarte.forEach(function (item,key) {

                        if(item.fundo_parron == fundo+'/'+parron && item.variedad == variedad ){

                            bandera = 1;
                        }
                    });

                    if(bandera == 0){

                        var detail_descarte = {
                            fundo_parron:fundo+'/'+parron,
                            variedad:variedad,
                            racimo:0,
                            kl_racimo:0,
                            baya:0,
                            kl_baya:0,
                            total:0,
                            porcentaje:0

                        };

                        this.detalleDescarte.push(detail_descarte);

                    }
                },
                generateDetDescarte: function () {

                    var res = confirm('Desea generar ');
                    var detallesDescarte = this.detalleDescarte;

                    if(res){


                        //limpiamos el array

                        var cant_descarte = detallesDescarte.length;

                        detallesDescarte.splice(0,cant_descarte);


                        this.detallesUva.forEach(function (item,key) {


                            var fundo = item.fundo;
                            var parron  = item.parron;
                            var variedad  = item.variedad;

                            if(fundo.length >0 &&  parron.length >0 ){
                                var bandera = 0;

                                detallesDescarte.forEach(function (itemDes,keyDes) {

                                    if(itemDes.fundo_parron == fundo+'/'+parron && itemDes.variedad == variedad ){

                                        bandera = 1;
                                    }
                                });
                            }
                            if(bandera == 0){

                                var detail_descarte = {
                                    fundo_parron:fundo+'/'+parron,
                                    variedad:variedad,
                                    racimo:0,
                                    kl_racimo:0,
                                    baya:0,
                                    kl_baya:0,
                                    total:0,
                                    porcentaje:0

                                };
                                detallesDescarte.push(detail_descarte);
                            }
                        });

                    }

                },
                saveData: function () {


                    var conductores = this.conductores ;
                    var cabecera  = {};
                    var detalle_uva = this.detallesUva;
                    var detalle_descarte = this.detalleDescarte;
                    var ruta = "{{URL::route('materiaPrimaStoreNew')}}";


                    var valid = this.validateForm();

                    console.log(valid);

                    if(valid.bandera == 0){

                        var fecha = $('#datepicker').val();
                        fecha = fecha.split('/');
                        fecha = fecha[2]+'/'+fecha[1]+'/'+fecha[0];


                        cabecera = {

                            guia_transportista: $('#selGuiaTransportistas').val(),
                            responsable: $('#selResponsable').val(),
                            controlador: $('#selControlador').val(),
                            fecha: fecha,
                            h_inicio: $('#h_inicio').val(),
                            h_fin: $('#h_fin').val()

                        };

                        $.post( ruta,
                                {
                                    _token: $('#_token').val(),
                                    conductores: conductores,
                                    cabecera:cabecera,
                                    detalle_uva: detalle_uva,
                                    detalle_descarte : detalle_descarte
                                })
                                .done(function( data ) {

                                    console.log(data);

                                }).fail(function(error) {

                            console.log(error); });


                    }else{
                        alert('Error en :'+valid.mensaje);
                    }

                },
                validateForm:function () {

                    var response = {
                        bandera:0,
                        mensaje:''

                    };

                    var conductores = this.conductores ;
                    var detalle_uva = this.detallesUva;
                    var detalle_descarte = this.detalleDescarte;

                    if(conductores.length < 1){
                        response.bandera = 1;
                        response.mensaje = '';
                    }

                    return response;


                }
            },
            mounted:function () {

                var ruta = "{{ route('apiGetIMPById',['id'=>$id]) }}";

                var v_obj = this;

                $.getJSON( ruta, function( data ) {

                    console.log(data);

                    var fecha = data.fecha.split('-');
                    fecha = fecha[2]+'/'+fecha[1]+'/'+fecha[0];


                    v_obj.detallesUva = data.detalle_uva;
                    v_obj.conductores = data.detalle_chofer;
                    v_obj.detalleDescarte = data.detalle_descarte;

                    $("#selGuiaTransportistas").val(data.guia_transportista);
                    $("#selResponsable").val(data.dni_responsable).trigger('change.select2');
                    $("#selControlador").val(data.dni_controlador).trigger('change.select2');
                    $("#datepicker").val(fecha);
                    $("#h_inicio").val(data.h_inicio);
                    $("#h_fin").val(data.h_fin);



                });


            }

        });

    </script>

@stop