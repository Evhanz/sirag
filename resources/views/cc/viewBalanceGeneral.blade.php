@extends('layoutCC')

@section('content')

    <!-- Daterangepicker css -->
    <link rel="stylesheet" href="{{asset('css/daterangepicker/daterangepicker-bs3.css')}}">
    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>

    <div ng-app="app" ng-controller="PruebaController">
        <div class="content"  >

            <div class="row" style="padding-left: 15px; padding-right: 15px;">
                <!-- Box (with bar chart) -->
                <div class="box box-default" >
                    <div class="box-header">
                        <ul class="nav nav-tabs" id="tab_filtros">
                            <li class="active"><a data-toggle="tab" href="#home">Centro de Costo</a></li>
                        </ul>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="row" style="padding-left: 15px;">
                            <div class="col-lg-12">
                                <div class="tab-content">
                                    <div id="home" class="tab-pane fade in active">
                                        <div class="row">
                                            <input type="hidden" id="_token" value="{{ csrf_token() }}" />

                                            <div class="col-md-4">
                                                <label>Rango de Fechas</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input class="form-control " name="daterange" id="reservation" type="text">
                                                </div><!-- /.input group -->
                                            </div>

                                            <div class="col-md-1">
                                                <label for="">Niveles</label><br>
                                                <select name="" id="nivel" class="form-control">
                                                    <option value="">----------</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="7">7</option>
                                                    
                                                </select>
                                            </div>

                                            <div class="col-md-1">
                                                <br>
                                                <button href="" class="btn btn-success" ng-click="getData()">
                                                    <i class="fa fa-search fa-lg"></i> Buscar
                                                </button>
                                            </div>
                                            <div class="col-md-1">
                                                <br>
                                                <button href="" class="btn btn-default" onclick="imprimir()">
                                                    <i class="fa fa-print fa-lg"></i> Imprimir </button>


                                            </div>

                                        </div>

                                    </div>
                                    <!-- Tab filtro documento -->

                                </div>
                            </div>
                        </div><!-- /.row - inside box -->
                    </div><!-- /.box-body -->
                    <div class="box-footer">

                    </div><!-- /.box-footer -->
                </div><!-- /.box -->


                <div class="col-lg-12">



                </div>
            </div>

            <style>
                
                th {

                    text-align: center; 

                }
                thead{

                    font-size: 12px;

                }

            </style>

            <div class="row">
                <div class="col-lg-12">
                    <!-- Box (with bar chart) -->
                    <div class="box box-info" id="box_maestro">
                        <div class="box-header">
                            <!-- tools box -->
                        </div><!-- /.box-header -->
                        <div class="box-body ">
                         
                             <div class="row" style="padding: 15px">
                                <div class="table-responsive" style="overflow: auto">
                                    <table class="table table-bordered" id="table_data_op1">
                                        <thead style="text-align: center;">
                                        <tr>
                                            <th rowspan="3 "> <p>CODIGO</p></th>
                                            <th rowspan="3">DENOMINACION</th>
                                            <th rowspan="2" colspan="2">SALDOS INICIALES</th>
                                            <th rowspan="2" colspan="2">MOVIMIENTO</th>
                                            <th rowspan="2" colspan="2">SALDOS FINALES</th>
                                            <th colspan="2">SALDOS FINALES DEL BALANCE GENERAL</th>
                                            <th colspan="2">SALDOS ESTADO DE PERDIDAS Y GANANCIAS</th>
                                            <th colspan="2">SALDOS ESTADO DE PERDIDAS Y GANANCIAS</th>
                                            
                                        </tr>
                                        <tr style="font-size: 10px; ">
                                            <th colspan="2" style="text-align: center;">PASIVO Y</th>
                                            <th colspan="2">FUNCION</th>
                                            <th colspan="2">NATURALEZA</th>
                                        </tr>
                                        <tr>
                                            <th>DEUDOR</th>
                                            <th>ACEEDOR</th>
                                            <th>DEBE</th>
                                            <th>HABER</th>
                                            <th>DEUDOR</th>
                                            <th>ACEEDOR</th>
                                            <th>ACTIVO</th>
                                            <th>PATRIMONIO</th>
                                            <th>PÉRDIDAS</th>
                                            <th>GANANCIAS</th>
                                            <th>PÉRDIDAS</th>
                                            <th>GANANCIAS</th>
                                        </tr>
                                        </thead>
                                        <tbody >


                                        <tr  ng-repeat=" item in Documentos | filter:search" id="tr_Doc_@{{ item.FICHA }}">
                                            <td>@{{ item.CUENTA }}</td>
                                            <td>@{{ item.DESCRIPCION }}</td>
                                            <td>@{{ item.SI_DEUDOR }}</td>
                                            <td>@{{ item.SI_ACREEDOR }}</td>
                                            <td>@{{ item.MOV_DEBE }}</td>
                                            <td>@{{ item.MOV_HABER }}</td>
                                            <td>@{{ item.SF_D }}</td>
                                            <td>@{{ item.SF_H }}</td>                                
                                           
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                TOTALES
                                            </td>
                                            <td>@{{ totales.total_SI_DEUDOR }}</td>
                                            <td>@{{ totales.total_SI_ACREEDOR}}</td>
                                            <td>@{{ totales.total_MOV_DEBE}}</td>
                                            <td>@{{ totales.total_MOV_HABER }}</td>
                                            <td>@{{ totales.total_SF_DEUDOR }}</td>
                                            <td>@{{ totales.total_SF_ACREEDOR }}</td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>

                            </div><!-- /.row - inside box -->

                        </div><!-- /.box-body -->
                    </div><!-- /.box -->

                </div>

            </div>

        </div>



    </div>




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




        /*----*/



        function imprimir()  {

            var fecha = $('input[name="daterange"]').val();

            fecha = fecha.split('-');
            var f_i = changeFormat(fecha[0]);
            var f_f = changeFormat(fecha[1]);

            $(".pvtTable").printThis({
                importCSS: true,
                loadCSS: "{{ asset('css/table_export.css')}}",
                header: "<h2>Reporte de centro de costos del :"+f_i+" al" +f_f+"  </h2>"
            });
        }


       

        /**/


        var app = angular.module("app", []);
        app.controller("PruebaController", function($scope,$http,$window) {

            $scope.s = "a";
            //Declaraciones

            $scope.Documentos= [{}];
            $scope.tipodocts = [{}];

            $scope.totales = {};

            var ruta = '';


            //funcioines que inician la pagina



           
            $scope.getData =  function ()
            {

                var token = $('#_token').val();
                var f_inicio ="";
                var f_fin = "";
                var nivel = $("#nivel").val();

                var fecha_s_format = $('#reservation').val();

                fecha_s_format=fecha_s_format.split("-");

                f_inicio = formatDateToText(fecha_s_format[0]);
                f_fin = formatDateToText(fecha_s_format[1]);

                var ruta = '{{ URL::route('getBalanceByNivelesApi') }}';

                $('#btnBuscarDoc').attr("disabled", true);
                $scope.Documentos = [];
                $("#box_maestro").append("<div class='overlay'></div><div class='loading-img'></div>");

                
                $http.post(ruta,{_token : token,
                            f_i:f_inicio,
                            f_f: f_fin,
                            nivel:nivel
                        })
                        .success(function(data){

                            $scope.Documentos = data.items;
                            //console.log(data);

                            $scope.totales.total_SI_DEUDOR = data.total_SI_DEUDOR;
                            $scope.totales.total_SI_ACREEDOR = data.total_SI_ACREEDOR;
                            $scope.totales.total_MOV_DEBE = data.total_MOV_DEBE;
                            $scope.totales.total_MOV_HABER = data.total_MOV_HABER;
                            $scope.totales.total_SF_DEUDOR = data.total_SF_DEUDOR;
                            $scope.totales.total_SF_ACREEDOR = data.total_SF_ACREEDOR;


                            $('#btnBuscarDoc').attr("disabled", false);

                            $( "div" ).remove( ".overlay" );
                            $( "div" ).remove( ".loading-img" );


                        }).error(function(data) {
                    console.log(data);
                    $("#box_maestro").remove(".overlay");
                    $("#box_maestro").remove(".loading-img");
                });
                
            };

            



            /*funcion helper*/


            function formatDateToText(fecha) {
                // body...

                fecha = fecha.split("/");
                fecha = fecha[2].trim()+""+fecha[1].trim()+""+fecha[0].trim();
                return fecha;

            }




        });
    </script>


@stop