@extends('layout')

@section('content-header')



    @if((session('status'))!=null)
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

@stop

@section('content')

    <script type="text/javascript" src="{{ asset('js/plugins/table2excel/jquery.table2excel.min.js') }} "></script>


    <div ng-app="app" ng-controller="PruebaController">
        <div class="content"  >


            <div class="row" style="padding-left: 15px; padding-right: 15px;">
                <!-- Box (with bar chart) -->
                <div class="box box-default" >
                    <div class="box-header">
                        <ul class="nav nav-tabs" id="tab_filtros">
                            <li class="active"><a data-toggle="tab" href="#home">Jornales</a></li>
                            <li ><a data-toggle="tab" href="#dominical">Dominical</a></li>
                            <li ><a data-toggle="tab" href="#feriados">Feriados</a></li>
                        </ul>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">

                        <div class="tab-content">
                            <div id="home" class="tab-pane fade in active" style="padding: 20px">
                                <div class="row">

                                    <form action="{{route('getExcelJornales')}}" method="post">
                                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
                                        <div class="col-lg-2">
                                            <label for="">Código de trabajador</label><br>
                                            <input class="form-control" name="codigo" id="codigo_trabajador" type="text">
                                        </div>
                                        <div class="col-lg-3">
                                            <label for="">Fecha</label>
                                            <input class="form-control" name="daterange" id="reservation" type="text" required>
                                        </div>
                                        <div class="col-lg-2">
                                            <label for="">Opciones</label><br>
                                            <a class="btn btn-info" id="btnBuscar" ng-click="buscarData()">Buscar</a>
                                            <a ng-model="btnNuevo" class="btn btn-success" id="btnNuevo" ng-click="newRegDetails()"> <i class="fa fa-disk"></i> Nuevo </a>
                                            <!-- <button class="btn btn-info" id="btnGuardar" disabled> <i class="fa fa-disk"></i> Guardar </button>-->

                                        </div>
                                        <div class="col-lg-1">
                                            <label for="">CCI</label>
                                            <input class="form-control" name="cci" id="cci" type="text">
                                        </div>
                                        <div class="col-lg-1">
                                            <label for="">Exportar</label>
                                            <button class="btn btn-success">Excel</button>
                                        </div>

                                    </form>





                                </div>

                                <br><br>

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
                                                                <td rowspan="2" >E</td>
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
                                                                <td style="width: 65px">
                                                                    @if(Auth::user()->hasAnyRole(['ADMIN']) || Auth::user()->USR == 'RFLORES')
                                                                        <button ng-click="deleteDetail($index)" class="btn btn-danger btn-xs">x</button>
                                                                    @endif
                                                                    <button ng-click="updateDetail2($index)" class="btn btn-warning btn-xs" id="btnEdit@{{$index}}" disabled>
                                                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                                    </button>
                                                                </td>

                                                                <td>@{{ $index + 1 }}</td>
                                                                <td>
                                                                    <input ng-init="prueba($index)" ng-keyup="keyFecha($event,$index)" ng-change="item.ficha='';item.trabajador=''" id="fecha@{{$index}}" ng-model="item.fecha" class="fecha" style="width: 65px" ng-click="clickFecha()" pattern="\d{1,2}-\d{1,2}-\d{2}">
                                                                </td>
                                                                <!--Ficha del trabajador -->
                                                                <td>
                                                                    <button class="btn btn-default btn-xs" title="buscar Trabajador" ng-click="getModEmpleado($index)">
                                                                        ...</button>
                                                                    <!-- data-type="number" data-max ="6" -->
                                                                    <input id="ficha@{{$index}}" ng-model="item.ficha" ng-init="item.ficha=''"  style="width: 3.5em"  ng-keyup="getTrabajador($event,item.ficha,item,$index)">
                                                                    <input  ng-model="item.trabajador" ng-init="item.trabajador=''" type="text" disabled  style="width: 16em;">
                                                                </td>
                                                                <td>
                                                                    <button class="btn btn-default btn-xs" ng-click="getModCCostoInterno($index)">...</button>
                                                                    <input id="cci@{{$index}}"  ng-init="item.cci=''" ng-model="item.cci" style="width: 3.5em" ng-keyup="getCciByCodigo($event,item.cci,item,$index)">
                                                                    <input  ng-init="item.descCci=''"  ng-model="item.descCci" type="text" disabled  style="width: 8em">
                                                                </td>
                                                                <td>
                                                                    <input id="codigo@{{$index}}" ng-init="item.codigo=''" ng-model="item.codigo" ng-keyup="getLabor($event,item.codigo,item,$index)" style="width: 3em;" type="text">
                                                                    <input style="width: 12em;" type="text" ng-model="item.labor_desc" ng-init="item.labor_desc=''" disabled>
                                                                </td>
                                                                <td><input style="width: 3em;" type="text" disabled >
                                                                </td>
                                                                <td>
                                                                    <select name="" id="actividad@{{ $index }}" ng-init="item.actividad=''" ng-model="item.actividad" ng-change="changeActividad($index)">
                                                                        <option value="">-----------------------</option>
                                                                        <option ng-repeat="item in codigoActividad" value="@{{ item.value }}">
                                                                            @{{ item.codigo }}
                                                                        </option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input ng-model="item.hora" class="hora" id="hora@{{ $index }}"  ng-init="item.hora=''" style="width: 7em;" type="text" ng-keyup="addLine($event,$index)" >
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
                                                                <td>
                                                                    @if(Auth::user()->hasAnyRole(['ADMIN']) || Auth::user()->USR == 'RFLORES')
                                                                        <button ng-click="deleteDetailShow($index)" class="btn btn-danger btn-xs">X</button>
                                                                    @endif

                                                                    <button ng-click="updateDetail($index)" class="btn btn-warning btn-xs">
                                                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                                    </button>
                                                                </td>
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
                            <!-- Tab filtro documento -->
                            <div id="dominical" class="tab-pane fade">


                                <div class="row" style="padding: 15px">

                                    <div class="col-xs-4">
                                        <label>Colocar Fecha del Lunes que corresponde:</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input id="fecha_dominical" class="form-control datepicker">
                                        </div><!-- /.input group -->
                                    </div>
                                    <div class="col-xs-2">
                                        <label for="">  </label><br>
                                        <button class="btn btn-success" id="btnExecDominical" ng-click="execDominical()">Ejecutar</button>
                                    </div>


                                </div>

                                <div class="row" >
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
                                                            <tr ng-repeat="item in dataDominical">
                                                                <td>@{{ $index + 1 }}</td>
                                                                <td>@{{ item.fecha }}</td>
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

                            <div id="feriados" class="tab-pane fade">

                                <div class="row">
                                    <div class="col-lg-12">
                                        <form action="{{route('regFeriados')}}" method="post" class="form">
                                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
                                            <div class="form-group col-xs-3">
                                                <label for="">Ingrese la fecha de feriado</label>
                                                <input name="fecha" id="periodo_agrario" class="form-control datepicker" required>
                                            </div>
                                            <div class="form-group col-xs-3">
                                                <label for="">&nbsp;</label><br>
                                                <button id="Registrar-" class="btn btn-warning">Registrar Feriados</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div><!-- /.box-body -->
                    <div class="box-footer">

                    </div><!-- /.box-footer -->
                </div><!-- /.box -->



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

        <!--Modal Edit Jornal-->
        <div class="modal fade " id="modEditJornal"  role="dialog">
            <div class="modal-dialog " >
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h2>Editar Jornal: </h2>
                        <span>@{{ jornalEdit.nombre }} , del día  @{{ jornalEdit.fecha }}</span>
                    </div>
                    <div class="modal-body" style="height: auto !important;" >

                        <div class="row">
                            <div >
                                <input type="hidden" id="indexJornal">
                                <div class="form-group">
                                    <div class="col-xs-1">
                                        <label for="">CCI: </label>
                                    </div>

                                    <div class="col-xs-1" >
                                        <!--
                                       <button class="btn btn-default btn-xs" ng-click="getModCCostoInterno($index)">
                                           <i class="fa fa-search"></i>
                                       </button>
                                       -->
                                   </div>

                                    <div class="col-xs-5">
                                        <input class="form-control" id="cci"  ng-model="jornalEdit.cci"  ng-keyup="getCciByCodigo($event,jornalEdit.cci,jornalEdit,$index)">
                                    </div>
                                    <div class="col-xs-5">
                                        <input class="form-control"  ng-model="jornalEdit.descCci" type="text" disabled  >
                                    </div>

                                </div>


                                <span style="height: 20px">&nbsp;</span>


                                <div class="form-group">
                                    <div class="col-xs-1">
                                        <label for="">Labor: </label>
                                    </div>

                                    <div class="col-xs-2">
                                        <input class="form-control" id="codigo" ng-model="jornalEdit.codigo" ng-keyup="getLabor($event,jornalEdit.codigo,jornalEdit,$index)"  type="text">
                                    </div>
                                    <div class="col-xs-4">
                                        <input class="form-control" type="text" ng-model="jornalEdit.labor_desc" disabled>
                                    </div>
                                    <div class="col-xs-1">
                                        <label for="">T.Hora</label>
                                    </div>
                                    <div  class="col-xs-4">
                                        <select class="form-control" name="" id="actividad" ng-model="jornalEdit.actividad" >
                                            <option value="">-----------------------</option>
                                            <option ng-repeat="item in codigoActividad" value="@{{ item.value }}">
                                                @{{ item.codigo }}
                                            </option>
                                        </select>
                                    </div>

                                </div>

                                <span style="height: 20px">&nbsp;</span>

                                <div class="form-group">

                                    <div class="col-xs-1">
                                        Horas:
                                    </div>

                                    <div class="col-xs-2">
                                        <input class="form-control" ng-model="jornalEdit.hora"  type="text"  >

                                    </div>
                                </div>
                                <span style="height: 20px">&nbsp;</span>
                                <hr>

                                <div class="form-group">
                                    <div class="col-xs-8">
                                        <a class="btn btn-info " ng-click="editJornal()"> <i class="fa fa-floppy-o"></i> Guardar  </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- modalError -->
    <div class="modal fade" id="modalError" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #ef404a;color:white">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">ERROR!!!! ... </h4>
                </div>
                <div class="modal-body">
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
                </div>

            </div>
        </div>
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

        $('#periodo_agrario').datepicker({
            format: 'dd/mm/yyyy'
        });


        $('input[name="daterange"]').daterangepicker({
            format : "DD/MM/YYYY"
        });


        $('[data-toggle="tooltip"]').tooltip();
        $('#alertError').hide();


        $('#dataInsert').hide();
        $('#dataShow').hide();

        $('#fecha_dominical').datepicker({
            format: 'dd/mm/yyyy'
        });

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
            $scope.dataDominical =[];
            $scope.jornalSelect = {};
            $scope.jornalEdit = {};


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
            $scope.getLabor = function(evento,codigo,item,index){

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
                                    item.codigo = '';
                                }else{
                                    item.labor_desc = data.DESCRIPCION;
                                    //console.log( data);
                                }


                            }).error(function(data) {
                        console.log(data);

                        alert('Error: :>');
                    });

                   $("#actividad"+index).focus();

                }else{
                    item.labor_desc = '';
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

                if($scope.detalles.length==0){
                    $scope.detalles.push(detail);
                }



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
                        f = '20'+''+f[2]+''+f[1]+''+f[0];


                        $http.post('{{ URL::route('getMarcacionDICONTrabajadorByFecha') }}',
                                {   _token   : token,
                                    dni      : item.EMPLEADO,
                                    fecha    : f
                                })
                                .success(function(data){

                                    if(data == 0){
                                        alert('No hay maarcacion de entrada en  el DICON , de este empleado');
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

                                    if (data.VIGENCIA == 'ACTIVO') {
                                        item.trabajador = data.NOMBRE;
                                        item.dni    = data.EMPLEADO;
                                        dni    = data.EMPLEADO;
                                        if(item.fecha !== undefined){

                                            //console.log(getFotmatDate(item.fecha));

                                            if(getFotmatDate(item.fecha)== 0){
                                                var token = $('#_token').val();
                                                var f = item.fecha.split('-');
                                                f = '20'+''+f[2]+''+f[1]+''+f[0];

                                                $http.post('{{ URL::route('getMarcacionDICONTrabajadorByFecha') }}',
                                                        {   _token   : token,
                                                            dni      : item.dni,
                                                            fecha    : f
                                                        })
                                                        .success(function(data){

                                                            if(data == 0){
                                                                alert('El trbajador no tiene registro en el DICON en la fecha ');
                                                                item.fecha = '';
                                                                item.trabajador = '';
                                                                item.ficha = '';
                                                                $("#fecha"+(index)).focus();
                                                            }else {

                                                                var r = '{{ URL::route('modRH') }}/api/getJefeByFicha/'+ficha;
                                                                $http.get(r).success(function (data) {

                                                                   if(data == 0){

                                                                       alert('El trabajador no tiene registrado el jefe');
                                                                       item.fecha = '';
                                                                       item.trabajador = '';
                                                                       item.ficha = '';
                                                                       $("#fecha"+(index)).focus();
                                                                   }else{

                                                                   }

                                                                }).error(function (error) {

                                                                });

                                                            }

                                                        }).error(function(data) {
                                                    console.log(data);

                                                    alert('Error: :>');
                                                    item.fecha = '';
                                                });
                                            }else{
                                                alert('corrige la fecha de esta fila');
                                            }
                                        }


                                    }else{
                                        alert('El Trabajador no se encuentra activo');
                                    }

                                   

                                }
                            }).error(function(data) {
                        console.log(data);
                        alert('Error: :>');
                        item.fecha = '';

                    });

                    $('#cci'+index).focus();

                }
            };
            $scope.getCciByCodigo = function (evento,codigo,item,index) {
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

                    $("#codigo"+index).focus();
                }else{
                    item.descCci = '';
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
                              //  alert('error');
                                $scope.detalles.splice(item,1);

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

                /*
                if( evento.keyCode == 9){

                    if($scope.detalles.length == (index+1)){
                        var detail = {};
                        $scope.detalles.push(detail);
                    }
                }
                */

                //13: es para el enter
                if(evento.keyCode == 13 ){

                    var item = $scope.detalles[index];

                    var bandera = validarItem(item,index);

                    if($scope.detalles.length == (index+1) && bandera == 0){
                        var detail = {};
                        $scope.detalles.push(detail);
                        console.log(bandera);
                    }


                    //quiere decir que hay un error
                    if(bandera== 1){


                        $("#alertError").show();
                        // $("#alertError").delay(6000).hide(600);

                    }else{

                        var usr = $('#nameUser').text();
                        //console.log($scope.detalles[index]);
                        $("#fecha"+(index+1)).focus();
                        var token = $('#_token').val();
                        $scope.detalles[index].user = usr;
                        $('#hora'+index).attr('disabled',true);
                        $('#cci'+index).attr('disabled',true);
                        $('#codigo'+index).attr('disabled',true);
                        $('#actividad'+index).attr('disabled',true);

                        var opcion = $("#btnEdit"+index).is (':disabled');

                        if(opcion==true){

                            $http.post('{{ URL::route('regJornales') }}',
                                    {   _token   : token,
                                        detalle  : $scope.detalles[index]
                                    })
                                    .success(function(data){

                                        if(data.res == '200'){
                                            //------
                                            $("#fecha"+(index+1)).focus();
                                            $("#btnEdit"+index).attr('disabled',false);
                                            $('#fecha'+index).attr('disabled',true);
                                            $('#ficha'+index).attr('disabled',true);
                                        }else{
                                            alert('Error:'+data.mensaje);
                                            $('#hora'+index).attr('disabled',false);
                                            $('#cci'+index).attr('disabled',false);
                                            $('#codigo'+index).attr('disabled',false);
                                            $('#actividad'+index).attr('disabled',false);
                                        }

                                        console.log('-');
                                        console.log(data);

                                    })
                                    .error(function(data) {
                                        $('#hora'+index).attr('disabled',false);
                                        $('#cci'+index).attr('disabled',false);
                                        $('#codigo'+index).attr('disabled',false);
                                        $('#actividad'+index).attr('disabled',false);
                                        console.log(data);
                                        alert('Error: :>');
                                    });

                        }else{

                            var usr = $('#nameUser').text();


                            var itemAnterior = $scope.jornalSelect;
                            var itemNuevo = $scope.detalles[index];

                            itemAnterior.user = usr;
                            itemNuevo.user = usr;

                            $http.post('{{URL::route('editJornal')}}',{
                                _token:token,
                                itemAnterior: itemAnterior,
                                itemNuevo: itemNuevo
                            }).success(function (data) {


                                //alert('Operacion Correcta');

                                if(data.mensaje == 'ok'){
                                    alert('Operacion Correcta');
                                }else{

                                   // $scope.detalles[index]=itemAnterior;

                                    $scope.detalles[index].hora = itemAnterior.hora;
                                    $scope.detalles[index].cci = itemAnterior.cci;
                                    $scope.detalles[index].descCci = itemAnterior.descCci;
                                    $scope.detalles[index].codigo = itemAnterior.codigo;
                                    $scope.detalles[index].labor_desc = itemAnterior.labor_desc;
                                    $scope.detalles[index].labor_desc = itemAnterior.labor_desc;
                                    $scope.detalles[index].actividad = itemAnterior.actividad;

                                    console.log(data);
                                    alert('Error: '+data.mensaje);
                                }

                            }).error(function (error) {
                                alert('Hubo un error , comuníquese con el area de soporte');
                                console.log(error);
                            });

                        }







                    }
                }
            };

            $scope.prueba = function (index) {
                var bandera = index +1;
                $("#fecha"+(bandera)).focus();

                if(index==0){
                    var f = new Date();
                    var y = f.getFullYear()+'';
                    var d = f.getDate() + '';
                    var m = (f.getMonth() +1) + '';

                    if(d < 10){
                        d = '0'+d+'';
                    }

                    if(m < 10){
                        m = '0'+m+'';
                    }

                    //console.log(y);
                    f_formated = d+'-'+m+'-'+y.substring(2);
                    $scope.detalles[index].fecha=f_formated;
                }else{
                    $scope.detalles[index].fecha=$scope.detalles[index-1].fecha;
                }




            };
            $scope.changeActividad = function (index) {

                $("#hora"+(index)).focus();

            };

            function validarItem(item,index) {

                console.log(item);

                var bandera = 0 ;
                var mensaje = '';

                try{

                    if (getFotmatDate(item.fecha)==1){
                        bandera = 1;
                        mensaje += '- La fecha no tiene un formato adecuado <br>';
                    }

                    if(item.ficha.length <= 0 || item.trabajador.length <= 0 || typeof item.ficha === 'undefined'){
                        bandera = 1;
                        mensaje = mensaje + 'El trabajador no ha sido agregado correctamente  \r\n';
                    }

                    if(item.cci.length <= 0 || item.descCci.length <= 0 || typeof item.cci === 'undefined'){
                        bandera = 1;
                        mensaje = mensaje + ' El codigo cci no ha sido ingresada \r\n';
                    }
                    if(item.codigo.length <= 0 || item.labor_desc.length <= 0 || typeof item.codigo === 'undefined') {
                        bandera = 1;
                        mensaje = mensaje + ' La Labor ha sido ingresada correctamente \r\n';
                    }
                    if(item.actividad.length <= 0 || typeof item.actividad === 'undefined') {
                        bandera = 1;
                        mensaje = mensaje + ' La Codigo de actividad no ha sido ingresada\r\n';
                    }

                    if(item.hora.length <= 0 || typeof item.hora === 'undefined' || item.hora < 0 ) {
                        bandera = 1;
                        mensaje = mensaje + ' La Hora no ha sido ingresada \r\n';
                    }

                    mensaje += "Hemos detectado Errores en la  linea "+(index+1) +"." +
                        "reingrese todo los campos para continuar , gracias :";

                }catch (err){
                    bandera=1;
                    mensaje += "Hemos detectado lo siguiente- \r\n La linea "+(index+1) +" que desea ingresar contiene errores en su ingreso," +
                            "reingrese todo los campos para continuar , gracias :"+err;
                }


                if(bandera == 1){
                    $("#txtError").text(mensaje);
                    console.log(mensaje,bandera);
                    $("#modalError").modal("show");
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
                        //console.log(data);
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
            $scope.keyFecha = function (evento,index) {

                if(evento.keyCode == 13 ){

                    $("#ficha"+index).focus();

                }

            };

            $scope.execDominical = function () {

                $('#btnExecDominical').attr('disabled',true);

                var token = $('#_token').val();
                var fecha_dominical = $('#fecha_dominical').val();//viene en formato dd-mmy-yyy

                fecha_dominical = fecha_dominical.split('/');

                fecha=new Date(fecha_dominical[2]+'-'+fecha_dominical[1]+'-'+fecha_dominical[0]);
                /*
                fecha.setDate(fecha_dominical[0]);
                fecha.setMonth(fecha_dominical[1]);
                fecha.setYear(fecha_dominical[2]);
                */

                var numdia = 0;
                numdia = fecha.getDay();

                if(numdia == 0){


                    //scamos la fecha fin
                    var f_f = sumarDias(fecha,6);
                    f_f = f_f.getFullYear()+'-'+(f_f.getMonth()+1)+'-'+f_f.getDate();
                    var f_i = fecha_dominical[2]+'-'+fecha_dominical[1]+'-'+fecha_dominical[0];

                    $http.post('{{URL::route('processdominical')}}',{
                        _token:token,
                        f_i:f_i,
                        f_f:f_f

                    }).success(function (data) {

                       // console.log(data);
                       // $scope.dataDominical = data ;
                        alert('El proceso a terminado con exito');
                        $scope.dataDominical = data ;

                        $('#btnExecDominical').attr('disabled',false);

                    }).error(function (error) {

                        alert('El proceso tuvo errores , contáctese con el área de sistemas');
                        console.log(error);
                        $('#btnExecDominical').attr('disabled',false);

                    });



                }else{
                    alert('La fecha que ha ingresado , no es correcta para procesar');
                    $('#btnExecDominical').attr('disabled',false);
                }



            };

            /*esto es editar del select en el modal*/
            $scope.updateDetail = function (index) {

                $scope.jornalSelect = {

                    fecha: $scope.dataSelect[index].fecha,
                    ficha: $scope.dataSelect[index].ficha,
                    actividad: $scope.dataSelect[index].actividad,
                    codigo: $scope.dataSelect[index].codigo,
                    cci: $scope.dataSelect[index].cci,
                    hora:$scope.dataSelect[index].hora,
                    nombre:$scope.dataSelect[index].nombre,
                    trabajador:$scope.dataSelect[index].nombre

                };

                $scope.jornalEdit = {

                    fecha: $scope.dataSelect[index].fecha,
                    ficha: $scope.dataSelect[index].ficha,
                    actividad: $scope.dataSelect[index].actividad,
                    codigo: $scope.dataSelect[index].codigo,
                    cci: $scope.dataSelect[index].cci,
                    hora:$scope.dataSelect[index].hora,
                    nombre:$scope.dataSelect[index].nombre,
                    trabajador:$scope.dataSelect[index].nombre

                };


               // $scope.jornalEdit = $scope.dataSelect[index];

                $("#modEditJornal").modal("show");

            };

            $scope.editJornal = function () {


                var fecha = $scope.jornalEdit.fecha.split('-');
                fecha = fecha[0]+'-'+fecha[1]+'-'+ fecha[2].substr(2,2);
                $scope.jornalEdit.fecha = fecha;

                var bandera = validarItem($scope.jornalEdit,0);
                $scope.jornalEdit.fecha = $scope.jornalSelect.fecha ;
                if(bandera==1){
                    alert('Error: todos los campos tienen que ser completados');
                }else{

                    //el scope jornalSelect es el anterior jornal y el edit es el que se acaba de editar
                    var token = $('#_token').val();
                    var usr = $('#nameUser').text();
                    $scope.jornalEdit.user = usr;
                    $scope.jornalSelect.user = usr;

                    $http.post('{{URL::route('editJornal')}}',{
                        _token:token,
                        itemAnterior: $scope.jornalSelect,
                        itemNuevo: $scope.jornalEdit

                    }).success(function (data) {

                        //alert('Operacion Correcta');

                        if(data.mensaje == 'ok'){
                            alert('Operacion Correcta');
                            $("#modEditJornal").modal("hide");
                        }else{
                            console.log(data);
                            alert('Error: '+data.mensaje);
                        }



                    }).error(function (error) {


                        console.log(error);


                    });

                }
            };

            /*--------------------------------------------------------*/

            /*esto es para eidit en el registrar*/

            $scope.updateDetail2 = function (index) {

                $scope.jornalSelect = {

                    fecha: $scope.detalles[index].fecha,
                    ficha: $scope.detalles[index].ficha,
                    actividad: $scope.detalles[index].actividad,
                    codigo: $scope.detalles[index].codigo,
                    cci: $scope.detalles[index].cci,
                    hora:$scope.detalles[index].hora,
                    nombre:$scope.detalles[index].nombre

                };


                $('#hora'+index).attr('disabled',false);
                $('#cci'+index).attr('disabled',false);
                $('#codigo'+index).attr('disabled',false);
                $('#actividad'+index).attr('disabled',false);
                console.log($scope.jornalSelect);

            };






            /*-------------------------------------*
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

                if(cadena[2]<10 || cadena[2]>99){
                    bandera = 1;
                }

                return bandera;
            }


            //cmabiar de ddmmyyyy a yyyymmdd
            function changeFormat(date) {

                date  = date.split('/');
                date = date[2]+'-'+date[1]+'-'+date[0];

                return date;

            }


            function sumarDias(fecha, dias){
                var f_fin = new Date();
                f_fin.setDate(fecha.getDate() + dias);
                return f_fin;
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