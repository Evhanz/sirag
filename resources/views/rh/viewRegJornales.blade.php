@extends('layout')

@section('content-header')

    <div class="row" id="alertError">
        <br>
       <div class="col-lg-12">
           <div class="alert alert-danger alert-dismissable">
               <i class="fa fa-ban"></i>
               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
               <b>Error!! :</b> <span id="txtError"></span>
           </div>
       </div>
    </div>

@stop

@section('content')

    <script type="text/javascript" src="{{ asset('js/plugins/table2excel/jquery.table2excel.min.js') }} "></script>


    <div ng-app="app" ng-controller="PruebaController">
        <div class="content"  >
            <input type="hidden" id="_token" value="{{ csrf_token() }}" />

            <div class="row" style="padding-left: 15px; padding-right: 15px;">
                <!-- Box (with bar chart) -->
                <div class="box box-default" >
                    <div class="box-header">
                        <ul class="nav nav-tabs" id="tab_filtros">
                            <li class="active"><a data-toggle="tab" href="#home">Jornales</a></li>
                        </ul>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">

                        <div class="tab-content">
                            <div id="home" class="tab-pane fade in active" style="padding: 20px">
                                <div class="row">

                                    <div class="col-lg-2">
                                        <label for="">Código de trabajador</label><br>
                                        <input class="form-control" id="codigo_trabajador" type="text">
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="">Fecha</label>
                                        <input class="form-control" name="daterange" id="reservation" type="text">
                                    </div>
                                    <div class="col-lg-3">

                                        <button class="btn btn-info" id="btnBuscar" ng-click="buscarData()">Buscar</button>
                                        <button ng-model="btnNuevo" class="btn btn-success" id="btnNuevo" ng-click="newRegDetails()"> <i class="fa fa-disk"></i> Nuevo </button>
                                        <!-- <button class="btn btn-info" id="btnGuardar" disabled> <i class="fa fa-disk"></i> Guardar </button>-->

                                    </div>
                                    <div class="col-lg-3"></div>



                                </div>
                            </div>
                            <!-- Tab filtro documento -->
                            <div id="menu1" class="tab-pane fade">
                                <h3>Menu 1</h3>
                                <p>Some content in menu 1.</p>

                                <label>Date range:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input class="form-control " name="daterange" id="reservation" type="text">
                                </div><!-- /.input group -->


                            </div>
                        </div>

                    </div><!-- /.box-body -->
                    <div class="box-footer">

                    </div><!-- /.box-footer -->
                </div><!-- /.box -->



            </div>

            <div class="row" id="dataInsert">
                <div class="col-lg-12">
                    <!-- Box (with bar chart) -->
                    <div class="box box-info" id="box_maestro">
                        <div class="box-header">
                            <!-- tools box -->
                        </div><!-- /.box-header -->
                        <div class="box-body ">

                            <div class="row" id="details">
                                <div class="col-lg-12">

                                    <table class="table table-bordered" id="data">
                                        <thead>
                                        <tr>
                                            <td rowspan="2">E</td>
                                            <td rowspan="2">N°</td>
                                            <td rowspan="2">Fecha</td>
                                            <td rowspan="2">Trabajador</td>
                                            <td rowspan="2">Centro de Costo Interno</td>
                                            <td colspan="4" style="text-align: center">TIPO DE LABOR</td>
                                        </tr>
                                        <tr>

                                            <td>Labor</td>
                                            <td>Turno</td>
                                            <td>Codigo Actividad</td>
                                            <td>Horas</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr ng-repeat="item in detalles">
                                            <td><button ng-click="deleteDetail($index)" class="btn btn-danger btn-xs">X</button></td>
                                            <td>@{{ $index + 1 }}</td>
                                            <td>
                                                <input ng-init="prueba($index)" ng-change="item.ficha='';item.trabajador=''" id="fecha@{{$index}}" ng-model="item.fecha" class="fecha" style="width: 65px" ng-click="clickFecha()" pattern="\d{1,2}-\d{1,2}-\d{4}">
                                            </td>
                                            <!--Ficha del trabajador -->
                                            <td>
                                                <button class="btn btn-default btn-xs" title="buscar Trabajador" ng-click="getModEmpleado($index)">
                                                    ...</button>
                                                <!-- data-type="number" data-max ="6" -->
                                                <input  ng-model="item.ficha"  style="width: 3.5em"  ng-keyup="getTrabajador($event,item.ficha,item,$index)">
                                                <input  ng-model="item.trabajador" type="text" disabled  style="width: 10em;">
                                            </td>
                                            <td>
                                                <button class="btn btn-default btn-xs" ng-click="getModCCostoInterno($index)">...</button>
                                                <input  ng-model="item.cci" style="width: 3.5em" ng-keyup="getCciByCodigo($event,item.cci,item)">
                                                <input  ng-model="item.descCci" type="text" disabled  style="width: 8em">

                                            </td>
                                            <td>
                                                <input ng-model="item.codigo" ng-keyup="getLabor($event,item.codigo,item)" style="width: 3em;" type="text">
                                                <input style="width: 12em;" type="text" ng-model="item.labor_desc" disabled>
                                            </td>
                                            <td><input style="width: 3em;" type="text" disabled >
                                            </td>
                                            <td>
                                                <select name="" id="" ng-model="item.actividad">
                                                    <option value="">-----------------------</option>
                                                    <option ng-repeat="item in codigoActividad" value="@{{ item.value }}">
                                                        @{{ item.codigo }}
                                                    </option>
                                                </select>
                                            </td>
                                            <td>
                                                <input ng-model="item.hora" class="hora" id="hora@{{ $index }}" style="width: 7em;" type="text" ng-keyup="addLine($event,$index)" >
                                            </td>

                                        </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>

                        </div><!-- /.box-body -->



                    </div><!-- /.box -->

                </div>

            </div>
            <div class="row" id="dataShow">
                <div class="col-lg-12">
                    <!-- Box (with bar chart) -->
                    <div class="box box-info" id="box_maestro">
                        <div class="box-header">
                            <!-- tools box -->
                        </div><!-- /.box-header -->
                        <div class="box-body ">

                            <div class="row" id="details">
                                <div class="col-lg-12">

                                    <table class="table table-bordered" id="data">
                                        <thead>
                                        <tr>
                                            <td rowspan="2">E</td>
                                            <td rowspan="2">N°</td>
                                            <td rowspan="2">Fecha</td>
                                            <td rowspan="2">Trabajador</td>
                                            <td rowspan="2">Centro de Costo Interno</td>
                                            <td colspan="4" style="text-align: center">TIPO DE LABOR</td>
                                        </tr>
                                        <tr>

                                            <td>Labor</td>
                                            <td>Turno</td>
                                            <td>Codigo Actividad</td>
                                            <td>Horas</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr ng-repeat="item in dataSelect">
                                            <td><button ng-click="deleteDetailShow($index)" class="btn btn-danger btn-xs">X</button></td>
                                            <td>@{{ $index + 1 }}</td>
                                            <td>@{{item.fecha}}</td>
                                            <td>@{{ item.nombre }}</td>
                                            <td>@{{ item.cci }}</td>
                                            <td>@{{ item.codigo }}</td>
                                            <td>-</td>
                                            <td>@{{ item.actividad }}</td>
                                            <td>@{{ item.hora }}</td>


                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>
            </div>
        </div>


        <!-- modal modPersonal-->
        <div class="modal fade " id="modPersonal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" >
                <div class="modal-content">
                    <div class="modal-header">

                        <h4>Búqueda de trabajadores</h4>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                    </div>
                    <div class="modal-body" >

                        <input type="hidden" id="indexModPersonal">

                        <div class="row">

                            <div class="col-xs-12">
                                <table class="table table-bordered" id="dataModPersonal">
                                    <thead>
                                    <tr>
                                        <td><input type="text" ng-model="filModEmpleado.ficha"></td>
                                        <td><input type="text" ng-model="filModEmpleado.EMPLEADO"></td>
                                        <td><input type="text" ng-model="filModEmpleado.nombre"></td>
                                    </tr>
                                    <tr>
                                        <th>Ficha</th>
                                        <th>Empleado</th>
                                        <th>Nombre</th>
                                        <th>*</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr ng-repeat="item in modPersonal | filter:filModEmpleado">

                                        <td>@{{item.ficha}}</td>
                                        <td>@{{item.EMPLEADO}}</td>
                                        <td>@{{item.nombre}}</td>
                                        <td><button class="btn btn-default btn-xs" ng-click="selectTrabajador(item)"><i class="fa fa-eye"></i></button></td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>


                        </div>



                    </div>

                    <div class="modal-footer">
                    </div>

                </div>
            </div>
        </div>
        <!--./ modal Detail-->

        <!-- modal modPersonal-->
        <div class="modal fade " id="modCCostoInterno" tabindex="-1" role="dialog">
            <div class="modal-dialog " >
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4>Búqueda de Centro Costo Interno</h4>
                    </div>
                    <div class="modal-body" >

                        <div class="row">

                            <input type="hidden" id="idCodigoCCI">

                            <div class="col-xs-12">
                                <table class="table table-bordered" id="dataModPersonal">
                                    <thead>
                                    <tr>
                                        <td><input type="text" ng-model="filModCCI.CODIGO"></td>
                                        <td><input type="text" ng-model="filModCCI.DESCRIPCION"></td>
                                    </tr>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Descripcion</th>
                                        <th>*</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr ng-repeat="item in modCCostoInterno | filter:filModCCI">
                                        <td>@{{item.CODIGO}}</td>
                                        <td>@{{item.DESCRIPCION}}</td>
                                        <td><button class="btn btn-default btn-xs" ng-click="selectCCI(item)"><i class="fa fa-eye"></i></button></td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>


                        </div>



                    </div>

                    <div class="modal-footer">
                    </div>

                </div>
            </div>
        </div>
        <!--./ modal Detail-->
    </div>




    <!-- Daterangepicker css -->
    <link rel="stylesheet" href="{{asset('css/daterangepicker/daterangepicker-bs3.css')}}">
    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>

    <!-- datepicker -->
    <script src="{{asset('templates/lte2/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{asset('templates/lte2/plugins/datepicker/datepicker3.css')}}">


    <script src="{{ asset('js/plugins/angular/ui-bootstrap-tpls-0.12.1.min.js') }}"></script>
    <script>

        /*funciones de jquery*/

        $('input[name="daterange"]').daterangepicker({
            format : "DD/MM/YYYY"
        });


        $('[data-toggle="tooltip"]').tooltip();
        $('#alertError').hide();


        $('#dataInsert').hide();
        $('#dataShow').hide();

        /*
         $(document).ready(function(){

         });*/

        $("*[data-type='number']").keyup(function (event) {
            //console.log("El código de la tecla " + String.fromCharCode(event.which) + " es: " + event.which);
            var len_max = $(this).data("max");
            var value_input = $(this).val();
            var key_up_press = String.fromCharCode(event.which);

            if(!isNaN(key_up_press)){
                if(value_input.length > len_max){

                    value_input= value_input.substr(0,len_max);
                }

                $(this).val(value_input);

            }else{
                var bandera = value_input.charAt(value_input.length-1);
                if(isNaN(bandera)){
                    $(this).val(value_input.substr(0,(value_input.length-1)));
                     alert('Solo se permiten numeros');
                }
            }
            //console.log(value_input);

        });


        function print_excel() {


            $("#table_data_op1").table2excel({
                exclude: ".noExl",
                name: "export_personal",
                filename: "export_personal",
                fileext: ".xls",
                exclude_img: true,
                exclude_links: true,
                exclude_inputs: true
            });

        }

        /*----*/


        var app = angular.module("app", ['ui.bootstrap']);
        app.controller("PruebaController", function($scope,$http,$window) {


            //traer la data por el click
            $scope.jornales = [];
            $scope.modPersonal = [];
            $scope.codigoActividad = [];
            $scope.detalles = [];
            $scope.dataSelect = [];

            getCodigoActividad();


            $scope.getModEmpleado = function (index) {

                $("#modPersonal").modal('show');

                var token = $('#_token').val();
                $("#indexModPersonal").val(index);

                $http.get('{{ URL::route('getAllTrabajadores') }}',
                        {   _token : token

                        })
                        .success(function(data){

                            $scope.modPersonal = data;
                            //console.log( data);

                        }).error(function(data) {
                    console.log(data);

                    alert('Error: :>');
                });
            };

            $scope.getModCCostoInterno = function (index) {

                $("#modCCostoInterno").modal('show');

                $("#idCodigoCCI").val(index);


                var token = $('#_token').val();

                $http.get('{{ URL::route('getCentroCostoInterno') }}',
                        {   _token : token

                        })
                        .success(function(data){

                            $scope.modCCostoInterno = data;
                            //console.log( data);

                        }).error(function(data) {
                    console.log(data);

                    alert('Error: :>');
                });
            };

            $scope.getLabor = function(evento,codigo,item){

                var token = $('#_token').val();

                if(evento.keyCode == 13){

                    $http.post('{{ URL::route('getLaborByCodigo') }}',
                            {   _token : token,
                                codigo  : codigo
                            })
                            .success(function(data){


                                //console.log( data);

                                if(data == 0){
                                    alert('Valor no Encontrado');
                                }else{
                                    item.labor_desc = data.DESCRIPCION;
                                    //console.log( data);
                                }


                            }).error(function(data) {
                        console.log(data);

                        alert('Error: :>');
                    });
                }
            };

            function getCodigoActividad(){

                $http.get('{{ URL::route('CodigoActividad') }}')
                        .success(function(data){

                            //console.log( data);

                           $scope.codigoActividad = data;


                        }).error(function(data) {
                    console.log(data);

                    alert('Error: :>');
                });
            }

            $scope.newRegDetails = function () {

                var detail = {};

                $("#btnNuevo").attr('disabled',true);
                $("#btnGuardar").attr('disabled',false);

                $('#dataInsert').show();
                $('#dataShow').hide();

                $scope.detalles.push(detail);

            };

            $scope.loadFecha = function () {

              //  alert('as');

                $('.datepicker').datepicker({
                    format: 'dd/mm/yyyy'
                });


            };

            $scope.selectTrabajador = function (item) {


                var position = $("#indexModPersonal").val();


                $scope.detalles[position].ficha = parseInt(item.ficha);
                $scope.detalles[position].trabajador = item.nombre;
                $scope.detalles[position].dni = item.EMPLEADO;


                if($scope.detalles[position].fecha !== undefined){

                    //console.log(getFotmatDate(item.fecha));

                    if(getFotmatDate($scope.detalles[position].fecha)== 0){
                        var token = $('#_token').val();
                        var f = $scope.detalles[position].fecha.split('-');
                        f = f[2]+''+f[1]+''+f[0];


                        $http.post('{{ URL::route('getMarcacionDICONTrabajadorByFecha') }}',
                                {   _token   : token,
                                    dni      : item.EMPLEADO,
                                    fecha    : f
                                })
                                .success(function(data){

                                    if(data == 0){
                                        alert('No se encuentra registrado en el DICON el valor');
                                        $scope.detalles[position].fecha = '';
                                        $scope.detalles[position].trabajador = '';
                                        $scope.detalles[position].ficha = '';
                                        $("#fecha"+(index)).focus();
                                    }else {

                                    }

                                }).error(function(data) {
                            console.log(data);

                            alert('Error: :>');
                        });
                    }else{
                        alert('corrige la fecha de esta fila');
                    }

                }
                else{
                    $scope.detalles[position].ficha ='';
                    $scope.detalles[position].trabajador = '';
                    $scope.detalles[position].dni = '';
                    alert('debe agregar una fecha correcta');
                }


                $("#modPersonal").modal('hide');
            };


            $scope.getTrabajador = function(evento,ficha,item,index){

                var dni = '';
                var ruta = '{{ URL::route('modRH') }}/api/getTrabajadorBy/'+ficha;
                if(evento.keyCode == 13){

                    $http.get(ruta)
                            .success(function(data){

                                if(data == 0){
                                    alert('Valor no Encontrado');
                                }else{
                                    item.trabajador = data.NOMBRE;
                                    item.dni    = data.EMPLEADO;
                                    dni    = data.EMPLEADO;


                                    if(item.fecha !== undefined){

                                        //console.log(getFotmatDate(item.fecha));

                                        if(getFotmatDate(item.fecha)== 0){
                                            var token = $('#_token').val();
                                            var f = item.fecha.split('-');
                                            f = f[2]+''+f[1]+''+f[0];

                                            $http.post('{{ URL::route('getMarcacionDICONTrabajadorByFecha') }}',
                                                    {   _token   : token,
                                                        dni      : item.dni,
                                                        fecha    : f
                                                    })
                                                    .success(function(data){

                                                        if(data == 0){
                                                            alert('No se encuentra registrado en el DICON el valor');
                                                            item.fecha = '';
                                                            item.trabajador = '';
                                                            item.ficha = '';
                                                            $("#fecha"+(index)).focus();
                                                        }else {

                                                        }

                                                    }).error(function(data) {
                                                console.log(data);

                                                alert('Error: :>');
                                            });
                                        }else{
                                            alert('corrige la fecha de esta fila');
                                        }


                                    }


                                }
                            }).error(function(data) {
                        console.log(data);
                        alert('Error: :>');
                    });


                }
            };

            $scope.getCciByCodigo = function (evento,codigo,item) {
                var ruta = '{{ URL::route('modContabilidad') }}/api/getCciByCodigo/'+codigo;

                if(evento.keyCode == 13){

                    $http.get(ruta)
                            .success(function(data){

                                if(data == 0){
                                    alert('Valor no Encontrado');
                                }else{
                                    item.descCci = data.DESCRIPCION;
                                    item.ubigeo = data.TEXTO1;
                                }


                            }).error(function(data) {
                        console.log(data);

                        alert('Error: :>');
                    });
                }
            };


            $scope.selectCCI = function (item) {

                var position = $("#idCodigoCCI").val();

                $scope.detalles[position].cci = item.CODIGO;
                $scope.detalles[position].descCci = item.DESCRIPCION;
                $scope.detalles[position].ubigeo = item.TEXTO1;

                $("#modCCostoInterno").modal('hide');
            };

            $scope.deleteDetail = function (item) {

                var r = confirm("Está seguro que eliminará ");
                if (r == true) {

                    var value = $scope.detalles[item];
                    var token = $('#_token').val();
                    var ruta = '{{URL::route('deleteJornales')}}';

                    $http.post(ruta,{
                        _token   : token,
                        item:value
                    })
                            .success(function (data) {
                                $scope.detalles.splice(item,1);
                                console.log(data);

                            })
                            .error(function (error) {
                                alert('error');
                            });


                    if($scope.detalles.length == 0){
                        $("#btnNuevo").attr('disabled',false);
                        $("#btnGuardar").attr('disabled',true);
                    }

                } else {

                }





            };


            $scope.deleteDetailShow = function (item) {

                var r = confirm("Está seguro que eliminará ");
                if (r == true) {

                    var value = $scope.dataSelect[item];
                    var token = $('#_token').val();
                    var ruta = '{{URL::route('deleteJornales')}}';

                    $http.post(ruta,{
                        _token   : token,
                        item:value
                    })
                            .success(function (data) {
                                $scope.dataSelect.splice(item,1);
                                console.log(data);

                            })
                            .error(function (error) {
                                alert('error');
                            });


                    if($scope.detalles.length == 0){
                        $("#btnNuevo").attr('disabled',false);
                        $("#btnGuardar").attr('disabled',true);
                    }

                } else {

                }





            };


            $scope.addLine  = function (evento,index) {


                //9: es la tecla tab
                if( evento.keyCode == 9){

                    if($scope.detalles.length == (index+1)){
                        var detail = {};
                        $scope.detalles.push(detail);
                    }
                }

                //13: es para el enter
                if(evento.keyCode == 13 ){

                    var item = $scope.detalles[index];

                    var bandera = validarItem(item);

                    if($scope.detalles.length == (index+1)){
                        var detail = {};
                        $scope.detalles.push(detail);

                    }


                    //quiere decir que hay un error
                    if(bandera== 1){


                        $("#alertError").show();
                        $("#alertError").delay(6000).hide(600);

                    }else{

                        var usr = $('#nameUser').text();
                        //console.log($scope.detalles[index]);
                        $("#fecha"+(index+1)).focus();
                        var token = $('#_token').val();
                        $scope.detalles[index].user = usr;
                        $('#hora'+index).attr('disabled',true);


                        $http.post('{{ URL::route('regJornales') }}',
                                {   _token   : token,
                                    detalle  : $scope.detalles[index]
                                })
                                .success(function(data){

                                   if(data.res == '200'){
                                       //------

                                       $("#fecha"+(index+1)).focus();



                                   }else{
                                       alert('Error:'+data.mensaje);
                                       $('#hora'+index).attr('disabled',false);
                                   }

                                })
                                .error(function(data) {
                                    $('#hora'+index).attr('disabled',false);
                                    console.log(data);

                                    alert('Error: :>');
                        });


                    }
                }
            };

            $scope.prueba = function (index) {
                var bandera = index +1;
                $("#fecha"+(bandera)).focus();
            };



            function validarItem(item) {

                var bandera = 0 ;
                var mensaje = '';

                try{

                    if (getFotmatDate(item.fecha)==1){
                        bandera = 1;
                        mensaje += 'La fecha no tiene un formato adecuado \n';
                    }

                    if(item.ficha.length <= 0 || item.ficha === undefined){
                        bandera = 1;
                        mensaje = mensaje + ' La ficha no ha sido ingresada \n';
                    }

                    if(item.cci.length <= 0 || item.cci === undefined){
                        bandera = 1;
                        mensaje = mensaje + ' El codigo cci no ha sido ingresada \n';
                    }

                    if((item.codigo.length <= 0 || item.codigo === undefined) &&
                            (item.labor_desc.length <= 0 || item.labor_desc === undefined)) {
                        bandera = 1;
                        mensaje = mensaje + ' La Codigo de Labor no ha sido ingresada \n';
                    }
                    if(item.actividad.length <= 0 || item.codigo === undefined) {
                        bandera = 1;
                        mensaje = mensaje + ' La Codigo de actividad no ha sido ingresada \n';
                    }

                    if(item.hora.length <= 0 || item.hora === undefined || item.hora < 0 ) {
                        bandera = 1;
                        mensaje = mensaje + ' La Codigo de actividad no ha sido ingresada \n';
                    }

                }catch (err){
                    bandera=1;
                    mensaje += "Emos detectado lo siguiente- \n La linea que desea ingresar contiene errores en su ingreso," +
                            "reingrese todo los campos para continuar , gracias ";
                }


                if(bandera == 1){
                    $("#txtError").text(mensaje+'ass');
                }

                return bandera;

            }



            $scope.buscarData = function () {


                $("#btnBuscar").attr('disabled',true);

                var fecha = $('input[name="daterange"]').val();

                if(fecha.length > 0 || fecha != null){
                    fecha = fecha.split('-');
                    var f_i = changeFormat(fecha[0]);
                    var f_f = changeFormat(fecha[1]);

                    var token = $('#_token').val();
                    var codigo = $('#codigo_trabajador').val();

                    if(codigo.length < 1 || codigo == null){

                        codigo = '';

                    }


                    $http.post('{{URL::route('getJornalesByFechas')}}',{
                        _toke:token,
                        f_i : f_i,
                        f_f : f_f,
                        codigo: codigo

                    })
                    .success(function (data) {
                        console.log(data);
                        $scope.dataSelect = data;
                        $("#btnBuscar").attr('disabled',false);
                        $("#btnNuevo").attr('disabled',false);

                    })
                    .error(function (error) {
                        console.log(error);
                        $("#btnBuscar").attr('disabled',false);
                        $("#btnNuevo").attr('disabled',false);
                    });



                    $('#dataInsert').hide();
                    $('#dataShow').show();

                }else{

                    alert('Agrega uan fecha ');

                }


               // $("#btnBuscar").attr('disabled',false);

            };


            /**
             * esta funcion averigua si tiene un formato fecha
             */

            function getFotmatDate(cadena) {

                if(cadena  === undefined){
                    cadena = '';
                }

                cadena = cadena.split('-');
                var bandera = 0;

                if(cadena.length!=3){
                    bandera = 1;
                }

                if((cadena[0]<1 || cadena[0]>31) ){
                    bandera = 1;
                }

                if((cadena[1]<1 || cadena[1]>12) ) {
                    bandera = 1;
                }

                if( cadena[0].length == 1 || cadena[1].length == 1){
                    bandera = 1;
                }



                if(cadena[2]<1998 || cadena[2]>2100){
                    bandera = 1;
                }

                return bandera;
            }


            //cmabiar de ddmmyyyy a yyyyddmm
            function changeFormat(date) {

                date  = date.split('/');
                date = date[2]+'-'+date[0]+'-'+date[1];

                return date;

            }




        });
    </script>

    <style>
        #details{
            font-size: 12px;
        }
        #data thead tr td{
            text-align: center;
            vertical-align: middle;
            font-size: 12px;
            font-weight: bold;
        }

        #dataModPersonal > thead > tr > th{
            background-color: #49829E;
            color: white;

        }

        #dataModPersonal > thead > tr > th{
            background-color: #49829E;
            color: white;

        }


        #dataModPersonal > tbody{


        }

        #dataModPersonal {


        }

        .modal-lg{
            width: 900px;
        }

        .modal-body{
            height: 350px!important;
            overflow: auto;

        }





    </style>


@stop