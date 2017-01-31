@extends('layout')

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

                                    <div class="col-lg-4">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <input type="checkbox" class="form-control" id="codigo_check" style="padding: 0px; margin: 0px;">
                                                <label for="">Código de Trabajador</label>

                                            </div>
                                            <div class="col-lg-6">

                                                <input class="form-control" type="radio" id="tipo_periodo" name="tipo_periodo"
                                                       value="periodo" checked> Perioddo<br>
                                                <input class="form-control" type="radio" id="tipo_periodo" name="tipo_periodo"
                                                       value="fechas" checked> Rango de fechas<br>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">

                                        <button class="btn btn-success" id="btnNuevo" ng-click="newRegDetails()"> <i class="fa fa-disk"></i> Nuevo </button>
                                        <button class="btn btn-info" id="btnGuardar" disabled> <i class="fa fa-disk"></i> Guardar </button>

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

            <div class="row">
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
                                            <td><button class="btn btn-danger btn-xs">X</button></td>
                                            <td>1</td>
                                            <td>
                                                <input class="datepicker" style="width: 65px" ng-click="clickFecha()">
                                            </td>
                                            <!--Ficha del trabajador -->
                                            <td>
                                                <button class="btn btn-default btn-xs" title="buscar Trabajador" ng-click="getModEmpleado()">
                                                    ...</button>
                                                <input  data-type="number" data-max ="6" style="width: 3.5em" >
                                                <input  type="text" disabled  style="width: 8em">
                                            </td>
                                            <td>
                                                <button class="btn btn-default btn-xs" ng-click="getModCCostoInterno()">...</button>
                                                <input  data-type="number" data-max ="6" style="width: 3.5em" >
                                                <input   type="text" disabled  style="width: 8em">

                                            </td>
                                            <td>
                                                <input ng-model="codigo" ng-keyup="getLabor($event,codigo)" style="width: 3em;" type="text">
                                                <input style="width: 12em;" type="text" ng-model="labor_desc" disabled>
                                            </td>
                                            <td><input style="width: 3em;" type="text" disabled>
                                            </td>
                                            <td>
                                                <select name="" id="">
                                                    <option value="">-----------------------</option>
                                                    <option ng-repeat="item in codigoActividad" value=" item.codigo">
                                                        @{{ item.codigo }}
                                                    </option>
                                                </select>
                                            </td>
                                            <td>
                                                <input class="number_horas"  style="width: 7em;" type="number">
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

                        <div class="row">

                            <div class="col-xs-12">
                                <table class="table table-bordered" id="dataModPersonal">
                                    <thead>
                                    <tr>
                                        <td><input type="text" ng-model="filModEmpleado.ficha"></td>
                                        <td><input type="text" ng-model="filModEmpleado.dni"></td>
                                        <td><input type="text" ng-model="filModEmpleado.nombre"></td>
                                    </tr>
                                    <tr>
                                        <th>Ficha</th>
                                        <th>Empleado</th>
                                        <th>Nombre</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr ng-repeat="item in modPersonal | filter:filModEmpleado">

                                        <td>@{{item.ficha}}</td>
                                        <td>@{{item.dni}}</td>
                                        <td>@{{item.nombre}}</td>
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
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr ng-repeat="item in modCCostoInterno | filter:filModCCI">
                                        <td>@{{item.CODIGO}}</td>
                                        <td>@{{item.DESCRIPCION}}</td>
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

    <div>
        <input class="datepicker"  type="text">
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

        $("#data tbody tr td .datepicker").on("load", function(event){
            alert('a');
        });




        $('[data-toggle="tooltip"]').tooltip();
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

            getCodigoActividad();


            $scope.getModEmpleado = function () {

                $("#modPersonal").modal('show');

                var token = $('#_token').val();

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


            $scope.getModCCostoInterno = function () {

                $("#modCCostoInterno").modal('show');

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

            $scope.getLabor = function(evento,codigo){

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
                                    $scope.labor_desc = data.DESCRIPCION;
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


                $scope.detalles.push(detail);



            };

            $scope.loadFecha = function () {

              //  alert('as');

                $('.datepicker').datepicker({
                    format: 'dd/mm/yyyy'
                });


            };




            

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