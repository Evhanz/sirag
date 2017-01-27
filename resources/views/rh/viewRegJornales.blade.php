@extends('layout')

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
                                        <tr>
                                            <td><button class="btn btn-danger btn-xs">X</button></td>
                                            <td>1</td>
                                            <td>
                                                <input style="width: 65px" type="date">
                                            </td>
                                            <!--Ficha del trabajador -->
                                            <td>
                                                <button class="btn btn-default btn-xs" title="buscar Trabajador">...</button>
                                                <input  data-type="number" data-max ="6" style="width: 3.5em" >
                                                <input  type="text" disabled  style="width: 8em">
                                            </td>
                                            <td>
                                                <button class="btn btn-default btn-xs" >...</button>
                                                <input  data-type="number" data-max ="6" style="width: 3.5em" >
                                                <input   type="text" disabled  style="width: 8em">

                                            </td>
                                            <td>
                                                <input style="width: 3em;" type="text">
                                                <input style="width: 12em;" type="text" disabled>
                                            </td>
                                            <td><input style="width: 3em;" type="text" disabled>
                                            </td>
                                            <td>
                                                <select name="" id="">
                                                    <option value="">-----------------------</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input style="width: 3em;" type="text">
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



        <!-- modal modUbigeo-->
        <div class="modal fade" id="modUbigeo" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                    </div>
                    <div class="modal-body">

                        <h3>Dirección</h3>
                        <p>@{{ ubigeo.DIRECCION }}</p>
                        <h3>Ubigeo</h3>
                        <p>@{{ ubigeo.PAIS }} - @{{ ubigeo.DEPARTAMENTO }} - @{{ ubigeo.PROVINCIA }} -@{{ ubigeo.DISTRITO }}</p>

                    </div>

                </div>
            </div>
        </div>
        <!--./ modal Detail-->



    </div>


    <!-- Daterangepicker css -->
    <link rel="stylesheet" href="{{asset('css/daterangepicker/daterangepicker-bs3.css')}}">
    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>

    <script src="{{ asset('js/plugins/angular/angular-ui-bootstrap-0.3.0.min.js') }}"></script>
    <script>

        /*funciones de jquery*/

        $('input[name="daterange"]').daterangepicker({
            format : "DD/MM/YYYY"
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
    </style>


@stop